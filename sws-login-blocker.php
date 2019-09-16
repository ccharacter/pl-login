<?php

/**
 * Plugin Name:       SWS Login Blocker
 * Plugin URI:        https://github.com/ccharacter/pl-login
 * Description:       Redirect users away from login page based on IP address
 * Version:           1.62
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sharon Stromberg
 * Author URI:        https://www.ccharacter.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sws-login-blocker
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


// Include our updater file
/*if( ! class_exists( 'Smashing_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'myUpdater.php' );
}

$updater = new Smashing_Updater( __FILE__ ); // instantiate our class
$updater->set_username( 'ccharacter' ); // set username
$updater->set_repository( 'pl-login' ); // set repo
$updater->authorize( 'e10a72212dd70107e64d945d613bd1bc0cdbc96a' ); // set access token
$updater->initialize(); // initialize the updater*/


include_once( plugin_dir_path( __FILE__ ) .'lib/plugin-update-checker.php');
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/ccharacter/pl-login/latest/',
	__FILE__,
	'sws-login-blocker'
);
$myUpdateChecker->setAuthentication('e10a72212dd70107e64d945d613bd1bc0cdbc96a');

function sws_login_limiter() {

        // can use full or partial IPs, no wildcards needed
        $blockArr=array('103.','112.','114.','115.','116.','118.','119.','121.','122.','123.','125.','128.',
                '134.','138.','139.','14.','144.','145.','149.','150.','153.',
                '154.','157.','159.','163.','164.','165.','167.','176.','178.','180.','182.','186.','186.','187.','188.','190.',
                '195.','197.','2.','200.','202.','203.','210.','211.','212.','213.','217.','221.','27.','31.','36.','37.','41.','42.','43.','45.252.',
                '46.','5.','51.','52.27.','54.251.','54.37.','58.','59.','61.','62.','77.','78.','80.','83.','85.','86.','87.','88.','89.','91.',
                '92.','93.','94.','95.','96.'
        );

        $one= $_SERVER['REMOTE_ADDR'];
        $two=$_SERVER['HTTP_X_FORWARDED_FOR'];

        //echo $one."<br />".$two;

        foreach ($blockArr as $ip) {
                if ($one==$ip || $two==$ip) {
                        // redirect
                        header("Location: /about");
                }

                $pos1=strpos($one,$ip); $pos2=strpos($two,$ip);
                if ( (($pos1!==false) && ($pos1==0))  || (($pos2!==false) && ($pos2==0)) ) {
                        header("Location: /certification");
                }

        }

}
add_action( 'login_enqueue_scripts', 'sws_login_limiter');



?>