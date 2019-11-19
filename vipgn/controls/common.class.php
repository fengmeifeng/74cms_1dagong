<?php
	class Common extends Action {
		function init(){
		
			//添加权限只有spadmin用户才有删除权限
			// var_dump($_COOKIE);exit;
			// $name=$_COOKIE["name"];
			// $del=array('gdel','tcdel','csdel','udel','gdel','tcdel','csdel');	//操作
			// $user=array('spadmin','蔡超','ytnwj','shyinteni','冯月','胡雅琴','郑小翠','黄曼曼');						//用户
			// $user=array('郑小翠','黄曼曼','王玉','shenbo','spgongzuo');						//用户
			// echo $name.'=='.$_GET['a'];exit;
			// if(in_array($_GET["a"], $del) && !in_array($name,$user,true)){
				// $this->error("权限不足，你没有删除权限1", 3, "index");
			// }
			//不是我们的管理员提示
			/*$fuzhe=array('m_huodong');
			if($_COOKIE["name"]=="" && !in_array($_GET["m"], $fuzhe,true)){
				$this->error("未知错误,请联系管理员!", 3, "index");
			} */
		}
	}