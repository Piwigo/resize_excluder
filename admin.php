<?php
defined('RESIZE_EXCLUDER_PATH') or die('Hacking attempt!');

global $template, $page, $conf;

include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');

define('RESIZE_EXCLUDER_BASE_URL', get_root_url().'admin.php?page=plugin-resize_excluder');

// get current tab
$page['tab'] = isset($_GET['tab']) ? $_GET['tab'] : $page['tab'] = 'config';

//tabsheet
$tabsheet = new tabsheet();
$tabsheet->set_id('resize_excluder');

$tabsheet->add('config', l10n('Configuration'), RESIZE_EXCLUDER_ADMIN . '-config');
$tabsheet->select($page['tab']);
$tabsheet->assign();

// include page
include(RESIZE_EXCLUDER_PATH . 'admin/' . $page['tab'] . '.php');

// send page content
$template->assign_var_from_handle('ADMIN_CONTENT', 'resize_excluder_content');

?>