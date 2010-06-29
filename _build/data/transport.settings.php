<?php
/**
 * Fileo
 *
 * Copyright 2009-2010 by Shaun McCormick <shaun@modxcms.com>
 *
 * Fileo is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * Fileo is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Fileo; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package formit
 */
/**
 * System Settings for Fileo
 *
 * @package fileo
 * @subpackage build
 */
$settings = array();

$settings['fileo.allow_root_paths']= $modx->newObject('modSystemSetting');
$settings['fileo.allow_root_paths']->fromArray(array(
    'key' => 'fileo.allow_root_paths',
    'value' => false,
    'xtype' => 'combo-boolean',
    'namespace' => 'fileo',
    'area' => 'Security',
),'',true,true);

$settings['fileo.salt']= $modx->newObject('modSystemSetting');
$settings['fileo.salt']->fromArray(array(
    'key' => 'fileo.salt',
    'value' => 'In dreams begins responsibility.',
    'xtype' => 'textfield',
    'namespace' => 'fileo',
    'area' => 'Security',
),'',true,true);

return $settings;