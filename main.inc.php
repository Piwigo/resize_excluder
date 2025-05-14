<?php
/*
Plugin Name: Resize excluder
Version: auto
Description: Exclude a group from the resize after upload setting.
Plugin URI: auto
Author: HWFord
Author URI: https://github.com/HWFord
Has Settings: true
*/

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

if (basename(dirname(__FILE__)) != 'resize_excluder')
{
  add_event_handler('init', 'esize_excluder_error');
  function resize_excluder_error()
  {
    global $page;
    $page['errors'][] = 'Resize excluder folder name is incorrect, uninstall the plugin and rename it to "resize_excluder"';
  }
  return;
}

// +-----------------------------------------------------------------------+
// | Define plugin constants                                               |
// +-----------------------------------------------------------------------+
global $prefixeTable;

define('RESIZE_EXCLUDER_ID',      basename(dirname(__FILE__)));
define('RESIZE_EXCLUDER_PATH' ,   PHPWG_PLUGINS_PATH . RESIZE_EXCLUDER_ID . '/');
define('RESIZE_EXCLUDER_DIR',     PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'resize_excluder/');
define('RESIZE_EXCLUDER_ADMIN',   get_root_url() . 'admin.php?page=plugin-resize_excluder');

/**
 * plugin initialization
 *   - check for upgrades
 *   - unserialize configuration
 *   - load language
 */
add_event_handler('init', 'resize_excluder_init');

function resize_excluder_init()
{
  global $conf, $user;

  // load plugin language file
  load_language('plugin.lang', RESIZE_EXCLUDER_PATH);

  // prepare plugin configuration
  $conf['resize_excluder'] = safe_unserialize($conf['resize_excluder']);
}

//Get upload event
add_event_handler('upload_file', 'resize_excluder_upload_file');

function resize_excluder_upload_file($representative_ext, $file_path)
{
  disable_original_resize();

  return $representative_ext;
}

/**
 * Add prefilter to photos_add to avoid resize message if user is in excluded group
 */
add_event_handler('loc_begin_admin_page', 'resize_excluder_loc_begin_admin_page', EVENT_HANDLER_PRIORITY_NEUTRAL);

function resize_excluder_loc_begin_admin_page()
{
  if (!isset($_GET['page']) or $_GET['page'] != 'photos_add')
  {
    return;
  }

  disable_original_resize();
}

/**
 * check if user is in group to be excluded from resize, if true set original_resize to false
 */
function disable_original_resize()
{
  global $conf, $user;

  if (!empty($conf['resize_excluder']['excluded_group']))
  {  
    $query = '
SELECT
    COUNT(*)
  FROM '.USER_GROUP_TABLE.'
  WHERE group_id = '.$conf['resize_excluder']['excluded_group'].'
    AND user_id = '.$user['id'].'
;';
    
    list($counter) = pwg_db_fetch_row(pwg_query($query));

    if ($counter > 0)
    {
      $conf['original_resize'] = false;
    }
  }
}
