<?php
 /*
 * 74cms WAP
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã��������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/fun_personal.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'index';
if (intval($_SESSION['uid'])=='' || $_SESSION['username']==''||intval($_SESSION['utype'])==1)
{
	header("Location: ../wap_login.php");
}
elseif ($act == 'index')
{
	$smarty->cache = false;
	$user=wap_get_user_info(intval($_SESSION['uid']));	
	$smarty->assign('user',$user);
	$resume_info=get_userprofile(intval($_SESSION['uid']));
	if(empty($resume_info))
	{
		header("Location: ?act=make_resume");
	}
	else
	{
		$resume_info['age']=date("Y")-$resume_info['birthday'];
		$smarty->assign('resume_info',$resume_info);
		$smarty->display("wap/personal/wap-user-personal-index.html");
	}
	
}
elseif ($act == 'favorites')
{
	
	$perpage = 5;
	$count  = 0;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$theurl = "wap_user.php?act=favorites";
	$start = ($page-1)*$perpage;
	$wheresql=" WHERE f.personal_uid='{$_SESSION['uid']}' ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('personal_favorites')." AS f {$wheresql} ";
	$count=$db->get_total($total_sql);
	$joinsql=" LEFT JOIN ".table('jobs')." as  j  ON f.jobs_id=j.id ";
	$smarty->assign('favorites',get_favorites($start,$perpage,$joinsql.$wheresql));
	$smarty->assign('pagehtml',wapmulti($count, $perpage, $page, $theurl));
	$smarty->display('wap/personal/wap-collect.html');
}
elseif ($act == 'add_favorites')
{
	$id=isset($_POST['id'])?intval($_POST['id']):exit("err");
	if(intval($_SESSION['utype']!=2)){
		exit("���˻�Ա���¼���ղ�ְλ");
	}
	elseif(add_favorites($id,intval($_SESSION['uid']))==0)
	{
	exit("�ղؼ����Ѿ����ڴ�ְλ");
	}
	else
	{
	exit("ok");
	}
}
// ��д����
elseif($act == "make_resume")
{
	$smarty->cache = false;
	$uid=intval($_SESSION['uid']);
	$smarty->assign('user',$user);
	$smarty->assign('userprofile',get_userprofile($_SESSION['uid']));
	$smarty->display('wap/personal/wap_make_resume.html');
}
elseif($act == "make_resume_save")
{	
	$_POST=array_map("utf8_to_gbk",$_POST);
	$setsqlarr['subsite_id']=0;
	$setsqlarr['title']=trim($_POST['title'])?trim($_POST['title']):"δ��������";
	$setsqlarr['uid']=$_SESSION['uid'];
	$setsqlarr['fullname']=trim($_POST['fullname'])?trim($_POST['fullname']):exit("����д��ʵ����");
	$setsqlarr['display_name']=1;
	$setsqlarr['sex']=trim($_POST['sex'])?trim($_POST['sex']):exit("��ѡ���Ա�");
	$setsqlarr['sex_cn']=trim($_POST['sex_cn'])?trim($_POST['sex_cn']):exit("��ѡ���Ա�");
	$setsqlarr['birthdate']=intval($_POST['birthdate'])?intval($_POST['birthdate']):exit("��ѡ��������");
	$setsqlarr['residence']=trim($_POST['residence'])?trim($_POST['residence']):exit("��ѡ���־�ס��");
	$setsqlarr['residence_cn']=trim($_POST['residence_cn'])?trim($_POST['residence_cn']):exit("��ѡ���־�ס��");
	$setsqlarr['education']=intval($_POST['education'])?intval($_POST['education']):exit("��ѡ����ѧ��");
	$setsqlarr['education_cn']=trim($_POST['education_cn'])?trim($_POST['education_cn']):exit("��ѡ����ѧ��");
	$setsqlarr['experience']=intval($_POST['experience'])?intval($_POST['experience']):exit("��ѡ��������");
	$setsqlarr['experience_cn']=trim($_POST['experience_cn'])?trim($_POST['experience_cn']):exit("��ѡ��������");
	$setsqlarr['email']=trim($_POST['email'])?trim($_POST['email']):exit("����д����");
	$setsqlarr['email_notify']=$_POST['email_notify']=="1"?1:0;
	$setsqlarr['telephone']=trim($_POST['telephone'])?trim($_POST['telephone']):exit("����д�ֻ�");
	$setsqlarr['intention_jobs']=trim($_POST['intention_jobs'])?trim($_POST['intention_jobs']):exit("��ѡ������ְλ");
	$_POST['intention_jobs_id']=trim($_POST['intention_jobs_id'])?trim($_POST['intention_jobs_id']):exit("��ѡ������ְλ");
	$setsqlarr['trade']=trim($_POST['trade'])?trim($_POST['trade']):exit("��ѡ��������ҵ");
	$setsqlarr['trade_cn']=trim($_POST['trade_cn'])?trim($_POST['trade_cn']):exit("��ѡ��������ҵ");
	$setsqlarr['district']=trim($_POST['district']);
	$setsqlarr['sdistrict']=intval($_POST['sdistrict']);
	$setsqlarr['district_cn']=trim($_POST['district_cn'])?trim($_POST['district_cn']):exit("������������");
	$setsqlarr['nature']=intval($_POST['nature'])?intval($_POST['nature']):exit("��ѡ��������");
	$setsqlarr['nature_cn']=trim($_POST['nature_cn'])?trim($_POST['nature_cn']):exit("��ѡ��������");
	$setsqlarr['wage']=intval($_POST['wage'])?intval($_POST['wage']):exit("��ѡ������н��");
	$setsqlarr['wage_cn']=trim($_POST['wage_cn'])?trim($_POST['wage_cn']):exit("��ѡ������н��");
	$setsqlarr['refreshtime']=time();
	$setsqlarr['audit']=intval($_CFG['audit_resume']);
	$total=$db->get_total("SELECT COUNT(*) AS num FROM ".table('resume')." WHERE uid='{$_SESSION['uid']}'");
	if ($total>=intval($_CFG['resume_max']))
	{
	exit("�������Դ���{$_CFG['resume_max']} �ݼ���,�Ѿ�������������ƣ�");
	}
	else
	{
	$setsqlarr['addtime']=time();
	$pid=inserttable(table('resume'),$setsqlarr,1);
	$searchtab['id'] = $pid;
	$searchtab['uid'] = intval($_SESSION['uid']);
	inserttable(table('resume_search_key'),$searchtab);
	inserttable(table('resume_search_rtime'),$searchtab);
	if (empty($pid))exit("����ʧ�ܣ�");

	if(!wap_add_resume_jobs($pid,intval($_SESSION['uid']),$_POST["intention_jobs_id"]))exit('err');
	check_resume($_SESSION['uid'],$pid);
	if(intval($_POST['entrust'])){
		set_resume_entrust($pid);
	}
	write_memberslog(intval($_SESSION['uid']),2,1101,$_SESSION['username'],"�����˼���");
	
	if(!get_userprofile(intval($_SESSION['uid']))){
		$infoarr['realname']=$setsqlarr['fullname'];
		$infoarr['sex']=$setsqlarr['sex'];
		$infoarr['sex_cn']=$setsqlarr['sex_cn'];
		$infoarr['birthday']=$setsqlarr['birthdate'];
		$infoarr['residence']=$setsqlarr['residence'];
		$infoarr['residence_cn']=$setsqlarr['residence_cn'];
		$infoarr['education']=$setsqlarr['education'];
		$infoarr['education_cn']=$setsqlarr['education_cn'];
		$infoarr['experience']=$setsqlarr['experience'];
		$infoarr['experience_cn']=$setsqlarr['experience_cn'];
		$infoarr['phone']=$setsqlarr['telephone'];
		$infoarr['email']=$setsqlarr['email'];
		$infoarr['uid']=intval($_SESSION['uid']);
		inserttable(table('members_info'),$infoarr);
	}
	echo $pid;
	// header("Location: ?act=resume_success&pid=".$pid);
	}
}
// ��д�������
elseif($act == "resume_success")
{
	$smarty->cache = false;
	$id=intval($_GET['pid']);
	$sql="select j.* from ".table("jobs")." as j left join ".table("resume_jobs")." as r on r.category=j.category where r.pid=$id limit 5";
	$resume_jobs=$db->getall($sql);
	$smarty->assign('resume_jobs',$resume_jobs);
	$smarty->display('wap/personal/wap-create-resume-success.html');
}
// �����б�
elseif($act == "resume_list")
{	
	$smarty->cache = false;
	$wheresql=" WHERE uid='".intval($_SESSION['uid'])."' ";
	$sql="SELECT * FROM ".table('resume').$wheresql;
	$resume_list=get_resume_list($sql,12,true,true,true);
	$smarty->assign('resume_list',$resume_list);
	$smarty->display('wap/personal/wap-resume-index.html');
}
// ���Ƽ���
elseif($act == "resume_one")
{
	$smarty->cache = false;
	$id=intval($_GET['pid']);
	$resume_one=resume_one($id);
	$smarty->assign('resume_one',$resume_one);
	$smarty->assign('resume_basic',get_resume_basic(intval($_SESSION['uid']),$id));
	$smarty->assign('resume_jobs',get_resume_jobs($id));
	$smarty->assign('resume_education',get_resume_education(intval($_SESSION['uid']),$id));
	$smarty->assign('resume_work',get_resume_work(intval($_SESSION['uid']),$id));
	$smarty->assign('resume_training',get_resume_training(intval($_SESSION['uid']),$id));

	$smarty->display('wap/personal/wap-comlpete-resume.html');
}
elseif($act == "resume_basic")
{
	$smarty->cache = false;
	$id=intval($_GET['pid']);
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),$id);
	// var_dump($resume_basic);
	$smarty->assign('userprofile',get_userprofile(intval($_SESSION['uid'])));
	$smarty->assign('resume_basic',$resume_basic);
	$smarty->display('wap/personal/wap-personal-info.html');
}
elseif($act == "resume_basic_save")
{
	$smarty->cache = false;
	$_POST=array_map("utf8_to_gbk",$_POST);
	$setsqlarr['subsite_id']=intval($_POST['subsite_id']);
	// $setsqlarr['title']=trim($_POST['title'])?trim($_POST['title']):"δ��������";
	$setsqlarr['uid']=intval($_SESSION['uid']);
	$setsqlarr['fullname']=trim($_POST['fullname'])?trim($_POST['fullname']):exit("����д��ʵ����");
	$setsqlarr['display_name']=intval($_POST['display_name']);
	$setsqlarr['sex']=trim($_POST['sex'])?trim($_POST['sex']):exit("��ѡ���Ա�");
	$setsqlarr['sex_cn']=trim($_POST['sex_cn'])?trim($_POST['sex_cn']):exit("��ѡ���Ա�");
	$setsqlarr['birthdate']=intval($_POST['birthdate'])?intval($_POST['birthdate']):exit("��ѡ��������");
	$setsqlarr['residence']=trim($_POST['residence'])?trim($_POST['residence']):exit("��ѡ���־�ס��");
	$setsqlarr['residence_cn']=trim($_POST['residence_cn'])?trim($_POST['residence_cn']):exit("��ѡ���־�ס��");
	$setsqlarr['education']=intval($_POST['education'])?intval($_POST['education']):exit("��ѡ����ѧ��");
	$setsqlarr['education_cn']=trim($_POST['education_cn'])?trim($_POST['education_cn']):exit("��ѡ����ѧ��");
	$setsqlarr['experience']=intval($_POST['experience'])?intval($_POST['experience']):exit("��ѡ��������");
	$setsqlarr['experience_cn']=trim($_POST['experience_cn'])?trim($_POST['experience_cn']):exit("��ѡ��������");
	$setsqlarr['email']=trim($_POST['email'])?trim($_POST['email']):exit("����д����");
	$setsqlarr['email_notify']=$_POST['email_notify']=="1"?1:0;
	$setsqlarr['telephone']=trim($_POST['telephone'])?trim($_POST['telephone']):exit("����д�ֻ�");
	// $setsqlarr['nature']=intval($_POST['nature'])?intval($_POST['nature']):exit("��ѡ��������");
	// $setsqlarr['nature_cn']=trim($_POST['nature_cn'])?trim($_POST['nature_cn']):exit("��ѡ��������");
	// $setsqlarr['wage']=intval($_POST['wage'])?intval($_POST['wage']):exit("��ѡ������н��");
	// $setsqlarr['wage_cn']=trim($_POST['wage_cn'])?trim($_POST['wage_cn']):exit("��ѡ������н��");
	updatetable(table('resume'),$setsqlarr," id='".intval($_POST['pid'])."'  AND uid='{$setsqlarr['uid']}'");
	check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
	if($_CFG['audit_edit_resume']!="-1"){
		set_resume_entrust(intval($_REQUEST['pid']));
	}
	write_memberslog($_SESSION['uid'],2,1105,$_SESSION['username'],"�޸��˼���({$_POST['title']})");

	$infoarr['realname']=$setsqlarr['fullname'];
	$infoarr['sex']=$setsqlarr['sex'];
	$infoarr['sex_cn']=$setsqlarr['sex_cn'];
	$infoarr['birthday']=$setsqlarr['birthdate'];
	$infoarr['residence']=$setsqlarr['residence'];
	$infoarr['residence_cn']=$setsqlarr['residence_cn'];
	$infoarr['education']=$setsqlarr['education'];
	$infoarr['education_cn']=$setsqlarr['education_cn'];
	$infoarr['experience']=$setsqlarr['experience'];
	$infoarr['experience_cn']=$setsqlarr['experience_cn'];
	$infoarr['phone']=$setsqlarr['telephone'];
	$infoarr['email']=$setsqlarr['email'];
	$infoarr['uid']=intval($_SESSION['uid']);
	updatetable(table('members_info'),$infoarr," uid={$infoarr['uid']} ");
	exit("ok");
}
// ��ְ���� ְλ
elseif($act == "resume_jobs")
{
	$smarty->cache = false;
	$id=$_GET['pid'];
	$resume_one=resume_one($id);
	$smarty->assign('resume_one',$resume_one);
	$resume_jobs = get_resume_jobs($id);
	$smarty->display('wap/personal/wap-want-job.html');
}
elseif($act == "resume_jobs_save")
{
	$smarty->cache = false;
	$_POST=array_map("utf8_to_gbk",$_POST);
	$setsqlarr['intention_jobs']=trim($_POST['intention_jobs'])?trim($_POST['intention_jobs']):exit("��ѡ������ְλ");
	$_POST['intention_jobs_id']=trim($_POST['intention_jobs_id'])?trim($_POST['intention_jobs_id']):exit("��ѡ������ְλ");
	$setsqlarr['wage']=trim($_POST['wage'])?trim($_POST['wage']):exit("��ѡ������н��");
	$setsqlarr['wage_cn']=trim($_POST['wage_cn'])?trim($_POST['wage_cn']):exit("��ѡ������н��");
	$setsqlarr['nature']=trim($_POST['nature'])?trim($_POST['nature']):exit("��ѡ��������������");
	$setsqlarr['nature_cn']=trim($_POST['nature_cn'])?trim($_POST['nature_cn']):exit("��ѡ��������������");
	$setsqlarr['trade']=trim($_POST['trade'])?trim($_POST['trade']):exit("��ѡ��������ҵ");
	$setsqlarr['trade_cn']=trim($_POST['trade_cn'])?trim($_POST['trade_cn']):exit("��ѡ��������ҵ");
	$setsqlarr['district_cn']=trim($_POST['district_cn'])?trim($_POST['district_cn']):exit("��ѡ��������������");
	$setsqlarr['district']=trim($_POST['district']);
	$setsqlarr['sdistrict']=trim($_POST['sdistrict']);
	if(!updatetable(table('resume'),$setsqlarr,array("id"=>intval($_POST['pid']),"uid"=>intval($_SESSION['uid']))))exit("err");
	if(!wap_add_resume_jobs(intval($_POST['pid']),intval($_SESSION['uid']),intval($_POST['intention_jobs_id'])))exit('err');
	if(!wap_add_resume_trade(intval($_POST['pid']),intval($_SESSION['uid']),intval($setsqlarr['trade'])))exit('err');
	exit("ok");
}
//  ��������
elseif($act == "resume_work_list")
{
	$smarty->cache = false;
	$id=intval($_GET['pid']);
	$resume_work_list=get_resume_work(intval($_SESSION['uid']),$id);
	$smarty->assign('resume_work',get_resume_work(intval($_SESSION['uid']),$id));
	$smarty->display('wap/personal/wap-work-experience.html');
}
// ���� �޸� ��������
elseif($act == "resume_work_add")
{	
	$smarty->cache = false;
	$id=intval($_GET['id']);
	$resume_work=get_this_work(intval($_SESSION['uid']),$id);
	if($resume_work){
		$smarty->assign('resume_work',$resume_work);
	}else{
		$smarty->assign('resume_work',false);
	}
	$smarty->display('wap/personal/wap-edit-work-experience.html');
}
elseif($act == "resume_work_save")
{
	$_POST=array_map("utf8_to_gbk",$_POST);
	// print_r($_POST);die;
	$id=intval($_POST['id']);
	$setsqlarr['uid'] = intval($_SESSION['uid']);
	$setsqlarr['pid'] = intval($_POST['pid']);

	if ($setsqlarr['uid']==0 || $setsqlarr['pid']==0 )exit('����������');

	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_POST['pid']));
	if (empty($resume_basic)) exit('������д����������Ϣ');
	$resume_work=get_resume_work($_SESSION['uid'],intval($_POST['pid']));
	if (count($resume_work)>=6)  exit('�����������ܳ���6��');
	$setsqlarr['companyname'] = trim($_POST['companyname'])?trim($_POST['companyname']):exit('����д��˾���ƣ�');
	$setsqlarr['jobs'] = trim($_POST['jobs'])?trim($_POST['jobs']):exit("����дְλ���ƣ�");
	if(trim($_POST['startyear'])==""||trim($_POST['startmonth'])==""||trim($_POST['endyear'])==""||trim($_POST['endmonth'])==""){
		exit("��ѡ����ְʱ��!");
	}
	$setsqlarr['startyear'] = intval($_POST['startyear']);
	$setsqlarr['startmonth'] = intval($_POST['startmonth']);
	$setsqlarr['endyear'] = intval($_POST['endyear']);
	$setsqlarr['endmonth'] = intval($_POST['endmonth']);
	$setsqlarr['achievements'] = trim($_POST['achievements'])?trim($_POST['achievements']):exit("����д����ְ��");
	
	if($id){
		updatetable(table("resume_work"),$setsqlarr,array("id"=>$id,"uid"=>intval($_SESSION['uid'])));
		exit("ok");
	}else{
		$insert_id = inserttable(table("resume_work"),$setsqlarr,1);
		if($insert_id){
			check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
			exit("ok");
		}else{
			exit("err");
		}
	}
}
elseif($act == "resume_work_del")
{
	$smarty->cache = false;
	$id=intval($_GET['work_id']);
	$uid=intval($_SESSION["uid"]);
	$sql="delete from ".table("resume_work")." where id=$id and uid=$uid ";
	if($db->query($sql)){
		exit("ok");
	}else{
		exit("err");
	}
}
// ��������
elseif($act == "resume_education")
{	
	$smarty->cache = false;
	$id=intval($_GET['pid']);
	$resume_education_list=get_resume_education(intval($_SESSION['uid']),$id);
	// var_dump($resume_education_list);
	$smarty->assign("resume_education_list",$resume_education_list);
	$smarty->display('wap/personal/wap-edu-experience.html');
}
// ���� �޸� ��������
elseif($act == "resume_education_add")
{	
	$smarty->cache = false;
	$id=intval($_GET["id"]);
	$resume_edu=get_this_education(intval($_SESSION['uid']),$id);
	if($resume_edu){
		$smarty->assign('resume_edu',$resume_edu);
	}else{
		$smarty->assign('resume_edu',false);
	}
	$smarty->display('wap/personal/wap-edit-edu-experience.html');
}
elseif($act == "resume_education_save")
{
	// print_r($_POST);die;
	$_POST=array_map("utf8_to_gbk",$_POST);
	$id=intval($_POST['id']);
	$setsqlarr['uid'] = intval($_SESSION['uid']);
	$setsqlarr['pid'] = intval($_POST['pid']);
	if ($setsqlarr['uid']==0 || $setsqlarr['pid']==0 )exit('����������');
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_POST['pid']));
	if (empty($resume_basic)) exit('������д����������Ϣ');
	$resume_education=get_resume_education($_SESSION['uid'],intval($_POST['pid']));
	if (count($resume_education)>=6)  exit('�����������ܳ���6��');
	$setsqlarr['school'] = trim($_POST['school'])?trim($_POST['school']):exit('����дѧУ���ƣ�');
	$setsqlarr['speciality'] = trim($_POST['speciality'])?trim($_POST['speciality']):WapShowMsg("����дרҵ���ƣ�");
	if(trim($_POST['startyear'])==""||trim($_POST['startmonth'])==""||trim($_POST['endyear'])==""||trim($_POST['endmonth'])==""){
		exit("��ѡ��Ͷ�ʱ�䣡");
	}
	$setsqlarr['startyear'] = intval($_POST['startyear']);
	$setsqlarr['startmonth'] = intval($_POST['startmonth']);
	$setsqlarr['endyear'] = intval($_POST['endyear']);
	$setsqlarr['endmonth'] = intval($_POST['endmonth']);
	// $setsqlarr['education'] = trim($_POST['education'])?trim($_POST['education']):WapShowMsg("��ѡ����ѧ��",0);
	// $setsqlarr['education_cn'] = trim($_POST['education_cn'])?trim($_POST['education_cn']):WapShowMsg("��ѡ����ѧ��",0);
	if($id){
		updatetable(table("resume_education"),$setsqlarr,array("id"=>$id,"uid"=>intval($_SESSION['uid'])));
		exit("ok");
	}else{
		$insert_id = inserttable(table("resume_education"),$setsqlarr,1);
		if($insert_id){
			check_resume(intval($_SESSION['uid']),intval($_REQUEST['pid']));
			exit("ok");
		}else{
			exit("err");
		}
	}
}
// ɾ����������
elseif($act == "resume_education_del")
{
	$smarty->cache = false;
	$id=intval($_GET['education_id']);
	$uid=intval($_SESSION["uid"]);
	$sql="delete from ".table("resume_education")." where id=$id and uid=$uid ";
	if($db->query($sql)){
		exit("ok");
	}else{
		exit("err");
	}
}
// ��ѵ���� 
elseif($act == "resume_train")
{
	$smarty->cache = false;
	$id=intval($_GET['pid']);
	$resume_train_list=get_resume_training(intval($_SESSION['uid']),$id);
	$smarty->assign("resume_train_list",$resume_train_list);
	$smarty->display('wap/personal/wap-train-experience.html');
}
elseif($act == "resume_train_add")
{
	$smarty->cache = false;
	$id=intval($_GET["id"]);
	$resume_train=get_this_training(intval($_SESSION['uid']),$id);
	if($resume_train){
		$smarty->assign('resume_train',$resume_train);
	}else{
		$smarty->assign('resume_train',false);
	}
	$smarty->display('wap/personal/wap-edit-train-experience.html');
}
elseif($act == "resume_train_save")
{
	// print_r($_POST);die;
	$_POST=array_map("utf8_to_gbk",$_POST);
	$id=intval($_POST['id']);
	$setsqlarr['uid'] = intval($_SESSION['uid']);
	$setsqlarr['pid'] = intval($_POST['pid']);
	if ($setsqlarr['uid']==0 || $setsqlarr['pid']==0 )exit('����������');
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_POST['pid']));
	if (empty($resume_basic)) exit('������д����������Ϣ');
	$resume_training=get_resume_training($_SESSION['uid'],intval($_POST['pid']));
	if (count($resume_training)>=6)  exit('��ѵ�������ܳ���6��');
	$setsqlarr['agency'] = trim($_POST['agency'])?trim($_POST['agency']):exit('����д��ѵ�������ƣ�');
	$setsqlarr['course'] = trim($_POST['course'])?trim($_POST['course']):exit("����д��ѵרҵ���ƣ�");
	if(trim($_POST['startyear'])==""||trim($_POST['startmonth'])==""||trim($_POST['endyear'])==""||trim($_POST['endmonth'])==""){
		exit("��ѡ����ѵʱ�䣡");
	}
	$setsqlarr['startyear'] = intval($_POST['startyear']);
	$setsqlarr['startmonth'] = intval($_POST['startmonth']);
	$setsqlarr['endyear'] = intval($_POST['endyear']);
	$setsqlarr['endmonth'] = intval($_POST['endmonth']);
	if($id){
		updatetable(table("resume_training"),$setsqlarr,array("id"=>$id,"uid"=>intval($_SESSION['uid'])));
		exit("ok");
	}else{
		$insert_id = inserttable(table("resume_training"),$setsqlarr,1);
		if($insert_id){
			check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
			exit("ok");
		}else{
			exit("err");
		}
	}	
}
elseif($act == "resume_train_del")
{
	$smarty->cache = false;
	$id=intval($_GET['train_id']);
	$uid=intval($_SESSION["uid"]);
	$sql="delete from ".table("resume_training")." where id=$id and uid=$uid ";
	if($db->query($sql)){
		exit("ok");
	}else{
		exit("err");
	}
}
// ��������
elseif($act == "resume_specialty")
{
	$smarty->cache = false;
	$id=intval($_GET['pid']);
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),$id);
	$smarty->assign('resume_basic',$resume_basic);
	$smarty->display('wap/personal/wap-evaluation.html');
}
elseif($act == "resume_specialty_save")
{
	$_POST=array_map("utf8_to_gbk",$_POST);
	$smarty->cache = false;
	$id=intval($_POST['pid']);
	$uid=intval($_SESSION["uid"]);
	$specialty=$_POST['specialty']?$_POST['specialty']:exit("����д��������");
	$sql="update ".table("resume")." set specialty='$specialty' where id=$id and uid=$uid ";
	if($db->query($sql)){
		exit("ok");
	}else{
		exit("err");
	}

}
// ����ˢ��
elseif($act == "resume_refresh")
{
	$smarty->cache = false;

	$resumeid = intval($_GET['pid']);
	$refrestime=get_last_refresh_date(intval($_SESSION['uid']),"2001");
	$duringtime=time()-$refrestime['max(addtime)'];
	$space = $_CFG['per_refresh_resume_space']*60;
	$refresh_time = get_today_refresh_times($_SESSION['uid'],"2001");
	if($_CFG['per_refresh_resume_time']!=0&&($refresh_time['count(*)']>=$_CFG['per_refresh_resume_time']))
	{
	exit("ÿ�����ֻ��ˢ��".$_CFG['per_refresh_resume_time']."��,�������ѳ������ˢ�´������ƣ�");	
	}
	elseif($duringtime<=$space)
	{
	exit($_CFG['per_refresh_resume_space']."�����ڲ����ظ�ˢ�¼�����");
	}
	else 
	{
	refresh_resume($resumeid,intval($_SESSION['uid']))?exit('ok'):exit("err");
	}
}
// ������˽����
elseif($act == "resume_privacy")
{
	$smarty->cache = false;
	$pid=intval($_GET['pid']);
	//���ε���ҵ
	$uid=intval($_SESSION["uid"]);
	$shield_company=$db->getall("select * from ".table("personal_shield_company")." where uid=$uid and pid=$pid");
	$smarty->assign('shield_company',$shield_company);
	$smarty->assign('resume_one',resume_one($pid));
	$smarty->display('wap/personal/wap-privacy-settings.html');
}
elseif($act == "resume_privacy_save")
{
	$smarty->cache = false;
	$uid=intval($_SESSION['uid']);
	$pid=intval($_POST['pid']);
	$setsqlarr['display']=intval($_POST['display']);
	$setsqlarr['display_name']=intval($_POST['display_name']);
	// $setsqlarr['photo_display']=intval($_POST['photo_display']);
	!updatetable(table('resume'),$setsqlarr," uid='{$uid}' AND  id='{$pid}'");
	$setsqlarrdisplay['display']=intval($_POST['display']);
	!updatetable(table('resume_search_key'),$setsqlarrdisplay," uid='{$uid}' AND  id='{$pid}'");
	!updatetable(table('resume_search_rtime'),$setsqlarrdisplay," uid='{$uid}' AND  id='{$pid}'");
	!updatetable(table('resume_search_tag'),$setsqlarrdisplay," uid='{$uid}' AND  id='{$pid}'");
	$rst=write_memberslog($uid,2,1104,$_SESSION['username'],"���ü�����˽({$pid})");
	if($rst){
		exit("ok");
	}else{
		exit("err");
	}
}
// ������ҵ
elseif($act == "shield_company_save")
{
	$smarty->cache = false;
	if($_GET['comkeyword']==""){
		exit("err");
	}
	$setsqlarr['uid']=intval($_SESSION['uid']);
	$setsqlarr['pid']=intval($_GET['pid']);
	$setsqlarr['comkeyword']=$_GET['comkeyword'];
	inserttable(table('personal_shield_company'),$setsqlarr,1)?exit("ok"):exit("err");
}
// ɾ��������ҵ
elseif($act == "shield_company_del")
{
	$smarty->cache = false;
	$id=intval($_GET["id"]);
	$uid=intval($_SESSION["uid"]);
	$sql="delete from ".table("personal_shield_company")." where id=$id and uid=$uid ";
	$db->query($sql)?exit("ok"):exit("err");
}
elseif($act == "resume_del")
{
	$smarty->cache = false;
	$id=intval($_GET["pid"]);
	$uid=intval($_SESSION['uid']);
	del_resume($uid,$id)?exit('ok'):exit('err');
}
// �����߼�����
elseif($act == "resume_talent")
{
	$smarty->cache = false;
	$id=intval($_GET["pid"]);
	$setsqlarr["talent"]=3;
	updatetable(table("resume"),$setsqlarr,array("id"=>$id,"uid"=>intval($_SESSION['uid'])))?exit("ok"):exit("err");
}
// �޸ļ�����
elseif($act == 'resume_name_save')
{
	$smarty->cache = false;
	$_POST=array_map("utf8_to_gbk", $_POST);
	$resume_id=intval($_POST["resume_id"]);
	$uid=intval($_SESSION["uid"]);
	$title=trim($_POST['title'])?trim($_POST['title']):exit("�������������");
	$sql="update ".table("resume")." set title='$title' where id=$resume_id and uid=$uid ";
	if($db->query($sql)){
		exit("ok");
	}else{
		exit("err");
	}
	
}
?>