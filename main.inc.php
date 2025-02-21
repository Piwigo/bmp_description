<?php
/*
Plugin Name: Batch Manager, Description
Version: auto
Description: Batch Manager, Add Prefilter with / with no description and add action on description
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=695
Author: ddtddt
Author URI: http://temmii.com/piwigo/
*/

// +-----------------------------------------------------------------------+
// | Batch Manager, Photo Description by plugin for Piwigo by TEMMII       |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2013-2023 ddtddt               http://temmii.com/piwigo/ |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $prefixeTable, $template;

define('BMPD_DIR' , basename(dirname(__FILE__)));
define('BMPD_PATH' , PHPWG_PLUGINS_PATH . BMPD_DIR . '/');

add_event_handler('loading_lang', 'batch_manager_photo_description_loading_lang');	  
function batch_manager_photo_description_loading_lang(){
  load_language('plugin.lang', BMPD_PATH);
}

// Plugin for admin
if (script_basename() == 'admin'){
  include_once(dirname(__FILE__).'/initadmin.php');
}

?>