<?php
 /*
 * 74cms 会员注册
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
$alias="QS_login";
require_once(dirname(__FILE__).'/../../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/fun_user.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$smarty->cache = false;
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'qixi';
if ($act=='qixi')
{
	//echo "1212";exit;
	if(empty($_GET['id']))
	{
		$arr[0]='早上起床第一个想见的是你，晚上睡前最后想见的也是你，希望只要我眼睛看到的地方都有你。';
		$arr[1]='对未来不再害怕，因为你就是我的方向；对困难不再恐惧，因为你能成为我的力量。';
		$arr[2]='和你在一起，再琐碎的事情都变成了美好的回忆，想和你过完这一生，甚至这一生对我来说也不够长久。';
		$arr[3]='要是我有一条小尾巴，看到你的时候，一定会忍不住摇摆，那是我看到心仪人的模样。';
		$arr[4]='白天见到的是你，晚上梦到的是你，这就是我想要的幸福。';
		$arr[5]='从现在牵手，到将来白头，一生太短，不够我好好拥抱你。愿意做你的英雄，呵护你，用尽我一辈子的温柔。';
		$arr[6]='感谢我能遇见你，万水千山，希望我们能够一起走过。';
		$arr[7]='有你在的地方，就会有我的眼神，守望你是我今生最大的幸福。';
		$arr[8]='与君初相识，犹如故人归。思君如流水，何有穷已时。';
		$arr[9]='早就在脑海里和你轰轰烈烈过完了一生，就差一句勇敢的告白。';
		$randid=array_rand($arr);
		$smarty->assign('contents',$arr[$randid]);
		
		$bgid=rand(1,9);
		$bg='/files/qixi/images/'.$bgid.'.jpg';
		$smarty->assign('bg',$bg);
		
		///------
		$time=date('Y-m-d',time());
		$smarty->assign('time',$time);
	}
	else
	{
		$id=intval($_GET['id']);
		$sql = "select * from zt_qx where id = ".$id." LIMIT 1";
		$val=$db->getone($sql);
		$smarty->assign('time',date('Y-m-d',$val['addtime']));
		$smarty->assign('to',$val['to']);
		$smarty->assign('from',$val['from']);
		$smarty->assign('bg',$val['bg']);
		$smarty->assign('contents',$val['contents']);
	}
	$smarty->display('zt/qixi.htm');
}
elseif($act == 'chakan')
{
	$id=intval($_GET['id']);
	$sql = "select * from zt_qx where id = ".$id." LIMIT 1";
	$val=$db->getone($sql);
	$smarty->assign('time',date('Y-m-d',$val['addtime']));
	$smarty->assign('to',$val['to']);
	$smarty->assign('from',$val['from']);
	$smarty->assign('bg',$val['bg']);
	$smarty->assign('contents',$val['contents']);
	$smarty->display('zt/qixi.htm');
}
unset($smarty);
?>