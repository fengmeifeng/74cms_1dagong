<?php
 /*
 * 74cms ��ͷ�û����
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã��������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../data/config.php');
require_once(dirname(__FILE__).'/include/admin_common.inc.php');
require_once(ADMIN_ROOT_PATH.'include/admin_banben_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'jobs';
if($act == 'jobs')
{
	//check_permissions($_SESSION['admin_purview'],"hun_jobs_show");
	$audit=intval($_GET['audit']);
	$utype=intval($_GET['utype']);
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
 	$wheresqlarr=array();
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	$oederbysql=' order BY addtime DESC ';
	if (!empty($key) && $key_type>0)
	{
		if     ($key_type===1)$wheresql=" WHERE jobs_name like '%{$key}%'";
		elseif ($key_type===2 && intval($key)>0)$wheresql=" WHERE v_id =".intval($key);
		elseif ($key_type===3 )$wheresql=" WHERE companyname like '%{$key}%'";
		elseif ($key_type===4 )$wheresql=" WHERE companyname_note like '%{$key}%'";
		elseif ($key_type===5 && intval($key)>0)$wheresql=" WHERE uid =".intval($key);
		$oederbysql="";
	}
	else
	{
			if ($audit>0)
			{
			$wheresqlarr['audit']=$audit;
			}
			if ($utype>0)
			{
			$wheresqlarr['utype']=$utype;
			}
			if (!empty($wheresqlarr)) $wheresql=wheresql($wheresqlarr);
			if (!empty($_GET['deadline']))
			{
				$settr=strtotime("+".intval($_GET['deadline'])." day");
				//$wheresql=empty($wheresql)?" WHERE deadline< ".$settr:$wheresql." AND deadline< ".$settr;
				$oederbysql=" order BY addtime DESC ";
			}
			if (!empty($_GET['refre']))
			{
				$settr=strtotime("-".intval($_GET['refre'])." day");
				$wheresql=empty($wheresql)?" WHERE addtime> ".$settr:$wheresql." AND addtime> ".$settr;
				$oederbysql=" order BY addtime DESC ";
			}
	}
	$total_sql="SELECT COUNT(*) AS num FROM ".table('banben').$wheresql;
 	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$getsql="SELECT * FROM ".table('banben').$wheresql.$oederbysql;
	$hunterjobs = get_banben($offset,$perpage,$getsql);
	$smarty->assign('pageheader',"ְλ����");
	$smarty->assign('hunterjobs',$hunterjobs);
	$smarty->assign('now',time());
	$smarty->assign('total',$total);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('total_val',$total_val);
	get_token();
	$smarty->display('banb/admin_hunter_jobs.htm');
}
elseif($act == 'jobs_perform')
{
		check_token();
		$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:adminmsg("��û��ѡ��ְλ��",1);
		if (!empty($_REQUEST['delete']))
		{
			//check_permissions($_SESSION['admin_purview'],"hun_jobs_del");
			$num=del_hunterjobs($yid);
			if ($num>0)
			{
			adminmsg("ɾ���ɹ�����ɾ��".$num."��",2);
			}
			else
			{
			adminmsg("ɾ��ʧ�ܣ�",0);
			}
		}
		elseif (!empty($_POST['set_audit']))
		{
			//check_permissions($_SESSION['admin_purview'],"hun_jobs_audit");
			$audit=intval($_POST['audit']);
			$pms_notice=intval($_POST['pms_notice']);
			$reason=trim($_POST['reason']);
			if ($n=edit_jobs_audit($yid,$audit,$reason,$pms_notice))
			{
			adminmsg("��˳ɹ�����Ӧ���� {$n}",2);			
			}
			else
			{
			adminmsg("��˳ɹ�����Ӧ���� 0",1);
			}
		}
		elseif (!empty($_GET['refresh']))
		{
			if($n=refresh_jobs($yid))
			{
			adminmsg("ˢ�³ɹ�����Ӧ���� {$n}",2);
			}
			else
			{
			adminmsg("ˢ��ʧ�ܣ�",0);
			}
		}
		elseif (!empty($_POST['set_delay']))
		{
			$days=intval($_POST['days']);
			if (empty($days))
			{
			adminmsg("����дҪ�ӳ���������",0);
			}
			if($n=delay_jobs($yid,$days))
			{
			adminmsg("�ӳ���Ч�ڳɹ�����Ӧ���� {$n}",2);
			}
			else
			{
			adminmsg("����ʧ�ܣ�",0);
			}
		}
		elseif (!empty($_POST['set_recom']))
		{
		//check_permissions($_SESSION['admin_purview'],"hun_jobs_rec");		
		$rec_notice=intval($_POST['rec_notice']);
			$recommend=intval($_POST['recommend']);
			$notice=trim($_POST['notice']);
			if($n=recom_hunter_jobs($yid,$recommend,$rec_notice,$notice))
			{
				adminmsg("ְλ���óɹ�����Ӧ���� {$n}",2);
			}
			else
			{
				adminmsg("ְλ����ʧ�ܣ�",0);
			}
		}

}
//---ff
elseif($act == 'bm_hymq')
{
	//echo "1212";exit;
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
 	$wheresqlarr=array();
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	$oederbysql=' order BY b.addtime DESC ';
	if (!empty($key) && $key_type>0)
	{
		if     ($key_type===1)$wheresql=" WHERE jobs_name like '%{$key}%'";
		elseif ($key_type===2 && intval($key)>0)$wheresql=" WHERE id =".intval($key);
		elseif ($key_type===3 )$wheresql=" WHERE b.companyname like '%{$key}%'";
		elseif ($key_type===4 )$wheresql=" WHERE companyname_note like '%{$key}%'";
		elseif ($key_type===5 && intval($key)>0)$wheresql=" WHERE uid =".intval($key);
		$oederbysql="";
	}
	
	$total_sql="SELECT COUNT(*) AS num FROM ".table('bm_hymq')." as b left join qs_resume as r on b.resume_id=r.id ".$wheresql;
 	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$getsql="SELECT b.*,r.fullname,r.telephone,r.district_cn,r.sex_cn FROM ".table('bm_hymq')." as b left join qs_resume as r on b.resume_id=r.id ".$wheresql.$oederbysql;
	$hunterjobs = get_hunterjobs($offset,$perpage,$getsql);
	$smarty->assign('pageheader',"������ҵ�������");
	$smarty->assign('hunterjobs',$hunterjobs);
	$smarty->assign('now',time());
	$smarty->assign('total',$total);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('total_val',$total_val);
	get_token();
	//echo "<pre>";print_r($hunterjobs);exit;
	$smarty->display('banb/bm_hymq.htm');
}
elseif($act == 'del_bm_hymq')
{	
	check_token();
	//check_permissions($_SESSION['admin_purview'],"hun_user_del");
	$tuid =!empty($_REQUEST['id'])?$_REQUEST['id']:adminmsg("��û��ѡ���¼��",1);

	!delete_bm_hymq($tuid)?adminmsg("ɾ��ʧ�ܣ�",0):adminmsg("ɾ���ɹ���",2);;
		
	
}
elseif($act == 'add_jobs')
{
	get_token();
	$smarty->assign('url',$_SERVER["HTTP_REFERER"]);
	$smarty->assign('jobs',$jobs);
	//--ff
	$smarty->assign('user',$user);
		
			$_SESSION['addrand']=rand(1000,5000);
			$smarty->assign('addrand',$_SESSION['addrand']);
			$smarty->assign('title','���°汾 - �������� - '.$_CFG['site_name']);
			$smarty->assign('shenhe_profile',$shenhe_profile);
			if ($_CFG['operation_shenhe_mode']=="2")
			{
				$setmeal=get_user_setmeal($_SESSION['uid']);
				$smarty->assign('setmeal',$setmeal);
				$smarty->assign('add_mode',2);
			}
			elseif ($_CFG['operation_shenhe_mode']=="1")
			{
				$smarty->assign('points_total',get_user_points($_SESSION['uid']));
				$smarty->assign('points',get_cache('points_rule'));
				$smarty->assign('add_mode',1);
			}
			$smarty->assign('verify_addjob',$captcha['verify_addjob']);
	//--ff

	$smarty->display('banb/admin_hunter_jobs_add.htm');
}
elseif ($act=='addjobs_save')
{
	//echo "121";echo $_POST['v_id'];exit;
	//$setsqlarr['v_id']=!empty($_POST['v_id'])?intval($_POST['v_id']):adminmsg('��û����д�汾�ţ�',1);
	//$setsqlarr['msg']=!empty($_POST['msg'])?trim($_POST['msg']):adminmsg('��û����д�汾˵��',1);
	$setsqlarr['v_id']=intval($_POST['v_id']);
	$setsqlarr['msg']=trim($_POST['msg']);
	$setsqlarr['addtime']=time();
	
	//---�ϴ�ͼƬ
	require_once(dirname(__FILE__).'/include/upload-apk.php');
	
	$_FILES['apk_url']['name']?adminmsg('���ϴ��ļ���',1):"";
	$uplogo_dir="../interface/apk/".date("Y/m/d/");
	make_dir($uplogo_dir);
	$setsqlarr['apk_url']=_asUpFiles($uplogo_dir, "apk_url",4288,'apk/jpg/bmp/png',true);//$_SESSION['uid']
	echo "<pre>";print_r($setsqlarr);exit;
	if (!$setsqlarr['apk_url'])
	{
		adminmsg('�ϴ�ʧ�ܣ�',1);
	}
	$setsqlarr['apk_url']=date("Y/m/d/").$setsqlarr['apk_url'];
	
	$logo_src="../data/logo/".$setsqlarr['apk_url'];
	$thumb_dir=$uplogo_dir;
	makethumb($logo_src,$thumb_dir,300,110);//��������ͼ
	$wheresql="";
	echo "<pre>";print_r($setsqlarr);exit;
	//---ffff
	//����ְλ��Ϣ
	$pid=inserttable(table('banben'),$setsqlarr,$wheresql);
	empty($pid)?showmsg("����ʧ�ܣ�",0):'';
	//������ϵ��ʽ
	if ($_CFG['operation_shenhe_mode']=='1')
	{
		if ($points_rule['shenhe_shenhejobs_add']['value']>0)
		{
		report_deal($_SESSION['uid'],$points_rule['shenhe_shenhejobs_add']['type'],$points_rule['shenhe_shenhejobs_add']['value']);
		$user_points=get_user_points($_SESSION['uid']);
		$operator=$points_rule['shenhe_shenhejobs_add']['type']=="1"?"+":"-";
		write_memberslog($_SESSION['uid'],3,9201,$_SESSION['username'],"������ְλ��<strong>{$setsqlarr['jobs_name']}</strong>��({$operator}{$points_rule['shenhe_shenhejobs_add']['value']})��(ʣ��:{$user_points})");
		}
		if (intval($_POST['days'])>0 && $points_rule['shenhe_shenhejobs_daily']['value']>0)
		{
		$points_day=intval($_POST['days'])*$points_rule['shenhe_shenhejobs_daily']['value'];
		report_deal($_SESSION['uid'],$points_rule['shenhe_shenhejobs_daily']['type'],$points_day);
		$user_points=get_user_points($_SESSION['uid']);
		$operator=$points_rule['shenhe_shenhejobs_daily']['type']=="1"?"+":"-";
		write_memberslog($_SESSION['uid'],3,9201,$_SESSION['username'],"������ְͨλ:<strong>{$_POST['jobs_name']}</strong>����Ч��Ϊ{$_POST['days']}�죬({$operator}{$points_day})��(ʣ��:{$user_points})");
		}
	}
	elseif ($_CFG['operation_shenhe_mode']=='2')
	{
		action_user_setmeal($_SESSION['uid'],"jobs_add");
		$setmeal=get_user_setmeal($_SESSION['uid']);
		write_memberslog($_SESSION['uid'],3,9202,$_SESSION['username'],"����ְλ:<strong>{$_POST['jobs_name']}</strong>�������Է���ְλ:<strong>{$setmeal['jobs_add']}</strong>��");
	}
	write_memberslog($_SESSION['uid'],3,8502,$_SESSION['username'],"������ְλ��{$setsqlarr['jobs_name']}");
	header("location:?act=addjobs_save_succeed");
}
elseif($act=='addjobs_save_succeed'){
	$uid = intval($_SESSION['uid']);
	$smarty->assign('concern_id',get_concern_id($uid));
	$smarty->assign('title','����ְλ - ��ҵ��Ա���� - '.$_CFG['site_name']);
	$smarty->display('banb/hymq_addjobs_succeed.htm');
}
//---ff
elseif($act == 'edit_jobs')
{
	get_token();
	//check_permissions($_SESSION['admin_purview'],"hun_jobs_edit");
	$id =!empty($_REQUEST['id'])?intval($_REQUEST['id']):adminmsg("��û��ѡ��ְλ��",1);
	$smarty->assign('pageheader',"ְλ����");
	$jobs=get_jobs_one($id);
	$smarty->assign('url',$_SERVER["HTTP_REFERER"]);
	$smarty->assign('jobs',$jobs);
	$smarty->assign('subsite',get_subsite_list());
	$smarty->display('banb/admin_hunter_jobs_edit.htm');
}
elseif ($act=='editjobs_save')
{
	check_token();
	//check_permissions($_SESSION['admin_purview'],"hun_jobs_edit");
	$id=intval($_POST['id']);
	$utype=intval($_POST['utype']);
	$days=intval($_POST['days']);
	$companyname1=intval($_POST['companyname1']);
	if($utype=='5'){
		$setsqlarr['companyname']=!empty($_POST['companyname'])?trim($_POST['companyname']):adminmsg('��û����д��Ƹ����˾����ʾ���ƣ�',1);
		//$setsqlarr['companyname_note']=!empty($_POST['companyname_note'])?trim($_POST['companyname_note']):adminmsg('��û����д��Ƹ����˾��ע���ƣ�',1);
		$setsqlarr['nature']=!empty($_POST['nature'])?intval($_POST['nature']):adminmsg('��ѡ����Ƹ����˾���ʣ�',1);
		$setsqlarr['nature_cn']=trim($_POST['nature_cn']);
		$setsqlarr['scale']=!empty($_POST['scale'])?intval($_POST['scale']):adminmsg('��ѡ����Ƹ����˾��ģ��',1);
		$setsqlarr['scale_cn']=trim($_POST['scale_cn']);
		$setsqlarr['trade']=!empty($_POST['trade'])?intval($_POST['trade']):adminmsg('��ѡ����Ƹ����˾��ҵ��',1);
		$setsqlarr['trade_cn']=trim($_POST['trade_cn']);
		$setsqlarr['company_desc']=!empty($_POST['company_desc'])?trim($_POST['company_desc']):adminmsg('��û����д��Ƹ����˾�ļ�飡',1);
	}
	
	//$setsqlarr['jobs_name']=!empty($_POST['jobs_name'])?trim($_POST['jobs_name']):adminmsg('��û����дְλ���ƣ�',1);
	$setsqlarr['category']=!empty($_POST['category'])?intval($_POST['category']):adminmsg('��ѡ��ְλ���',1);
	$setsqlarr['subclass']=intval($_POST['subclass']);
	$setsqlarr['category_cn']=trim($_POST['category_cn']);
	
	//$setsqlarr['department']=!empty($_POST['department'])?trim($_POST['department']):adminmsg('��û����д�������ţ�',1);
	//$setsqlarr['reporter']=!empty($_POST['reporter'])?trim($_POST['reporter']):adminmsg('��û����д�㱨����',1);
	
	$setsqlarr['district']=!empty($_POST['district'])?intval($_POST['district']):adminmsg('��ѡ����������',1);
	$setsqlarr['sdistrict']=intval($_POST['sdistrict']);
	$setsqlarr['district_cn']=trim($_POST['district_cn']);

	$setsqlarr['wage']=!empty($_POST['wage'])?intval($_POST['wage']):adminmsg('��ѡ��н�ʴ�����',1);
	$setsqlarr['wage_cn']=trim($_POST['wage_cn']);
	$setsqlarr['wage_structure']=!empty($_POST['wage_structure'])?$_POST['wage_structure']:adminmsg('��ѡ��н�ʣ�',1);
	$setsqlarr['socialbenefits']=trim($_POST['socialbenefits']);
	$setsqlarr['livebenefits']=trim($_POST['livebenefits']);
	$setsqlarr['annualleave']=trim($_POST['annualleave']);
	$setsqlarr['contents']=!empty($_POST['contents'])?trim($_POST['contents']):adminmsg('��û����дְλ������',1);
	check_word($_CFG['filter'],$_POST['contents'])?adminmsg($_CFG['filter_tips'],0):'';
	
	
	$setsqlarr['age']=!empty($_POST['age'])?intval($_POST['age']):adminmsg('��ѡ������Ҫ��',1);
	$setsqlarr['age_cn']=trim($_POST['age_cn']);
	$setsqlarr['sex']=intval($_POST['sex']);
	$setsqlarr['sex_cn']=trim($_POST['sex_cn']);
	$setsqlarr['experience']=!empty($_POST['experience'])?intval($_POST['experience']):adminmsg('��ѡ��������Ҫ��',1);
	$setsqlarr['experience_cn']=trim($_POST['experience_cn']);
	$setsqlarr['education']=!empty($_POST['education'])?intval($_POST['education']):adminmsg('��ѡ��ѧ��Ҫ��',1);
	$setsqlarr['education_cn']=trim($_POST['education_cn']);
	$setsqlarr['tongzhao']=intval($_POST['tongzhao']);
	$setsqlarr['tongzhao_cn']=trim($_POST['tongzhao_cn']);
	$setsqlarr['language']=trim($_POST['language']);
	//$setsqlarr['jobs_qualified']=!empty($_POST['jobs_qualified'])?trim($_POST['jobs_qualified']):adminmsg('��û����д��ְ�ʸ�',1);
	//check_word($_CFG['filter'],$_POST['jobs_qualified'])?adminmsg($_CFG['filter_tips'],0):'';
	
	//$setsqlarr['hopetrade']=!empty($_POST['hopetrade'])?trim($_POST['hopetrade']):adminmsg('��ѡ�������˲���Դ��ҵ��',1);
	//$setsqlarr['hopetrade_cn']=trim($_POST['hopetrade_cn']);
	$setsqlarr['extra_message']=trim($_POST['extra_message']);

	$setsqlarr['refreshtime']=$timestamp;
	if($utype=='5'){
		$setsqlarr['key']=$setsqlarr['jobs_name'].$setsqlarr['companyname'].$setsqlarr['category_cn'].$setsqlarr['district_cn'].$setsqlarr['contents'].$setsqlarr['jobs_qualified'];
		require_once(QISHI_ROOT_PATH.'include/splitword.class.php');
		$sp = new SPWord();
		$setsqlarr['key']="{$setsqlarr['jobs_name']} {$setsqlarr['companyname']} ".$sp->extracttag($setsqlarr['key']);
		$setsqlarr['key']=$sp->pad($setsqlarr['key']);
		$setsqlarr['likekey']=$setsqlarr['jobs_name'].','.$setsqlarr['companyname'].','.$setsqlarr['category_cn'].','.$setsqlarr['district_cn'];
	}elseif($utype=='1'){
		$setsqlarr['key']=$setsqlarr['jobs_name'].$companyname1.$setsqlarr['category_cn'].$setsqlarr['district_cn'].$setsqlarr['contents'].$setsqlarr['jobs_qualified'];
		require_once(QISHI_ROOT_PATH.'include/splitword.class.php');
		$sp = new SPWord();
		$setsqlarr['key']="{$setsqlarr['jobs_name']} {$companyname1} ".$sp->extracttag($setsqlarr['key']);
		$setsqlarr['key']=$sp->pad($setsqlarr['key']);
		$setsqlarr['likekey']=$setsqlarr['jobs_name'].','.$companyname1.','.$setsqlarr['category_cn'].','.$setsqlarr['district_cn'];
	}
	$setsqlarr['subsite_id']=intval($_POST['subsite_id']);
	if ($days>0)
	{
		if (intval($_POST['olddeadline'])>=time())
		{
			 $setsqlarr['deadline']=intval($_POST['olddeadline'])+($days*(60*60*24));
		}
		else
		{
			 $setsqlarr['deadline']=strtotime("{$days} day");
		}
	}else{
			 $setsqlarr['deadline']=intval($_POST['olddeadline']);
	}
	
	$setsqlarr['audit']=intval($_POST['audit']);
	$setsqlarr['display']=intval($_POST['display']);

	//$setsqlarr['contact']=!empty($_POST['contact'])?trim($_POST['contact']):adminmsg('��û����д��ϵ�ˣ�',1);
	//$setsqlarr['qq']=trim($_POST['qq']);
	//$setsqlarr['telephone']=!empty($_POST['telephone'])?trim($_POST['telephone']):adminmsg('��û����д��ϵ�绰��',1);
	//check_word($_CFG['filter'],$_POST['telephone'])?adminmsg($_CFG['filter_tips'],0):'';
	$setsqlarr['address']=!empty($_POST['address'])?trim($_POST['address']):adminmsg('��û����д��ϵ��ַ��',1);
	//$setsqlarr['email']=!empty($_POST['email'])?trim($_POST['email']):adminmsg('��û����д��ϵ���䣡',1);
	//$setsqlarr['notify']=intval($_POST['notify']);
	
	$setsqlarr['contact_show']=intval($_POST['contact_show']);
	$setsqlarr['email_show']=intval($_POST['email_show']);
	$setsqlarr['telephone_show']=intval($_POST['telephone_show']);
	$setsqlarr['address_show']=intval($_POST['address_show']);
	$setsqlarr['qq_show']=intval($_POST['qq_show']);
	
	//----ffff
	
	$setsqlarr['seo_title']=trim($_POST['seo_title']);
	$setsqlarr['seo_keywords']=trim($_POST['seo_keywords']);
	$setsqlarr['seo_description']=trim($_POST['seo_description']);

	$setsqlarr['zp']=intval($_POST['zp']);
	$setsqlarr['zp_cn']=trim($_POST['zp_cn']);
	
	$setsqlarr['jiezhan']=trim($_POST['jiezhan']);
	$setsqlarr['shortitle']=trim($_POST['shortitle']);
	$setsqlarr['zprenshu']=intval($_POST['zprenshu']);
	$setsqlarr['bmrenshu']=intval($_POST['bmrenshu']);
	$setsqlarr['tag']=trim($_POST['tag']);
	//---�ϴ�ͼƬ
	$logo_1=trim($_POST['logo_1']);
	if($_FILES['logo']['name']){//---�޸�ͼƬ
	require_once(QISHI_ROOT_PATH.'include/upload.php');
	!$_FILES['logo']['name']?showmsg('���ϴ�ͼƬ��',1):"";
	$uplogo_dir="../data/hymq_img/".date("Y/m/d/");
	make_dir($uplogo_dir);
	$setsqlarr['logo']=_asUpFiles($uplogo_dir, "logo",$_CFG['certificate_max_size'],'gif/jpg/bmp/png',true);//$_SESSION['uid']
	if (!$setsqlarr['logo'])
	{
		showmsg('�ϴ�ʧ�ܣ�',1);
	}
	$setsqlarr['logo']=date("Y/m/d/").$setsqlarr['logo'];
	$logo_src="../data/hymq_img/".$setsqlarr['logo'];
	$thumb_dir=$uplogo_dir;
	makethumb($logo_src,$thumb_dir,300,110);//��������ͼ
	//$wheresql="uid='".$_SESSION['uid']."'";
	}else{$setsqlarr['logo']=$logo_1;}

	//---ffff
	
	$wheresql=" id='".$id."' ";
	if (!updatetable(table('shenhe_jobs'),$setsqlarr,$wheresql)) adminmsg("����ʧ�ܣ�",0);
	$link[0]['text'] = "����ְλ�б�";
	$link[0]['href'] = $_POST['url'];
	adminmsg("�޸ĳɹ���",2,$link);
}

elseif($act == 'hunter_list')
{
	get_token();
	//check_permissions($_SESSION['admin_purview'],"hun_show");
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$oederbysql=" order BY c.id DESC ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		
		if     ($key_type===1)$wheresql=" WHERE c.huntername like '%{$key}%'";
		elseif ($key_type===2)$wheresql=" WHERE c.companyname like '%{$key}%'";
		elseif ($key_type===3)$wheresql=" WHERE m.username like '{$key}%'";
		elseif ($key_type===4)$wheresql=" WHERE c.uid ='".intval($key)."'";
		elseif ($key_type===5)$wheresql=" WHERE c.address  like '%{$key}%'";
		elseif ($key_type===6)$wheresql=" WHERE c.telephone  like '{$key}%'";		
		$oederbysql="";
	}
	$_GET['audit']<>""? $wheresqlarr['c.audit']=intval($_GET['audit']):'';
	if (is_array($wheresqlarr)) $wheresql=wheresql($wheresqlarr);
	if (!empty($_GET['settr']))
	{
		$settr=strtotime("-".intval($_GET['settr'])." day");
		$wheresql=empty($wheresql)?" WHERE addtime> ".$settr:$wheresql." AND addtime> ".$settr;
	}
	$operation_hunter_mode=$_CFG['operation_hunter_mode'];
	if($operation_hunter_mode=='1'){
		$joinsql=" LEFT JOIN ".table('members')." AS m ON c.uid=m.uid  LEFT JOIN ".table('members_points')." AS p ON c.uid=p.uid";
	}else{
		$joinsql=" LEFT JOIN ".table('members')." AS m ON c.uid=m.uid  LEFT JOIN ".table('members_hunter_setmeal')." AS p ON c.uid=p.uid";
	}
	$total_sql="SELECT COUNT(*) AS num FROM ".table('shenhe_profile')." AS c".$joinsql.$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$clist = get_hunter($offset,$perpage,$joinsql.$wheresql.$oederbysql,$operation_hunter_mode);
	$smarty->assign('pageheader',"��ͷ���ʹ���");
	$smarty->assign('clist',$clist);
 	$smarty->assign('page',$page->show(3));
	$smarty->display('banb/admin_hunter_list.htm');
}
elseif($act == 'hunter_perform')
{
	check_token();
	$u_id =!empty($_POST['y_id'])?$_POST['y_id']:adminmsg("��û��ѡ����ͷ��",1);
	if ($_POST['delete'])
	{
		//check_permissions($_SESSION['admin_purview'],"hun_del");
		if ($_POST['delete_hunter']=='yes')
		{
		!del_hunter($u_id)?adminmsg("ɾ����ͷ����ʧ�ܣ�",0):"";
		}
		if ($_POST['delete_jobs']=='yes')
		{
		!del_hunter_alljobs($u_id)?adminmsg("ɾ��ְλʧ�ܣ�",0):"";
		}
		if ($_POST['delete_jobs']<>'yes' && $_POST['delete_hunter']<>'yes')
		{
		adminmsg("δѡ��ɾ�����ͣ�",1);
		}
		adminmsg("ɾ���ɹ���",2);
	}
	if (trim($_POST['set_audit']))
	{
		//check_permissions($_SESSION['admin_purview'],"hun_audit");
		$audit=$_POST['audit'];
		$pms_notice=intval($_POST['pms_notice']);
		$reason=trim($_POST['reason']);
		!edit_hunter_audit($u_id,intval($audit),$reason,$pms_notice)?adminmsg("����ʧ�ܣ�",0):adminmsg("���óɹ���",2);
	}
	elseif (!empty($_POST['set_refresh']))
		{
			if (empty($_POST['refresh_jobs']))
			{
			$refresjobs=false;
			}
			else
			{
			$refresjobs=true;
			}
			if($n=refresh_hunter($u_id,$refresjobs))
			{
			adminmsg("ˢ�³ɹ�����Ӧ���� {$n} ��",2);
			}
			else
			{
			adminmsg("ˢ��ʧ�ܣ�",0);
			}
		}
}
elseif($act == 'edit_hunter_profile')
{
	get_token();
	//check_permissions($_SESSION['admin_purview'],"hun_edit");
	$yid =!empty($_REQUEST['id'])?intval($_REQUEST['id']):adminmsg("��û��ѡ����ͷ��",1);
	$smarty->assign('pageheader',"��ͷ���ʹ���");
	$hunter_profile=get_hunter_one_id($yid);
	$smarty->assign('url',$_SERVER["HTTP_REFERER"]);
	$smarty->assign('hunter_profile',$hunter_profile);
	$smarty->display('banb/admin_hunter_profile_edit.htm');
}
elseif ($act=='hunter_profile_save')
{
	check_token();
	//check_permissions($_SESSION['admin_purview'],"hun_edit");
	$id=intval($_POST['id']);
	$setsqlarr['audit']=intval($_POST['audit']);
	$setsqlarr['huntername']=trim($_POST['huntername'])?trim($_POST['huntername']):adminmsg('��û��������ͷ���ƣ�',1);
	$setsqlarr['companyname']=trim($_POST['companyname'])?trim($_POST['companyname']):adminmsg('��û��������ͷ���ڹ�˾��',1);
	$code=trim($_POST['code'])?trim($_POST['code']):adminmsg('��û����д�������ţ�',1);
	$telephone=trim($_POST['companytelephone'])?trim($_POST['companytelephone']):adminmsg('��û����д�������룡',1);
	$setsqlarr['companytelephone']=$code.'-'.$telephone;
	$setsqlarr['district']=intval($_POST['district'])>0?intval($_POST['district']):adminmsg('��û��ѡ������������',1);
	$setsqlarr['sdistrict']=intval($_POST['sdistrict']);
	$setsqlarr['district_cn']=trim($_POST['district_cn']);
	$setsqlarr['worktime_start']=intval($_POST['worktime_start'])>1970?intval($_POST['worktime_start']):adminmsg('��û����д��ҵ��ʼʱ�䣡',1);
	$setsqlarr['rank']=trim($_POST['rank'])?intval($_POST['rank']):adminmsg('��ѡ����ͷͷ�Σ�',1);
	$setsqlarr['rank_cn']=trim($_POST['rank_cn']);
	$setsqlarr['goodtrade']=trim($_POST['goodtrade'])?trim($_POST['goodtrade']):adminmsg('��û��ѡ���ó���ҵ��',1);
	$setsqlarr['goodtrade_cn']=trim($_POST['goodtrade_cn']);
	$setsqlarr['goodcategory']=trim($_POST['goodcategory'])?trim($_POST['goodcategory']):adminmsg('��û��ѡ���ó�ְ�ܣ�',1);
	$setsqlarr['goodcategory_cn']=trim($_POST['goodcategory_cn']);
	$setsqlarr['contents']=trim($_POST['contents'])?trim($_POST['contents']):adminmsg('����д��ͷ��飡',1);
	$setsqlarr['cooperate_company']=trim($_POST['cooperate_company']);
	
	
	$setsqlarr['address']=trim($_POST['address'])?trim($_POST['address']):adminmsg('����дͨѶ��ַ��',1);
	$setsqlarr['telephone']=trim($_POST['telephone'])?trim($_POST['telephone']):adminmsg('����д��ϵ�绰��',1);
	$setsqlarr['email']=trim($_POST['email'])?trim($_POST['email']):adminmsg('����д��ϵ���䣡',1);
	$setsqlarr['yellowpages']=intval($_POST['yellowpages']);
	
	$setsqlarr['email_show']=intval($_POST['email_show']);
	$setsqlarr['telephone_show']=intval($_POST['telephone_show']);
	$setsqlarr['address_show']=intval($_POST['address_show']);
	$wheresql=" id='{$id}' ";
	
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = $_POST['url'];
	if (updatetable(table('shenhe_profile'),$setsqlarr,$wheresql))
	{
		unset($setsqlarr);
		adminmsg("����ɹ���",2,$link);
	}
	else
	{
	unset($setsqlarr);
	adminmsg("����ʧ�ܣ�",0);
	}
}
elseif($act == 'members_list')
{
	get_token();
	//check_permissions($_SESSION['admin_purview'],"hun_user_show");
		require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$wheresql=" WHERE m.utype=3 ";
	$oederbysql=" order BY m.uid DESC ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		if     ($key_type===1)$wheresql.=" AND m.username = '{$key}'";
		elseif ($key_type===2)$wheresql.=" AND m.uid = '".intval($key)."' ";
		elseif ($key_type===3)$wheresql.=" AND m.email = '{$key}'";
		elseif ($key_type===4)$wheresql.=" AND m.mobile like '{$key}%'";
		elseif ($key_type===5)$wheresql.=" AND c.huntername like '%{$key}%'";
		$oederbysql="";
	}
	else
	{	
		if (!empty($_GET['settr']))
		{
			$settr=strtotime("-".intval($_GET['settr'])." day");
			$wheresql.=" AND m.reg_time> ".$settr;
		}
		if (!empty($_GET['verification']))
		{
			if ($_GET['verification']=="1")
			{
			$wheresql.=" AND m.email_audit = 1";
			}
			elseif ($_GET['verification']=="2")
			{
			$wheresql.=" AND m.email_audit = 0";
			}
			elseif ($_GET['verification']=="3")
			{
			$wheresql.=" AND m.mobile_audit = 1";
			}
			elseif ($_GET['verification']=="4")
			{
			$wheresql.=" AND m.mobile_audit = 0";
			}
		}
	}
	$joinsql=" LEFT JOIN ".table('shenhe_profile')." as c ON m.uid=c.uid ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('members')." as m ".$joinsql.$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$member = get_member_list($offset,$perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('pageheader',"��ͷ���ʻ�Ա");
	$smarty->assign('member',$member);
	$smarty->assign('page',$page->show(3));
	$smarty->display('banb/admin_hunter_user_list.htm');
}
elseif($act == 'delete_user')
{	
	check_token();
	//check_permissions($_SESSION['admin_purview'],"hun_user_del");
	$tuid =!empty($_REQUEST['tuid'])?$_REQUEST['tuid']:adminmsg("��û��ѡ���Ա��",1);
	if ($_POST['delete'])
	{
		if (!empty($_POST['delete_user']))
		{
		!delete_hunter_user($tuid)?adminmsg("ɾ����Աʧ�ܣ�",0):"";
		}
		if (!empty($_POST['delete_hunter']))
		{
		!del_hunter($tuid)?adminmsg("ɾ����ͷ����ʧ�ܣ�",0):"";
		}
		if (!empty($_POST['delete_jobs']))
		{
		!del_hunter_alljobs($tuid)?adminmsg("ɾ��ְλʧ�ܣ�",0):"";
		}
	adminmsg("ɾ���ɹ���",2);
	}
}
elseif($act == 'members_add')
{
	get_token();
	//check_permissions($_SESSION['admin_purview'],"hun_user_add");
	$smarty->assign('pageheader',"��ͷ���ʻ�Ա");
	$smarty->assign('givesetmeal',get_setmeal(false));
	$smarty->assign('points',get_cache('points_rule'));
	$smarty->display('banb/admin_hunter_user_add.htm');
}
elseif($act == 'members_add_save')
{
	check_token();
	//check_permissions($_SESSION['admin_purview'],"hun_user_add");
	require_once(ADMIN_ROOT_PATH.'include/admin_user_fun.php');
	if (strlen(trim($_POST['username']))<3) adminmsg('�û�������Ϊ3λ���ϣ�',1);
	if (strlen(trim($_POST['password']))<6) adminmsg('�������Ϊ6λ���ϣ�',1);
	$sql['username'] = !empty($_POST['username']) ? trim($_POST['username']):adminmsg('����д�û�����',1);
	$sql['password'] = !empty($_POST['password']) ? trim($_POST['password']):adminmsg('����д���룡',1);	
	if ($sql['password']<>trim($_POST['password1']))
	{
	adminmsg('������������벻��ͬ��',1);
	}
	$sql['utype'] = !empty($_POST['member_type']) ? intval($_POST['member_type']):adminmsg('��û��ѡ��ע�����ͣ�',1);
	if (empty($_POST['email']) || !preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$_POST['email']))
	{
	adminmsg('���������ʽ����',1);
	}
	$sql['email']= trim($_POST['email']);
	if (get_user_inusername($sql['username']))
	{
	adminmsg('���û����Ѿ���ʹ�ã�',1);
	}
	if (get_user_inemail($sql['email']))
	{
	adminmsg('�� Email �Ѿ���ע�ᣡ',1);
	}
	if(defined('UC_API'))
	{
		include_once(QISHI_ROOT_PATH.'uc_client/client.php');
		if (uc_user_checkname($sql['username'])<>"1")
		{
		adminmsg('���û����Ѿ���ʹ�û����û����Ƿ���',1);
		exit();
		}
		elseif (uc_user_checkemail($sql['email'])<>"1")
		{
			adminmsg('�� Email�Ѿ���ʹ�û��߷Ƿ���',1);
			exit();
		}
		else
		{
			uc_user_register($sql['username'],$sql['password'],$sql['email']);
		}
	}
	$sql['pwd_hash'] = randstr();
	$sql['password'] = md5(md5($sql['password']).$sql['pwd_hash'].$QS_pwdhash);
	$sql['reg_time']=time();
	$sql['reg_ip']=$online_ip;
	$insert_id=inserttable(table('members'),$sql,true);
			if($sql['utype']=="3")
			{
			$db->query("INSERT INTO ".table('members_points')." (uid) VALUES ('{$insert_id}')");
			$db->query("INSERT INTO ".table('members_hunter_setmeal')." (uid) VALUES ('{$insert_id}')");
				if(intval($_POST['is_money']) && $_POST['log_amount']){
					$amount=round($_POST['log_amount'],2);
					$ismoney=2;
				}else{
					$amount='0.00';
					$ismoney=1;
				}
				$regpoints_num=intval($_POST['regpoints_num']);
				if ($_POST['regpoints']=="y")
				{
				write_memberslog($insert_id,3,9201,$sql['username'],"<span style=color:#FF6600>ע���Աϵͳ�Զ�����!(+{$regpoints_num})</span>");
 				//��Ա���ֱ����¼������Ա��̨�޸Ļ�Ա�Ļ��֡�3��ʾ������Ա��̨�޸�
				$notes="�����ˣ�{$_SESSION['admin_name']},˵������̨������ͷ��Ա������(+{$regpoints_num})���֣���ȡ���ã�{$amount}Ԫ";
				write_setmeallog($insert_id,$sql['username'],$notes,4,$amount,$ismoney,1,3);
 				report_deal($insert_id,1,$regpoints_num);
				}
				$reg_service=intval($_POST['reg_service']);
				if ($reg_service>0)
				{
				$service=get_setmeal_one($reg_service);
				write_memberslog($insert_id,3,9202,$sql['username'],"��ͨ����({$service['setmeal_name']})");
				set_members_setmeal($insert_id,$reg_service);
 				//��Ա���ֱ����¼������Ա��̨�޸Ļ�Ա�Ļ��֡�3��ʾ������Ա��̨�޸�
				$notes="�����ˣ�{$_SESSION['admin_name']},˵������̨������ͷ��Ա����ͨ����({$service['setmeal_name']})����ȡ���ã�{$amount}Ԫ";
				write_setmeallog($insert_id,$sql['username'],$notes,4,$amount,$ismoney,2,3);
 				}
				if(intval($_POST['is_money']) && $_POST['log_amount'] && !$notes){
				$notes="�����ˣ�{$_SESSION['admin_name']},˵������̨������ͷ��Ա��δ���ͻ��֣�δ��ͨ�ײͣ���ȡ���ã�{$amount}Ԫ";
				write_setmeallog($insert_id,$sql['username'],$notes,4,$amount,2,2,3);
				}			
			}
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = "?act=members_list";
	$link[1]['text'] = "��������";
	$link[1]['href'] = "?act=members_add";
	adminmsg('���ӳɹ���',2,$link);
}
elseif($act == 'user_edit')
{
	get_token();
	//check_permissions($_SESSION['admin_purview'],"hun_user_edit");
	$hunter_user=get_user($_GET['tuid']);
	$smarty->assign('pageheader',"��ͷ���ʻ�Ա");
	$hunter_profile=get_hunter_one_uid($hunter_user['uid']);
	$smarty->assign('hunter_user',$hunter_user);
	$smarty->assign('userpoints',get_user_points($hunter_user['uid']));
	$smarty->assign('setmeal',get_user_setmeal($hunter_user['uid']));
	$smarty->assign('givesetmeal',get_setmeal(false));
	$smarty->assign('url',$_SERVER["HTTP_REFERER"]);
	$smarty->display('banb/admin_hunter_user_edit.htm');
}
elseif($act == 'set_account_save')
{
	check_token();
	//check_permissions($_SESSION['admin_purview'],"hun_user_edit");
	require_once(ADMIN_ROOT_PATH.'include/admin_user_fun.php');
	$setsqlarr['username']=trim($_POST['username']);
	$setsqlarr['email']=trim($_POST['email']);
	$setsqlarr['email_audit']=intval($_POST['email_audit']);
	$setsqlarr['mobile']=trim($_POST['mobile']);
	$setsqlarr['mobile_audit']=intval($_POST['mobile_audit']);
	if ($_POST['qq_openid']=="1")
	{
	$setsqlarr['qq_openid']='';
	}
	$thisuid=intval($_POST['hunter_uid']);	
	if (strlen($setsqlarr['username'])<3) adminmsg('�û�������Ϊ3λ���ϣ�',1);
	$getusername=get_user_inusername($setsqlarr['username']);
	if (!empty($getusername)  && $getusername['uid']<>$thisuid)
	{
	adminmsg("�û��� {$setsqlarr['username']}  �Ѿ����ڣ�",1);
	}
	if (empty($setsqlarr['email']) || !preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$setsqlarr['email']))
	{
	adminmsg('���������ʽ����',1);
	}
	$getemail=get_user_inemail($setsqlarr['email']);
	if (!empty($getemail)  && $getemail['uid']<>$thisuid)
	{
	adminmsg("Email  {$setsqlarr['email']}  �Ѿ����ڣ�",1);
	}
	if (!empty($setsqlarr['mobile']) && !preg_match("/^(13|15|14|17|18)\d{9}$/",$setsqlarr['mobile']))
	{
	adminmsg('�ֻ��������',1);
	}
	$getmobile=get_user_inmobile($setsqlarr['mobile']);
	if (!empty($setsqlarr['mobile']) && !empty($getmobile)  && $getmobile['uid']<>$thisuid)
	{
	adminmsg("�ֻ��� {$setsqlarr['mobile']}  �Ѿ����ڣ�",1);
	}
	if (updatetable(table('members'),$setsqlarr," uid=".$thisuid.""))
	{
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = $_POST['url'];
	adminmsg('�޸ĳɹ���',2,$link);
	}
	else
	{
	adminmsg('�޸�ʧ�ܣ�',1);
	}
}
elseif($act == 'userpass_edit')
{
	check_token();
	//check_permissions($_SESSION['admin_purview'],"hun_user_edit");
	if (strlen(trim($_POST['password']))<6) adminmsg('���������Ϊ6λ���ϣ�',1);
	require_once(ADMIN_ROOT_PATH.'include/admin_user_fun.php');
	$user_info=get_user_inusername($_POST['username']);
	$pwd_hash=$user_info['pwd_hash'];
	$md5password=md5(md5(trim($_POST['password'])).$pwd_hash.$QS_pwdhash);	
	if ($db->query( "UPDATE ".table('members')." SET password = '$md5password'  WHERE uid='".$user_info['uid']."'"))
	{
			if(defined('UC_API'))
			{
			include_once(QISHI_ROOT_PATH.'uc_client/client.php');
			uc_user_edit($user_info['username'],trim($_POST['password']),trim($_POST['password']),"",1);
			}
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = $_POST['url'];
	adminmsg('�����ɹ���',2,$link);
	}
	else
	{
	adminmsg('����ʧ�ܣ�',1);
	}
}
elseif($act == 'userstatus_edit')
{
	check_token();
	//check_permissions($_SESSION['admin_purview'],"hun_user_edit");
	if ($db->query( "UPDATE ".table('members')." SET status = '".intval($_POST['status'])."'  WHERE uid='".intval($_POST['userstatus_uid'])."'"))
	{
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = $_POST['url'];
	adminmsg('�����ɹ���',2,$link);
	}
	else
	{
	adminmsg('����ʧ�ܣ�',1);
	}
}
elseif($act == 'userpoints_edit')
{
	check_token();
	//check_permissions($_SESSION['admin_purview'],"hun_user_edit");
	if (intval($_POST['points'])<1) adminmsg('��������֣�',1);
	if (trim($_POST['points_notes'])=='') adminmsg('����д���ֲ���˵����',1);
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = $_POST['url'];
	$user=get_user($_POST['hunter_uid']);
	$points_type=intval($_POST['points_type']);	
	$t=$points_type==1?"+":"-";
	report_deal($user['uid'],$points_type,intval($_POST['points']));
	$points=get_user_points($user['uid']);
	write_memberslog(intval($_POST['hunter_uid']),3,9201,$user['username']," ����Ա��������({$t}{$_POST['points']})��(ʣ��:{$points})����ע��".$_POST['points_notes']);
		//��Ա���ֱ����¼������Ա��̨�޸Ļ�Ա�Ļ��֡�3��ʾ������Ա��̨�޸�
 		if(intval($_POST['is_money']) && $_POST['log_amount']){
			$amount=round($_POST['log_amount'],2);
			$ismoney=2;
		}else{
			$amount='0.00';
			$ismoney=1;
		}
		$notes="�����ˣ�{$_SESSION['admin_name']},˵�����޸Ļ�Ա {$user['username']} ���� ({$t}{$_POST['points']})����ȡ���ֽ�{$amount} Ԫ����ע��{$_POST['points_notes']}";
		write_setmeallog($_POST['hunter_uid'],$user['username'],$notes,3,$amount,$ismoney,1,3);
 	adminmsg('����ɹ���',2);
}
elseif($act == 'edit_setmeal_save')
{
	check_token();
    //check_permissions($_SESSION['admin_purview'],"hun_user_edit");
	$setsqlarr['jobs_add']=$_POST['jobs_add'];
	$setsqlarr['download_resume_talent']=$_POST['download_resume_manager'];
	$setsqlarr['interview_manager']=$_POST['interview_manager'];
  	$setsqlarr['added']=$_POST['added'];
	if ($_POST['setendtime']<>"")
	{
		$setendtime=convert_datefm($_POST['setendtime'],2);
		if ($setendtime=='')
		{
		adminmsg('���ڸ�ʽ����',0);	
		}
		else
		{
		$setsqlarr['endtime']=$setendtime;
		}
	}
	else
	{
	$setsqlarr['endtime']=0;
	}
	if ($_POST['days']<>"")
	{
			if (intval($_POST['days'])<>0)
			{
				$oldendtime=intval($_POST['oldendtime']);
				$setsqlarr['endtime']=strtotime("".intval($_POST['days'])." days",$oldendtime==0?time():$oldendtime);
			}
			if (intval($_POST['days'])=="0")
			{
				$setsqlarr['endtime']=0;
			}
	}
	$setmealtime=$setsqlarr['endtime'];
	$hunter_uid=intval($_POST['hunter_uid']);
	if ($hunter_uid)
	{
			$setmeal=get_user_setmeal($hunter_uid);
			if (!updatetable(table('members_hunter_setmeal'),$setsqlarr," uid=".$hunter_uid."")) adminmsg('�޸ĳ�����',0);
 		//��Ա�ײͱ����¼������Ա��̨�޸Ļ�Ա�ײͣ��޸Ļ�Ա��3��ʾ������Ա��̨�޸�
			$setmeal['endtime']=date('Y-m-d',$setmeal['endtime']);
			$setsqlarr['endtime']=date('Y-m-d',$setsqlarr['endtime']);
			$setsqlarr['log_amount']=round($_POST['log_amount']);
			$notes=edit_setmeal_notes($setsqlarr,$setmeal);
			if($notes){
				$user=get_user($_POST['hunter_uid']);
				$ismoney=round($_POST['log_amount'])?2:1;
				write_setmeallog($hunter_uid,$user['username'],$notes,3,$setsqlarr['log_amount'],$ismoney,2,3);
			}
 			if ($setsqlarr['endtime']<>"")
			{
				$setmeal_deadline['setmeal_deadline']=$setmealtime;
				if (!updatetable(table('shenhe_jobs'),$setmeal_deadline," uid='{$hunter_uid}' AND add_mode='2' "))adminmsg('�޸ĳ�����',0);
			}
	}
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = $_POST['url'];
	adminmsg('�����ɹ���',2,$link);
}
 
elseif($act == 'set_setmeal_save')
{
	check_token();
	//check_permissions($_SESSION['admin_purview'],"hun_user_edit");
    if (intval($_POST['reg_service'])>0)
	{
		if (set_members_setmeal($_POST['hunter_uid'],$_POST['reg_service']))
		{
		$link[0]['text'] = "�����б�";
		$link[0]['href'] = $_POST['url'];
 		//��Ա�ײͱ����¼������Ա��̨�޸Ļ�Ա�ײͣ����¿�ͨ�ײ͡�3��ʾ������Ա��̨�޸�
		$user=get_user($_POST['hunter_uid']);
		if(intval($_POST['is_money']) && $_POST['log_amount']){
			$amount=round($_POST['log_amount'],2);
			$ismoney=2;
		}else{
			$amount='0.00';
			$ismoney=1;
		}
		$notes="�����ˣ�{$_SESSION['admin_name']},˵����Ϊ��Ա {$user['username']} ���¿�ͨ������ȡ�����{$amount}Ԫ������ID��{$_POST['reg_service']}��";
		write_setmeallog($_POST['hunter_uid'],$user['username'],$notes,4,$amount,$ismoney,2,3);
 		adminmsg('�����ɹ���',2,$link);
		}
		else
		{
		adminmsg('����ʧ�ܣ�',1);
		}
	}
	else
	{
	adminmsg('��ѡ������ײͣ�',1);
	}	
}
elseif($act == 'meal_log')
{
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$oederbysql=" order BY a.log_id DESC ";
	$key_uid=isset($_GET['key_uid'])?trim($_GET['key_uid']):"";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	$operation_hunter_mode=$_CFG['operation_hunter_mode'];
	//���֡��ײ�����ģʽ�����¼
	if($operation_hunter_mode=='1')
	{
		$wheresql=" WHERE a.log_mode=1 AND a.log_utype=3";
	}
	elseif($operation_hunter_mode=='2')
	{
		$wheresql=" WHERE a.log_mode=2 AND a.log_utype=3";
	}
	//������Ա(uid)�鿴�����¼
	if ($key_uid)
	{
		$wheresql.="  AND a.log_uid = '".intval($key_uid)."' ";
		//������ʶ�������ѯ������Ա�Ļ� ��ô���½ǵ���������û����
		$smarty->assign('sign','1');
	}
	//����������� : ����ĳ����Ա�ı����¼
	elseif ($key && $key_type>0)
	{
		if     ($key_type===1)$wheresql.="  AND a.log_username = '{$key}'";
		elseif ($key_type===2)$wheresql.="  AND a.log_uid = '".intval($key)."' ";
		elseif ($key_type===3)$wheresql.=" AND c.huntername like '{$key}%'";
		$oederbysql=" order BY a.log_id DESC ";
	}
	//��������ɸѡ��1->ϵͳ���͡�2->��Ա����3->����Ա�޸ġ�4->����Ա��ͨ����ɸѡ
	if (!empty($_GET['log_type']))
	{
		$log_type=intval($_GET['log_type']);
		$wheresql.=" AND  a.log_type=".$log_type;
	}
	if (!empty($_GET['settr']))
	{
		$settr=intval($_GET['settr']);
		$settr=strtotime("-{$settr} day");
		$wheresql.=" AND a.log_addtime> ".$settr;
	}
	if (!empty($_GET['is_money']))
	{
		$is_money=intval($_GET['is_money']);
		$wheresql.= " AND a.log_ismoney={$is_money}";
	}
	if($operation_hunter_mode=='1')
	{
		$joinsql=" LEFT JOIN ".table('members_points')." as b ON a.log_uid=b.uid  LEFT JOIN ".table('shenhe_profile')." as c ON a.log_uid=c.uid ";
	}
	else
	{
		$joinsql=" LEFT JOIN ".table('members_hunter_setmeal')." as b ON a.log_uid=b.uid  LEFT JOIN ".table('shenhe_profile')." as c ON a.log_uid=c.uid ";
	}
	$total_sql="SELECT COUNT(*) AS num FROM ".table('members_charge_log')." as a ".$joinsql.$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$meallog = get_meal_members_log($offset,$perpage,$joinsql.$wheresql.$oederbysql,$operation_hunter_mode);
	$smarty->assign('pageheader','��ͷ���ʹ���');
	$smarty->assign('navlabel','meal_log');
	$smarty->assign('meallog',$meallog);
	$smarty->assign('page',$page->show(3));
	$smarty->display('banb/admin_hunter_meal_log.htm');
}
elseif($act == 'meallog_del')
{
	//check_permissions($_SESSION['admin_purview'],"meallog_del");
	check_token();
	$id =!empty($_REQUEST['id'])?$_REQUEST['id']:adminmsg("��û��ѡ���¼��",1);
	$num=del_meal_log($id);
	if ($num>0){adminmsg("ɾ���ɹ�����ɾ��".$num."��",2);}else{adminmsg("ɾ��ʧ�ܣ�",0);}
}
elseif($act == 'meal_members')
{
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$wheresql=" WHERE a.effective=1 ";
	$oederbysql=" order BY a.uid DESC ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		if     ($key_type===1)$wheresql.=" AND b.username = '{$key}'";
		elseif ($key_type===2)$wheresql.=" AND b.uid = '".intval($key)."' ";
		elseif ($key_type===3)$wheresql.=" AND b.email = '{$key}'";
		elseif ($key_type===4)$wheresql.=" AND b.mobile like '{$key}%'";
		elseif ($key_type===5)$wheresql.=" AND c.huntername like '{$key}%'";
		$oederbysql="";
	}
	else
	{	
		if (!empty($_GET['setmeal_id']))
		{
			$setmeal_id=intval($_GET['setmeal_id']);
			$wheresql.=" AND a.setmeal_id=".$setmeal_id;
		}
		if (!empty($_GET['settr']))
		{
			$settr=intval($_GET['settr']);
			if ($settr==-1)
			{
			$wheresql.=" AND a.endtime<".time()." AND a.endtime>0 ";
			}
			else
			{
			$settr=strtotime("{$settr} day");
			$wheresql.="  AND a.endtime>".time()." AND a.endtime< {$settr}";
			}			
		}
	}
	$joinsql=" LEFT JOIN ".table('members')." as b ON a.uid=b.uid  LEFT JOIN ".table('shenhe_profile')." as c ON a.uid=c.uid ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('members_hunter_setmeal')." as a ".$joinsql.$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$member = get_meal_members_list($offset,$perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('pageheader',"��ͷ����");
	$smarty->assign('navlabel','meal_members');
	$smarty->assign('member',$member);
	$smarty->assign('setmeal',get_setmeal());	
	$smarty->assign('page',$page->show(3));
	$smarty->display('banb/admin_hunter_meal_members.htm');
}
elseif($act == 'meal_delay')
{
			$tuid =!empty($_REQUEST['tuid'])?$_REQUEST['tuid']:adminmsg("��û��ѡ���Ա��",1);
			$days=intval($_POST['days']);
			if (empty($days))
			{
			adminmsg("����дҪ�ӳ���������",0);
			}
			if($n=delay_meal($tuid,$days))
			{
 			adminmsg("�ӳ���Ч�ڳɹ�����Ӧ���� {$n}",2);
			}
			else
			{
			adminmsg("����ʧ�ܣ�",0);
			}
}
elseif($act == 'order_list')
{	
	get_token();
	//check_permissions($_SESSION['admin_purview'],"ord_show");
		require_once(QISHI_ROOT_PATH.'include/page.class.php');
		require_once(ADMIN_ROOT_PATH.'include/admin_pay_fun.php');
	$wheresql=" WHERE o.utype=3 ";
	$oederbysql=" order BY o.addtime DESC ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		if     ($key_type===1)$wheresql=" WHERE o.utype=3 AND c.huntername like '%{$key}%'";
		elseif ($key_type===2)$wheresql=" WHERE o.utype=3 AND m.username = '{$key}'";
		elseif ($key_type===3)$wheresql=" WHERE o.utype=3 AND o.oid ='".trim($key)."'";
		$oederbysql="";
	}
	else
	{	
		$wheresqlarr['o.utype']='3';
		!empty($_GET['is_paid'])? $wheresqlarr['o.is_paid']=intval($_GET['is_paid']):'';
		!empty($_GET['typename'])?$wheresqlarr['o.payment_name']=trim($_GET['typename']):'';
		if (is_array($wheresqlarr)) $wheresql=wheresql($wheresqlarr);
		
		if (!empty($_GET['settr']))
		{
			$settr=strtotime("-".intval($_GET['settr'])." day");
			$wheresql.=empty($wheresql)?" WHERE ": " AND ";
			$wheresql.="o.addtime> ".$settr;
		}
	}
	$joinsql=" left JOIN ".table('members')." as m ON o.uid=m.uid LEFT JOIN  ".table('shenhe_profile')." as c ON o.uid=c.uid ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('order')." as o ".$joinsql.$wheresql;
  	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$orderlist = get_order_list($offset,$perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('pageheader',"��������");
	$smarty->assign('payment_list',get_payment(2));
	$smarty->assign('orderlist',$orderlist);
	$smarty->assign('page',$page->show(3));
	$smarty->display('banb/admin_order_list.htm');
}
elseif($act == 'order_set')
{
	get_token();
	//check_permissions($_SESSION['admin_purview'],"ord_set");
	$smarty->assign('pageheader',"��������");
	$smarty->assign('url',$_SERVER["HTTP_REFERER"]);
	$smarty->assign('payment',get_order_one($_GET['id']));
	$smarty->display('banb/admin_order_set.htm');
}
elseif($act == 'order_set_save')
{
	check_token();
	//check_permissions($_SESSION['admin_purview'],"ord_set");
		if (order_paid(trim($_POST['oid'])))
		{
		$link[0]['text'] = "�����б�";
		$link[0]['href'] = $_POST['url'];
		!$db->query("UPDATE ".table('order')." SET notes='".$_POST['notes']."' WHERE id=".intval($_GET['id'])."  LIMIT 1 ")?adminmsg('����ʧ��',1):adminmsg("�����ɹ���",2,$link);
		}
		else
		{
		adminmsg('����ʧ��',1);
		}
}
elseif($act == 'show_order')
{
	get_token();
	//check_permissions($_SESSION['admin_purview'],"ord_show");
	$smarty->assign('pageheader',"��������");
	$smarty->assign('url',$_SERVER["HTTP_REFERER"]);
	$smarty->assign('payment',get_order_one($_GET['id']));
	$smarty->display('banb/admin_order_show.htm');
}

elseif($act == 'order_notes_save')
{
	check_token();
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = $_POST['url'];
	!$db->query("UPDATE ".table('order')." SET  notes='".$_POST['notes']."' WHERE id='".intval($_GET['id'])."'")?adminmsg('����ʧ��',1):adminmsg("�����ɹ���",2,$link);
}
elseif($act == 'order_del')
{
	check_token();
	//check_permissions($_SESSION['admin_purview'],"ord_del");
	$id =!empty($_REQUEST['id'])?$_REQUEST['id']:adminmsg("��û��ѡ����Ŀ��",1);
	if (del_order($id))
	{
	adminmsg("ȡ���ɹ���",2,$link);
	}
	else
	{
	adminmsg("ȡ��ʧ�ܣ�",1);
	}
}
 elseif($act == 'meal_log_pie')
{
	require_once(ADMIN_ROOT_PATH.'include/admin_flash_statement_fun.php');
	$pie_type=!empty($_GET['pie_type'])?intval($_GET['pie_type']):1;
	meal_hunter_log_pie($pie_type,3);	
	$smarty->assign('pageheader',"��ͷ���ʹ���");
	$smarty->assign('navlabel','meal_log_pie');
	$smarty->display('banb/admin_hunter_meal_log_pie.htm');
}
 elseif($act == 'management')
{	
	$id=intval($_GET['id']);
	$u=get_user($id);
	if (!empty($u))
	{
		unset($_SESSION['uid']);
		unset($_SESSION['username']);
		unset($_SESSION['utype']);
		unset($_SESSION['uqqid']);
		setcookie("QS[uid]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
		setcookie("QS[username]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
		setcookie("QS[password]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
		setcookie("QS[utype]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
		unset($_SESSION['activate_username']);
		unset($_SESSION['activate_email']);
		
		$_SESSION['uid']=$u['uid'];
		$_SESSION['username']=$u['username'];
		$_SESSION['utype']=$u['utype'];
		$_SESSION['uqqid']="1";
		setcookie('QS[uid]',$u['uid'],0,$QS_cookiepath,$QS_cookiedomain);
		setcookie('QS[username]',$u['username'],0,$QS_cookiepath,$QS_cookiedomain);
		setcookie('QS[password]',$u['password'],0,$QS_cookiepath,$QS_cookiedomain);
		setcookie('QS[utype]',$u['utype'], 0,$QS_cookiepath,$QS_cookiedomain);
		header("Location:".get_member_url($u['utype'],false,$_CFG['site_dir']));
	}	
} 
?>