<?php

/**
 * Plugin Name:       SWS Login Blocker
 * Plugin URI:        https://ccharacter.com/custom-plugins/sws-login-blocker/
 * Description:       Redirect users away from login page based on IP address
 * Version:           3.0
 * Requires at least: 5.2
 * Requires PHP:      5.2
 * Author:            Sharon Stromberg
 * Author URI:        https://ccharacter.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sws-login-blocker
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once plugin_dir_path(__FILE__).'inc/classes.php';
require_once plugin_dir_path(__FILE__).'func_spreadsheet.php';

require_once plugin_dir_path(__FILE__).'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/ccharacter/sws-login-blocker/master/plugin.json',
	__FILE__,
	'sws-login-blocker'
);





$myLoginBlocker = new swsLoginBlocker();
$myLoginBlocker->init();

?>