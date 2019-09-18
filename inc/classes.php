<?php


class swsLoginBlocker {

	public function sws_login_limiter() {

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


	public function init() {
		add_action( 'login_enqueue_scripts', 'sws_login_limiter');

	}
}

?>