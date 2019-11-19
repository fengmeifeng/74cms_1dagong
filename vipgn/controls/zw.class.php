<?php
	class Zw {
		//查看展位信息。。。.
		function index(){
			$zw=D("vip_zw");
			for( $i=10; $i<61; $i++){
				$_POST['subsite_id']=1;
				$_POST['number']="0".$i;
				echo "<br />".$id=$zw->insert();
			}
		}

}
	