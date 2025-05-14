<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

/**
 * This class is used to expose maintenance methods to the plugins manager
 * It must extends PluginMaintain and be named "PLUGINID_maintain"
 * where PLUGINID is the directory name of your plugin.
 */
class resize_excluder_maintain extends PluginMaintain
{
  private $default_conf = array(
    'excluded_group' => null,
  );

  private $table;
  private $dir;

  function __construct($plugin_id)
  {
    parent::__construct($plugin_id);

    global $prefixeTable;

    $this->table = $prefixeTable . 'resize_excluder';
    $this->dir = PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'resize_excluder/';
  }

  /**
   * Plugin installation
   *
   * Perform here all needed step for the plugin installation such as create default config,
   * add database tables, add fields to existing tables, create local folders...
   */
  function install($plugin_version, &$errors=array())
  {
    global $conf;

    if (empty($conf['resize_excluder']))
    {
      conf_update_param('resize_excluder', $this->default_conf, true);
    }
    else
    {
      $old_conf = safe_unserialize($conf['resize_excluder']);

      conf_update_param('resize_excluder', $old_conf, true);
    }
  }

  /**
   * Plugin activation
   *
   * This function is triggered after installation, by manual activation or after a plugin update
   * for this last case you must manage updates tasks of your plugin in this function
   */
  function activate($plugin_version, &$errors=array())
  {
  }

  /**
   * Plugin deactivation
   *
   * Triggered before uninstallation or by manual deactivation
   */
  function deactivate()
  {
  }

  /**
   * Plugin (auto)update
   *
   * This function is called when Piwigo detects that the registered version of
   * the plugin is older than the version exposed in main.inc.php
   * Thus it's called after a plugin update from admin panel or a manual update by FTP
   */
  function update($old_version, $new_version, &$errors=array())
  {
    $this->install($new_version, $errors);
  }

  /**
   * Plugin uninstallation
   *
   * Perform here all cleaning tasks when the plugin is removed
   * you should revert all changes made in 'install'
   */
  function uninstall()
  {
    // delete configuration
    conf_delete_param('resize_excluder');
  }
}