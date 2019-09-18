<?php

/**
 * Plugin Name:       SWS Login Blocker
 * Plugin URI:        https://ccharacter.com/custom-plugins/sws-login-blocker/
 * Description:       Redirect users away from login page based on IP address
 * Version:           2.20
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sharon Stromberg
 * Author URI:        https://ccharacter.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sws-login-blocker
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define('BASE_PATH', plugin_dir_path(__FILE__));
define('BASE_URL', plugin_dir_url(__FILE__));

require_once BASE_PATH.'inc/classes.php';

require_once BASE_PATH.'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/ccharacter/pl-json/master/sws-login-blocker.json',
	__FILE__,
	'sws-login-blocker'
);
$myUpdateChecker->setAuthentication('16c18e9f074adfe9e3373fa333e7ba16b7078450');
$myUpdateChecker->setBranch('master');
$myUpdateChecker->getVcsApi()->enableReleaseAssets();

$myLoginBlocker = new swsLoginBlocker();
$myLoginBlocker->init();

?>