<?php
 /*
 * 74cms 计划任务 每日数据统计
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
if(!defined('IN_QISHI'))
{
die('Access Denied!');
}
ignore_user_abort(true);
set_time_limit(180);
	global $_CFG;
	$_CFG = get_cache('config');
	$_CFG['web_logo']=$_CFG['web_logo']?$_CFG['web_logo']:'logo.gif';
	$_CFG['upfiles_dir']=$_CFG['site_dir']."data/".$_CFG['updir_images']."/";
	$mailconfig=get_cache('mailconfig');
	$today = strtotime(date('Y-m-d'));
	$list = $db->getall("select * from ".table('jobs_subscribe'));
	if($list){
		foreach ($list as $key => $value) {
			$value = array_map("addslashes", $value);
			$addtime = strtotime(date('Y-m-d',$value['addtime']));
				 if(((($today-$addtime)/24/3600)%$value['days'])==0){
					$search_name = trim($value['search_name']);
					$district = trim($value['district']);
					$district_arr = explode(",", $district);
					foreach ($district_arr as $key => $n) {
						$v = explode(".", $n);
						if(intval($v[1])==0){
							if(intval($v[0])==0){
								continue;
							}else{
								$district_str_arr[] = intval($v[0]);
							}
					    }else{
					        $sdistrict_str_arr[] = intval($v[1]);
					    }
					}
					$district_str = implode(",", $district_str_arr);
				    $sdistrict_str = implode(",", $sdistrict_str_arr);
				    if($district_str){
				        $wheresql = " where district in (".$district_str.")";
				    }
					if($sdistrict_str){
				        $wheresql = $wheresql==''?" where sdistrict in (".$sdistrict_str.")":$wheresql." OR sdistrict in (".$sdistrict_str.")";
				    }

					if($search_name){
				        $wheresql = $wheresql==''?" WHERE likekey LIKE '%{$search_name}%' ":$wheresql." AND likekey LIKE '%{$search_name}%' ";
				    }
					$jobsearchkey = $db->getall("select id from ".table('jobs_search_key').$wheresql);
					foreach ($jobsearchkey as $n) {
						$idarr[] = $n['id'];
					}
					$id_str = empty($idarr)?"0":implode(",", $idarr);
					$html = '<table width="700" cellspacing="0" cellpadding="0" border="0" style="margin:0 auto;color:#555; font:16px/26px \'微软雅黑\',\'宋体\',Arail; ">
	    	<tbody><tr>
	        	<td style="height:62px; background-color:#FCFCFC; padding:10px 0 0 10px;">
	            	<a target="_blank" href="'.$_CFG['site_domain'].$_CFG['site_dir'].'"><img src="'.$_CFG['site_domain'].$_CFG['upfiles_dir'].$_CFG['web_logo'].'" width="200" height="45" style="border:none;"/></a>
	            </td>
	        </tr>
	        <tr style="background-color:#fff;">
	        	<td style="padding:30px 38px;">
	            	<div>亲爱的<span style="color:#017FCF;"><a href="mailto:'.$setsqlarr['email'].'" target="_blank">'.$setsqlarr['email'].'</a></span>，你好!</div>';
	    if($id_str=="0"){
	    	$html .='<div style="text-indent:2em;">你在<a style="color:#017FCF;" href="'.$_CFG['site_domain'].$_CFG['site_dir'].'" target="_blank">'.$_CFG['site_name'].'</a>上订阅了"<span style="color:#017FCF;">'.$search_name.'</span>"相关职位信息，经我们精心的挑选，并没有找到与您意向相符的职位，您可以<a href="'.$_CFG['site_domain'].$_CFG['site_dir'].'">重新选择</a>。祝职业更上一层楼！</div>';
	    }else{
	    	$html .='<div style="text-indent:2em;">你在<a style="color:#017FCF;" href="'.$_CFG['site_domain'].$_CFG['site_dir'].'" target="_blank">'.$_CFG['site_name'].'</a>上订阅了"<span style="color:#017FCF;">'.$search_name.'</span>"相关职位信息，经我们精心的挑选，现将筛选结果发送给你，希望我们的邮件能够对你有所帮助。祝职业更上一层楼！</div>
	                <div style="text-indent:2em;"></div>
	            	<div style="border-bottom:1px solid #e6e6e6; font-weight:bold; margin:20px 0 0 0; padding-bottom:5px;">以下是你订阅的职位：</div>
	            	<ul style="list-style:none; margin:0; padding:0;">';
	    $jobslist = $db->getall("select subsite_id,id,uid,jobs_name,companyname,company_id,district_cn from ".table('jobs')." where id in (".$id_str.")");
	   	if($jobslist){
			foreach ($jobslist as $k=>$v) {
				$jobs_url = url_rewrite('QS_jobsshow',array('id'=>$v['id']),true,$v['subsite_id']);
				$company_url = url_rewrite('QS_companyshow',array('id'=>$v['company_id']),false);
				$logo = $db->getone("select logo,district_cn from ".table('company_profile')." where id=".$v['company_id']);
				if($logo['logo']==""){
					$company_logo = $_CFG['site_domain'].$_CFG['site_dir']."data/logo/no_logo.gif";
				}else{
					$company_logo = $_CFG['site_domain'].$_CFG['site_dir']."data/logo/".$logo['logo'];
				}
				$html .='<li style="list-style:none;padding:15px 10px 15px 0;border-bottom:1px solid #e6e6e6; overflow:hidden;">
	    <a target="_blank" href="'.$company_url.'">
	    <img width="80" height="80" style="border:none; float:left; margin-right:15px;" src="'.$company_logo.'">
	    </a>
	    <div>
	    <a target="_blank" style="float:left; color:#017FCF; text-decoration:underline;" href="'.$jobs_url.'">
	    '.$v['jobs_name'].'
	    </a>
	    <a target="_blank" style="float:right; color:#017FCF; text-decoration:underline;" href="'.$jobs_url.'">
	    查看详情
	    </a><br>
	    <div style="font-weight:700;">'.$v['companyname'].'</div>
	    <div>工作地区：'.$v["district_cn"].'</div>
	    </div>
	    </li>';
			}
		}
	    
	    $html .='</ul>
	                <a target="_blank" style="float:right; text-decoration:underline; font-weight:700; margin:15px 0;color:#017FCF;" href="'.$_CFG["site_domain"].$_CFG["site_dir"].'jobs/jobs-list.php">查看所有职位</a>
	            </td>
	        </tr>';
	    }
	                
	    $html .='
	        <tr>
	        	<td style="text-align:center; color:#c9cbce; font-size:14px; padding:5px 0;">公司网址：<a style="color:#017FCF;" target="_blank" href="'.$_CFG["site_domain"].$_CFG["site_dir"].'">'.$_CFG["site_domain"].$_CFG["site_dir"].'</a>   </td>
	        </tr>
	        <tr>
	            <td style="line-height:30px;text-align:right;font-size:14px;"> 为保证邮箱正常接收，请将<a href="mailto:'.$mailconfig['smtpfrom'].'" target="_blank">'.$mailconfig['smtpfrom'].'</a>添加进你的通讯录</td>
	        </tr>
	    </tbody></table>';
					 
					smtp_mail($value['email'],$_CFG['site_name']."向您发送了您订阅的职位信息",$html,$mailconfig['smtpfrom'],$_CFG['site_name']);
						
				 }
			
		}
	}
	//更新任务时间表
	if ($crons['weekday']>=0)
	{
	$weekday=array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$nextrun=strtotime("Next ".$weekday[$crons['weekday']]);
	}
	elseif ($crons['day']>0)
	{
	$nextrun=strtotime('+1 months'); 
	$nextrun=mktime(0,0,0,date("m",$nextrun),$crons['day'],date("Y",$nextrun));
	}
	else
	{
	$nextrun=time();
	}
	if ($crons['hour']>=0)
	{
	$nextrun=strtotime('+1 days',$nextrun); 
	$nextrun=mktime($crons['hour'],0,0,date("m",$nextrun),date("d",$nextrun),date("Y",$nextrun));
	}
	if (intval($crons['minute'])>0)
	{
	$nextrun=strtotime('+1 hours',$nextrun); 
	$nextrun=mktime(date("H",$nextrun),$crons['minute'],0,date("m",$nextrun),date("d",$nextrun),date("Y",$nextrun));
	}
	$setsqlarr['nextrun']=$nextrun;
	$setsqlarr['lastrun']=time();
	updatetable(table('crons'), $setsqlarr," cronid ='".intval($crons['cronid'])."'");
?>