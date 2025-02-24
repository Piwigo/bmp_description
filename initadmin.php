<?php
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

global $prefilter;

add_event_handler('get_batch_manager_prefilters', 'BMPD_add_batch_manager_prefilters');
add_event_handler('perform_batch_manager_prefilters', 'BMPD_perform_batch_manager_prefilters', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);

function BMPD_add_batch_manager_prefilters($prefilters)
{
	array_push($prefilters, array(
		'ID' => 'BMPD',
		'NAME' => l10n('With no description'),
	));
	return $prefilters;
}

function BMPD_perform_batch_manager_prefilters($filter_sets, $prefilter)
{
	if ($prefilter == 'BMPD') {
		$query = 'SELECT id FROM ' . IMAGES_TABLE . ' WHERE comment is null;';
		$filter_sets[] = array_from_query($query, 'id');
	}
	return $filter_sets;
}

add_event_handler('get_batch_manager_prefilters', 'BMPD2_add_batch_manager_prefilters');
add_event_handler('perform_batch_manager_prefilters', 'BMPD2_perform_batch_manager_prefilters', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);

function BMPD2_add_batch_manager_prefilters($prefilters)
{
	array_push($prefilters, array(
		'ID' => 'BMPD2',
		'NAME' => l10n('With description'),
	));
	return $prefilters;
}

function BMPD2_perform_batch_manager_prefilters($filter_sets, $prefilter)
{
	if ($prefilter == 'BMPD2') {
		$query = 'SELECT id FROM ' . IMAGES_TABLE . ' WHERE comment is not null ;';
		$filter_sets[] = array_from_query($query, 'id');
	}
	return $filter_sets;
}

add_event_handler('loc_end_element_set_global', 'BMPD_loc_end_element_set_global');
add_event_handler('element_set_global_action', 'BMPD_element_set_global_action', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);

function BMPD_loc_end_element_set_global()
{
	global $template, $pwg_loaded_plugins;
	if (isset($pwg_loaded_plugins['ExtendedDescription'])) {
		$templatebmpd = '
		<input type="checkbox" name="check_BMPD4" id="input_BMPD4"> ' . l10n('remove description') . '<br>
		<textarea rows="5" cols="50" placeholder="' . l10n('Type here the description') . "  /  " . l10n('Use Extended Description tags...') . '" class="description" name="BMPD3" id="BMPD3"></textarea><br>
	  ';
	} else {
		$templatebmpd = '
		<input type="checkbox" name="check_BMPD4" id="input_BMPD4"> ' . l10n('remove description') . '<br>
		<textarea rows="5" cols="50" placeholder="' . l10n('Type here the description') . '" class="description" name="BMPD3" id="BMPD3"></textarea><br>
	  ';
	}
	$template->func_combine_script(array(
		"id" => "bmp_common",
		"load" => "footer",
		"path" => BMPD_PATH.'/bmp.js'
	));
	$template->append('element_set_global_plugins_actions', array(
		'ID' => 'BMPD3',
		'NAME' => l10n('Set description'),
		'CONTENT' => $templatebmpd,
	));
}

function BMPD_element_set_global_action($action, $collection)
{
	if ($action == 'BMPD3')
	{
		global $page;

		if (isset($_POST['check_BMPD4']))
		{
			$_POST['BMPD3'] = null;
		}
		$datas = array();
		foreach ($collection as $image_id)
		{
			array_push(
				$datas,
				array(
					'id' => $image_id,
					'comment' => $_POST['BMPD3']
				)
			);
		}
		mass_updates(
			IMAGES_TABLE,
			array('primary' => array('id'), 'update' => array('comment')),
			$datas
		);
	}
}
