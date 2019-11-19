<?php
	define("DEBUG", 0);				      //开启调试模式 1 开启 0 关闭
	define("DRIVER","pdo");				      //数据库的驱动，本系统支持pdo(默认)和mysqli两种
	//define("DSN", "mysql:host=localhost;dbname=brophp"); //如果使用PDO可以使用，不使用则默认连接MySQL
	define("HOST", "127.0.0.1");			      //数据库主机
	define("USER", "root");                      //数据库用户名
	define("PASS", "");                                   //数据库密码
	define("DBNAME","12");			      //数据库名
	define("TABPREFIX", "");                           //数据表前缀
	define("CSTART", 0);                                  //缓存开关 1开启，0为关闭
	define("CTIME", 60*60*24*7);                          //缓存时间
	define("TPLPREFIX", "tpl");                           //模板文件的后缀名
	define("TPLSTYLE", "default");                        //默认模板存放的目录
	
	
	//自定义常量-------------and-----------------------------------------------------
	define("DUANXIN", 0);                          //是否开启短信通知 1 开启 0 关闭
	define("USERPASS", "1+2huidong");			   //密码
	define("JIHUODAYS", 30);                        //入职未满多少天   可以激活！
	
	
	//define("TIANDAYS", 35);                        //入职未满多少天   离职扣钱，否则不扣钱。
	//自定义常量-------------end-----------------------------------------------------
	