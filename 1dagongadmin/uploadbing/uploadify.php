<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
require_once(dirname(__FILE__).'/../config.php');
include("fileupload.class.php");
include("image.php");

if(!empty($_POST)){
	if($_POST['sc']=="s"){
		
		$wjm=date('y').date('m').date('d');
		$up = new FileUpload(); //可以通过参数指定上传位置，可通过set()方法	
		$up->set('path',   '../../file/images/'.$wjm.'/')			//设置图片路径
			->set("maxSize", 2000000)								//图片大小限制2m
			->set("allowType", array('gif', 'jpg', 'png'))			//现在图片上传格式
			->set("thumb", array("width"=>600,"height"=>500));		//规定图片上传比例
			//->set("watermark", array("water"=>"../../logo.png", "position"=>9));		//设置图片水印路径。
			
		if($up->upload("Filedata")){  //pic为上传表单的名称
			$tp="/file/images/".$wjm.'/'.$up->getFileName();  //返回上传后的图片文件名
			$stp="/file/images/".$wjm.'/th_'.$up->getFileName();  //返回上传后的缩略图文件名
			
			if(!empty($_POST)){
				if($_POST['uid']!="" and $_POST['sort']!=""){
					//图片缩放类
					$image=new Imagesize("../../file/images/".$wjm."/");
					//对图片进行缩放
					$a=$image->thumb($up->getFileName(), 120, 90, "th_");
					if($a){
						//插入数据库
						$sql="INSERT INTO `zjobs_gongzuoimg` (`id`, `ifcheck`, `uid`, `sort`, `imgtitle`, `imgurl`,`simgurl`, `addtime`) VALUES (NULL, '0', '".$_POST['uid']."', '".$_POST['sort']."', '".$up->getFileName()."', '".$tp."', '".$stp."', '".time()."')";
						$dsql->ExecuteNoneQuery($sql);
						$fid = $dsql->GetLastID();
						if($fid >= 1){
							echo $tp."|".$fid;
						}else{
							//删除图片
							if(file_exists(dirname(__FILE__)."/../../".$tp)){
								echo unlink(dirname(__FILE__)."/../../".$tp) ? '' : '0';
							}
							//删除缩略图
							if(file_exists(dirname(__FILE__)."/../../".$stp)){
								echo unlink(dirname(__FILE__)."/../../".$stp) ? '' : '0';
							}
						}
					}else{
						//删除图片
						if(file_exists(dirname(__FILE__)."/../../".$tp)){
							echo unlink(dirname(__FILE__)."/../../".$tp) ? '' : '0';
						}
						//删除缩略图
						if(file_exists(dirname(__FILE__)."/../../".$stp)){
							echo unlink(dirname(__FILE__)."/../../".$stp) ? '' : '0';
						}
					}
				}else{
					//删除图片
					if(file_exists(dirname(__FILE__)."/../../".$tp)){
						echo unlink(dirname(__FILE__)."/../../".$tp) ? '' : '0';
					}
					//删除缩略图
					if(file_exists(dirname(__FILE__)."/../../".$stp)){
						echo unlink(dirname(__FILE__)."/../../".$stp) ? '' : '0';
					}
				}
			}else{
				echo "出现错误！";
			}
		}else{ 
			//如果上传失败提示出错原因
			echo $up->getErrorMsg();
		}
		
	//更行图片的标题
	}elseif($_POST['gx']=="g"){
		$sql="UPDATE `zjobs_gongzuoimg` SET `imgtitle` = '".$_POST['title']."' WHERE  `zjobs_gongzuoimg`.`id` ='".$_POST['id']."'";
		$rs = $dsql->ExecuteNoneQuery2($sql);
		if($rs >= 1){
			echo "1";
		}else{
			echo "0";
		}
	//删除图片	
	}elseif($_POST['del']=="d"){
		$sql="select imgurl,simgurl from `zjobs_gongzuoimg` where id='".$_POST['id']."'";
		$arr = $db->GetOne($sql);
		$tp=$arr['imgurl'];
		$stp=$arr['simgurl'];
		if(file_exists(dirname(__FILE__)."/../../".$tp) || file_exists(dirname(__FILE__)."/../../".$stp)){
			$dx=unlink(dirname(__FILE__)."/../../".$tp) ? '1' : '0';
			$dx=unlink(dirname(__FILE__)."/../../".$stp) ? '1' : '0';
		}else{
			$dx='2';
		}		
		if($dx=="1"){
			$del="delete from `zjobs_gongzuoimg` where id='".$_POST['id']."'";
			$rs = $dsql->ExecuteNoneQuery2($del);
			if($rs >= 1){
				echo "1";
			}else{
				echo "0";
			}
		}elseif($dx=="0"){
			echo "删除图片失败";
		}elseif($dx=="2"){
			echo "没有找到图片";
		}else{
			echo "未知问题";
		}
	}elseif($_POST['tp']=="t"){
		if(!empty($_POST['sort'])){
			$sql="select id,imgtitle,imgurl from `zjobs_gongzuoimg` where uid='".$_POST['id']."' and sort='".$_POST['sort']."'";
		}else{
			$sql="select id,imgtitle,imgurl from `zjobs_gongzuoimg` where uid='".$_POST['id']."'";
		}
		$db->SetQuery($sql);  
		$db->Execute();
		$data=array();
		while($arr = $db->GetArray()){  
			$data[]=$arr;
		} 
		if(!empty($data)){
			$a=json_encode($data);
			if(!empty($a)){
				echo $a;
			}else{
				echo "0";	
			}
		}else{
			echo "0";
		}
	}elseif($_POST['tp']=="qt"){
		$sql="select id,uid,imgtitle,imgurl from `zjobs_gongzuoimg` where uid='".$_POST['id']."' and sort='".$_POST['uid']."'";
		$db->SetQuery($sql);  
		$db->Execute();
		$data=array();
		while($arr = $db->GetArray()){  
			$data[]=$arr;
		}
		if(!empty($data)){
			$a=json_encode($data);
			if(!empty($a)){
				echo $a;
			}else{
				echo "0";	
			}
		}else{
			echo "0";
		}
	}else{
		echo "未知错误";
	}
}
?>