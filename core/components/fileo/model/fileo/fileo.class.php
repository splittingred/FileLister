<?php
/**
 * @package Fileo
 */
class Fileo {
    /**
     * Fileo constructor
     *
     * @param modX &$modx A reference to the modX instance.
     * @param array $config An array of configuration options. Optional.
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        /* allows you to set paths in different environments
         * this allows for easier SVN management of files
         */
        $corePath = $this->modx->getOption('fileo.core_path',null,MODX_CORE_PATH.'components/fileo/');
        $assetsPath = $this->modx->getOption('fileo.assets_path',null,MODX_ASSETS_PATH.'components/fileo/');
        $assetsUrl = $this->modx->getOption('fileo.assets_url',null,MODX_ASSETS_URL.'components/fileo/');

        /* loads some default paths for easier management */
        $this->config = array_merge(array(
            'corePath' => $corePath,
            'modelPath' => $corePath.'model/',
            'chunksPath' => $corePath.'elements/chunks/',
            'snippetsPath' => $corePath.'elements/snippets/',
            'controllersPath' => $corePath.'controllers/',

            'assetsPath' => $assetsPath,
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl.'css/',
            'jsUrl' => $assetsUrl.'js/',
        ),$config);

        $this->modx->addPackage('fileo',$this->config['modelPath']);
        $this->modx->lexicon->load('fileo:default');
    }

    /**
     * Gets a Chunk and caches it; also falls back to file-based templates
     * for easier debugging.
     *
     * @access public
     * @param string $name The name of the Chunk
     * @param array $properties The properties for the Chunk
     * @return string The processed content of the Chunk
     */
    public function getChunk($name,$properties = array(),$suffix = '.chunk.tpl') {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->modx->getObject('modChunk',array('name' => $name),true);
            if (empty($chunk)) {
                $chunk = $this->_getTplChunk($name,$suffix);
                if ($chunk == false) return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }
    /**
     * Returns a modChunk object from a template file.
     *
     * @access private
     * @param string $name The name of the Chunk. Will parse to name.chunk.tpl
     * @return modChunk/boolean Returns the modChunk object if found, otherwise
     * false.
     */
    private function _getTplChunk($name,$suffix = '.chunk.tpl') {
        $chunk = false;
        $f = $this->config['chunksPath'].strtolower($name).$suffix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }
}