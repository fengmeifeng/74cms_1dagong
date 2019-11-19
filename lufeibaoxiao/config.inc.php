<?php
	define("DEBUG", 0);							//开启调试模式 1 开启 0 关闭
	define("DRIVER","pdo");						//数据库的驱动，本系统支持pdo(默认)和mysqli两种
	//define("DSN", "mysql:host=localhost;dbname=brophp"); //如果使用PDO可以使用，不使用则默认连接MySQL
	define("HOST", "192.168.3.246");				//数据库主机
	define("USER", "zjobsshujuku121");                     //数据库用户名
	define("PASS", "yaogongzuo123*()");                          //数据库密码
	define("DBNAME","yaogongzuo");			 				//数据库名
	define("TABPREFIX", "bb_");								//数据表前缀
	define("CSTART", 0);                                  //缓存开关 1开启，0为关闭
	define("CTIME", 60*60*24*7);                          //缓存时间
	define("TPLPREFIX", "tpl");                           //模板文件的后缀名
	define("TPLSTYLE", "default");                        //默认模板存放的目录

	//$memServers = array("localhost", 11211);	     //使用memcache服务器
	/*
	如果有多台memcache服务器可以使用二维数组
	$memServers = array(
			array("www.lampbrother.net", '11211'),
			array("www.brophp.com", '11211'),
			...
		);
	*/