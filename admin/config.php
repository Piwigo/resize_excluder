<?php
defined('RESIZE_EXCLUDER_PATH') or die('Hacking attempt!');

include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');

// +-----------------------------------------------------------------------+
// | Check Access and exit when user status is not ok                      |
// +-----------------------------------------------------------------------+

check_status(ACCESS_ADMINISTRATOR);

// +-----------------------------------------------------------------------+
// |Actions                                                                |
// +-----------------------------------------------------------------------

if (!empty($_POST))
{
  check_input_parameter('resize_excluder_excluded_group', $_POST, false, PATTERN_ID);

  $conf['resize_excluder'] = array(
    'excluded_group' => $_POST['excluded_group'],
  );

  conf_update_param('resize_excluder', $conf['resize_excluder']);

  $template->assign(
    array(
      'save_success' =>l10n('Settings saved'),
    )
  );
}
// +-----------------------------------------------------------------------+
// | template init                                                         |
// +-----------------------------------------------------------------------+

// Check if resize after upload isset
if (!$conf['original_resize'])
{
  $page['warnings'][] = 'The resize after upload setting isn\'t active. This plugin will have no effect';
}

//Get list of groups
$query = '
SELECT
    id,
    name
  FROM `'.GROUPS_TABLE.'`
;';
$groups = query2array($query, 'id', 'name');
natcasesort($groups);

//Assign template variables
$template->assign(
array(
  'group_options' => $groups,
  'excluded_group'=> $conf['resize_excluder']['excluded_group'] ?? null,
  )
);

$template->set_filename('resize_excluder_content', realpath(RESIZE_EXCLUDER_PATH . 'admin/template/config.tpl'));