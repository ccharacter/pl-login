<?php

/**
 * Plugin Name:       SWS Login Blocker
 * Plugin URI:        https://ccharacter.com/custom-plugins/sws-login-blocker/
 * Description:       Redirect users away from login page based on IP address
 * Version:           3.1
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


// Run this filter with priority 9999 (last, or close to last), after core WP filters have run
add_filter('authenticate', 'sws_reject_users', 9999, 3);

// Your custom filter function
function sws_reject_users( $user, $username, $password) {
    $src="https://docs.google.com/spreadsheets/d/e/2PACX-1vSi8u5A4bYyjXKw1GZ7N9d_kUnf5SOt0uqgS42sUa-CYjxYQBpA1b_XFczK0i-cmzr7PQ5dRmVbvGCE/pub?output=csv";
    $redirect_users = sws_login_blocker_csvToArray($src,",","N");

    // If the user is in the array of users to redirect, then send them away
    if ( in_array( $username, $redirect_users ) ) {
        header("location: /bad-user");
        die();
    }

    return $user;
}

?>