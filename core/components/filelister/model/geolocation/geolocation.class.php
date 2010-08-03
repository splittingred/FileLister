<?php
/**
* IPInfoDB geolocation API class
* http://ipinfodb.com/ip_location_api.php
* Bug report : http://forum.ipinfodb.com/viewforum.php?f=7
* Updated April 17 2010
* @version 1.3
* @author Marc-Andre Caron - IPInfoDB -  http://www.ipinfodb.com
* @license http://www.gnu.org/copyleft/lesser.html LGPL
*/
class geolocation
{
  //------------------------------------------------------------
  // PROPERTIES
  //------------------------------------------------------------

  //--Protected properties--//

  /**
  * The main API domain
  * @var string
  * @access protected
  */
  protected $_apiDomain = 'ipinfodb.com';
  
  /**
  * The backup API domain
  * @var string
  * @access protected
  */
  protected $_apiBackupDomain = 'backup.ipinfodb.com';
  
  /**
  * The IP array
  * @var array
  * @access protected
  */
  protected $_ips = array();
  
  /**
  * The errors array
  * @var array
  * @access protected
  */
  protected $_errors = array();
  
  /**
  * The IP geolocation
  * @var array
  * @access protected
  */
  protected $_geolocation = array();
  
  /**
  * The IP geolocation
  * @var array
  * @access protected
  */
  protected $_cityPrecision;
  
  /**
  * If the server is on IPInfoDB whitelist or not
  * @var bool
  * @access protected
  */
  protected $_whitelist = false;
  
  /**
  * Show timezone data or not
  * @var array
  * @access protected
  */
  protected $_showTimezone = false;

  //--Constants--//
  
  const IP_QUERY = 'ip_query.php';
  const IP_QUERY_COUNTRY = 'ip_query_country.php';
  const IP_QUERY2 = 'ip_query2.php';
  const IP_QUERY2_COUNTRY = 'ip_query2_country.php';
  
  const IP_ERROR = 'is an invalid IP address  (eg : 123.123.123.123)';
  const IP_ARRAY_ERROR = 'IPs must be an array  (eg : array(123.123.123.123, 124.124.124.124)';
  const DOMAIN_ERROR = 'is an invalid domain name (eg : example.com)';
  const NONE_SPECIFIED = 'No IP or domain specified';
  const CONNECT_ERROR = 'Could not connect to API server. Will try backup server';
  const CONNECT_BACKUP_ERROR = 'Could not connect to backup API server.';


  //------------------------------------------------------------
  // METHODS
  //------------------------------------------------------------

  //--Public methods--//
  /**
  * Class constructor
  * Set if the query should get city or country precision
  * @param bool $cityPrecision True for city precision, false for country precision
  * @access public
  * @return	void
  */
  public function __construct($cityPrecision)
  {
    $this->_cityPrecision = (bool)$cityPrecision;
  }

	// --------------------------------------------------------------------

  /**
  * Set IP address
  * @param string $ip The ip address
  * @param bool $test To test if the IP is valid or not
  * @access public
  * @return	void
  */
  public function setIP($ip, $test = false)
  {
    //Test IP if required
    if ($test) {
      if (!preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ip)) {
        $this->_setError(new Exception($ip . ' ' . self::IP_ERROR));
        return;
      }
    }
    
    $this->_ips[] = $ip;
  }

	// --------------------------------------------------------------------

  /**
  * Set multiple IP addresses
  * @param array $ips The ip address
  * @param bool $test To test if the IP is valid or not
  * @access public
  * @return	void
  */
  public function setIPs($ips, $test = false)
  {
    //Make sure IP list is an array
    if (!is_array($ips)) {
      $this->_setError(new Exception(self::IP_ARRAY_ERROR));
      return;
    }
    
    //Test IP if required
    if ($test) {
      foreach($ips as $ip) {
        if (!preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ip)) {
          $this->_setError(new Exception($ip . ' ' . self::IP_ERROR));
          return;
        }
      }
    }
    
    foreach ($ips as $ip) {
      $this->_ips[] = $ip;
    }
  }

	// --------------------------------------------------------------------

  /**
  * Set domain
  * @param string $domain The domain name
  * @param bool $test To test if the domain is valid or not
  * @access public
  * @return	void
  */
  public function setDomain($domain, $test = false)
  {
    //Test domain if required
    if ($test) {
      if (!preg_match ("/^[a-z0-9][a-z0-9\-]+[a-z0-9](\.[a-z]{2,4})+$/i", $domain)) {
        $this->_setError(new Exception($domain . ' ' . self::DOMAIN_ERROR));
        return;
      }
    }
    
    $this->_ips[] = gethostbyname($domain);
  }
    
	// --------------------------------------------------------------------

  /**
  * Set file_get_contents timeout
  * @param int $timeout Timeout in seconds
  * @access public
  * @return	void
  */
  public function setTimeout($timeout)
  {
    $timeout = (int)$timeout;
    if ($timeout > 0) {
      ini_set('default_socket_timeout', $timeout);
    }
  }
    
	// --------------------------------------------------------------------

  /**
  * Set main query server to US server
  * @access public
  * @return	void
  */
  public function useUSServer()
  {
      $this->_apiBackupDomain = $this->_apiDomain;
      $this->_apiDomain = 'us.ipinfodb.com';
  }

	// --------------------------------------------------------------------

  /**
  * Set if the server is on the whitelist or not
  * @param bool $enabled If the server is on the whitelist or not
  * @access public
  * @return	void
  */
  public function setWhitelist($enabled)
  {
    $this->_whitelist = (bool)$enabled;
  }

	// --------------------------------------------------------------------

  /**
  * Show timezone data
  * @param bool $val Show timezone data or not
  * @access public
  * @return	void
  */
  public function showTimezone($val)
  {
    $this->_showTimezone = (bool)$val;
  }

	// --------------------------------------------------------------------

  /**
  * Get geolocation as an array
  * @access public
  * @return	array
  */
  public function getGeoLocation() {
    //Make sure IPs and/or domains are specified
    if (empty($this->_ips)) {
      $this->_setError(new Exception(self::NONE_SPECIFIED));
      return array();
    }
    
    //Check if ip_query.php or ip_query2.php to be used
    $singleLookup = (empty($this->_domains) && (count($this->_ips) == 1)) ? true : false;
    
    switch ($singleLookup) {
    case true:
      //Use ip_query
      $this->_query();
      break;
      
    case false:
      //Use ip_query2 for domain or multiple lookups
      
      //Split IP array by 25
      $k = 0;
      $ipsSplit = array();
      for ($i=0; $i<count($this->_ips); $i++) {
        if (!(($i+1) % 25)) $k++;
        $ipsSplit[$k][] = $this->_ips[$i];
      }
      
      //Do multiple queries if required
      for ($i=0;$i<count($ipsSplit);$i++) {
        //Sleep for 0.5s after each request (after 1st one) if not on the whitelist
        if (!$this->_whitelist && $i > 0) {
          usleep(500000);
        }
        
        //Do the request
        if (count($ipsSplit[$i])) {
          $this->_query2($ipsSplit[$i]);
        }
      }
    
      //Unset $ipsSplit 
      unset($ipsSplit);
      
      break;
    }
    
    return $this->_geolocation;
  }

	// --------------------------------------------------------------------

  /**
  * Get the errors
  * @access public
  * @return	void
  */
  public function getErrors() {
    return $this->_errors;
  }

	// --------------------------------------------------------------------

  //--protected methods--//

  /**
  * Single IP query
  * @access protected
  * @return	void
  */
  protected function _query() {
    //Select the proper API
    $api = $this->_cityPrecision ? self::IP_QUERY : self::IP_QUERY_COUNTRY;
    
    //Connect to IPInfoDB
    $showTimezone = $this->_showTimezone ? 'true' : 'false';
    if (!($d = @file_get_contents("http://" . $this->_apiDomain . "/$api?ip={$this->_ips[0]}&timezone=$showTimezone"))) {
      $this->_setError(new Exception(self::CONNECT_ERROR));
      //Try backup server
      if (!($d = @file_get_contents("http://" . $this->_apiBackupDomain . "/$api?ip={$this->_ips[0]}&timezone=$showTimezone"))) {
        $this->_setError(new Exception(self::CONNECT_BACKUP_ERROR));
        return;
      }
    }
    
   try {
      $answer = @new SimpleXMLElement($d);
    } catch(Exception $e) {
      $this->_setError($e);
      return;
    }
    
    foreach($answer as $field => $val) {
      $this->_geolocation[0][(string)$field] = (string)$val;
    }
  }

	// --------------------------------------------------------------------

  /**
  * Multiple IP query
  * @param array $ipsSplit The ips array (max 25)
  * @access protected
  * @return	void
  */
  protected function _query2($ipsSplit) {
    //Select the proper API
    $api = $this->_cityPrecision ? self::IP_QUERY2 : self::IP_QUERY2_COUNTRY;
    
    //Separate all IPs with a comma
    $ipsCs = implode(",", $ipsSplit);
    
    //Connect to IPInfoDB
    $showTimezone = $this->_showTimezone ? 'true' : 'false';
    if (!($d = @file_get_contents("http://" . $this->_apiDomain . "/$api?ip=$ipsCs&timezone=$showTimezone"))) {
      $this->_setError(new Exception(self::CONNECT_ERROR));
      //Try backup server
      if (!($d = @file_get_contents("http://" . $this->_apiBackupDomain . "/$api?ip=$ipsCs&timezone=$showTimezone"))) {
        $this->_setError(new Exception(self::CONNECT_BACKUP_ERROR));
        return;
      }
    }
    
    try {
      $answer = @new SimpleXMLElement($d);
    } catch(Exception $e) {
      $this->_setError($e);
      return;
    }
    
    //Add them to _geolocation
    foreach($answer->Location as $key => $ipData) {
      foreach($ipData as $field => $val) {
        $location[(string)$field] = (string)$val;
      }
      $this->_geolocation[] = $location;
      unset($location);
    }
  }

	// --------------------------------------------------------------------

  /**
  * Set error
  * @param string $msg The error message
  * @access protected
  * @return	void
  */
  protected function _setError($msg) {
    $exceptionMessage = "{$msg->getMessage()} in {$msg->getFile()}({$msg->getLine()})\n";
    $exceptionTrace = "Trace : {$msg->getTraceAsString()}";
    $this->_errors[] = $exceptionMessage . $exceptionTrace;
  }
}
