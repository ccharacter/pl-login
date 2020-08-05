<?php


class swsLoginBlocker {

	public $sws_blocker_db = '1.0';


	public function sws_lockout_table() {	

		global $wpdb;
		global $sws_blocker_db;
		$table_name = $wpdb->prefix . 'sws_login_blocker';
		
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		  `id` int(255) NOT NULL AUTO_INCREMENT,
		  `attempt_date` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
		  `attempt_ip` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  `attempt_cat` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  PRIMARY KEY (`id`) USING BTREE
		) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option( 'sws_blocker_db', $sws_blocker_db );
		
	}

	public function sws_login_limiter() {

		// Sharon's phone for testing
		//$blockArr=array('99.203.17.238');         
		
		// can use full or partial IPs, no wildcards needed
        $src="https://docs.google.com/spreadsheets/d/e/2PACX-1vTLYBFIQpR6OC0J9ZilJ0NoRTCuSgEGrn1KA-IM3Lvf1le5ft5Ecvy_2WdkFKqp3iX1Pi7lsgG1ljuo/pub?output=csv";	
		$blockArr=sws_login_blocker_csvToArray($src,",","N");

        $one= $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR',$_SERVER)) {$two=$_SERVER['HTTP_X_FORWARDED_FOR']; } else {$two='none';}

        error_log($one."|".$two,0);

        foreach ($blockArr as $ip) {
                if ($one==$ip || $two==$ip) {
                        // redirect
                	$this->insert($one,$two); 
					header("Location: /blocked-ip");
					exit();
                }

                $pos1=strpos($one,$ip); $pos2=strpos($two,$ip);
                if ( (($pos1!==false) && ($pos1==0))  || (($pos2!==false) && ($pos2==0)) ) {
                    $this->insert($one,$two,'range');
					header("Location: /blocked-range"); exit();
                }

        }

	}


	public function insert($one,$two,$which='exact') {
		global $wpdb;
		$table=$wpdb->prefix . 'sws_login_blocker';
		
		$data=array('attempt_ip'=>$one." | ".$two, 'attempt_cat'=>$which);
		$format=array('%s','%s');
		$wpdb->insert($table,$data,$format);

	}


	public function init() {
		$this->sws_lockout_table();
		add_action( 'login_enqueue_scripts', array($this,'sws_login_limiter'));

	}
}

?>
