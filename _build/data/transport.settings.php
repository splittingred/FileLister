<?php
/**
 * FileLister
 *
 * Copyright 2010 by Shaun McCormick <shaun@modxcms.com>
 *
 * This file is part of FileLister, a file listing Extra.
 *
 * FileLister is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * FileLister is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * FileLister; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package filelister
 */
/**
 * System Settings for FileLister
 *
 * @package filelister
 * @subpackage build
 */
$settings = array();

$settings['filelister.allow_root_paths']= $modx->newObject('modSystemSetting');
$settings['filelister.allow_root_paths']->fromArray(array(
    'key' => 'filelister.allow_root_paths',
    'value' => false,
    'xtype' => 'combo-boolean',
    'namespace' => 'filelister',
    'area' => 'Security',
),'',true,true);

$settings['filelister.ipinfodb_api_key']= $modx->newObject('modSystemSetting');
$settings['filelister.ipinfodb_api_key']->fromArray(array(
    'key' => 'filelister.ipinfodb_api_key',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'filelister',
    'area' => 'Geolocation',
),'',true,true);

$settings['filelister.salt']= $modx->newObject('modSystemSetting');
$settings['filelister.salt']->fromArray(array(
    'key' => 'filelister.salt',
    'value' => 'In dreams begins responsibility.',
    'xtype' => 'textfield',
    'namespace' => 'filelister',
    'area' => 'Security',
),'',true,true);

return $settings;