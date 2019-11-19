<?php require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.qishi_url.php'); $this->register_modifier("qishi_url", "tpl_modifier_qishi_url",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_jobfair_list.php'); $this->register_function("qishi_jobfair_list", "tpl_function_qishi_jobfair_list",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.default.php'); $this->register_modifier("default", "tpl_modifier_default",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-09-28 14:59 中国标准时间 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <meta name="robots" content="noodp,noydir" />
    <meta http-equiv="Content-Language" content="zh-CN" />
    <title><?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
最新招聘会|<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
2015招聘会|<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
人才市场招聘会信息 - <?php echo $this->_vars['QISHI']['site_name']; ?>
</title>
	<meta name="keywords" content="<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
招聘，<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
招聘会，<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
现场招聘会，2015<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
招聘会" />
	<meta name="description" content="<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
现场招聘会为您提供最新<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
招聘,以及上海,江苏,安徽,等地人才市场招聘会信息，2015<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
招聘会时间、地点等信息,为企业招聘和求职者找工作提供免费招聘信息。" />
	<meta http-equiv="X-UA-Compatible" content="IE=7">
	<meta name="author" content="壹打工网" />
	<link href="/files/css/all_02.css" rel="stylesheet" type="text/css" />
	<!-- //会员登录 -->
	<link rel="stylesheet" type="text/css" href="/files/zhaopin/zp_index.css" />
<link href="../files/css/font-awesome.min.css" rel="stylesheet" >
<!--	<script language="javascript" type="text/javascript" src="/files/js/jquery-1.2.6.min.js"></script>-->

<!---->
<link href="/files/css/all.css" rel="stylesheet" type="text/css" />
<link href="/files/css/company.css" rel="stylesheet" type="text/css" />
<script src="/files/js/jquery.js" type="text/javascript" language="javascript"></script>
<link rel="stylesheet" type="text/css" href="/files/css/common.css" />
<!---->


<!--<script type="text/javascript"> //二维码弹窗特效
	$(function(){
		$('.yyue_button').click(function() {
		alert("1111zwl");
			$.get("../ewm.php", {"id":"1085"}, function(data) {
			alert(data+"zwl");
				$('#imgUrl').attr('src', data);
			});
		});
	});
	$(function(){
		$(".yyue_button").click(function(){
			$(this).parent(".yd").siblings(".QRcode").show();
		});
		$(".yyue_close").click(function(){
			$(this).parents(".QRcode").hide();
		});
	});
</script>-->
	
<body>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>


<div class="centertop">
		
	</div>

<div class="centercon">

	<?php if ($this->_vars['subsite_id'] == 0): ?>


		<div id="zparea">
		  <div id="side">可预订寅特尼人才市场招聘会的地区：</div>
		  <div id="side1">
			<a class="tooltips" href="#">2015招聘会须知

					<span>
						<P>　　<strong>2015招聘会须知</strong></P>
						<P>　　<strong>求职者须知：</strong></P>
						<P>　　1、求职者均可免费进入招聘会现场找工作；</P>
						<P>　　2、求职者必须诚实守信，面试时应提供真实的个人简历并准备身份证、学历证书、资格证书、技术证书等证明材料；</P>
						<P>　　3、人才市场内张榜招聘和现场招聘的单位均经过人才市场严格审核，应聘者可电话联系或到现场直接洽谈。任何未经资格审核的单位不得在人才市场内招聘，避免应聘者上当受骗。</P>
						<P>　　<strong>招聘企业须知：</strong></P>
						<P>　　1、凡在人才市场内现场招聘的单位均须按要求提供所需材料，经资格审核办理报名手续后方可进场招聘；</P>
						<P>　　2、为遵守诚信原则，招聘单位不得发布虚假招聘信息；不得拒收与已发布招聘信息适应的应聘人员的求职资料；</P>
						<P>　　3、企业招聘人才，不得以任何形式向求职者收取报名费、招聘费、培训费、保证金等任何费用，不得扣押求职者的身份证、学历证明等证件；</P>
						<P>　　4、为维护求职者的个人权益及信息安全，企业必须妥善保管与使用求职者的相关资料，不得随意将求职者联系电话、住址等转告他人；</P>
						<P>　　5、招聘单位须在指定的展位开展工作，不得在展位外发放任何招聘宣传资料。</P>
					</span>

				</a>
			</div>
			<div id="main">
				<ul>
					<li><a href="?dqid=1" >安徽合肥</a></li>
					<li><a href="?dqid=5" >上海</a></li>
					<li><a href="?dqid=8" >苏州</a></li>
				</ul>

			</div>
		</div>

	<?php endif; ?>


	
	
	
	
	<div class="contents">
		<div class="titleh"><h3>最新招聘会</h3></div>
		<?php echo tpl_function_qishi_jobfair_list(array('set' => "列表名:jobfair,显示数目:10,标题长度:35,分页显示:1,标题长度:35,填补字符:..."), $this);?>
		<?php if (count((array)$this->_vars['jobfair'])): foreach ((array)$this->_vars['jobfair'] as $this->_vars['list']): ?> 				  
		<div class="jobfair">
			<div class="barleft">
				<p class="week"><?php echo $this->_run_modifier($this->_vars['list']['holddates'], 'date_format', 'plugin', 1, "%Y年%m月"); ?>
</p>
				<p class="date"><?php echo $this->_run_modifier($this->_vars['list']['holddates'], 'date_format', 'plugin', 1, "%d"); ?>
<span>日</span></p>
				<p class="wbottom"><?php echo $this->_vars['list']['holddates_week']; ?>
</p>
			</div>

			<div class="barright">
				<p <?php if ($this->_vars['list']['predetermined_ok'] == "1" && $this->_vars['list']['predetermined_web'] == "1"): ?> 
	class="yd"
	<?php else: ?>
	class="ydover"
<?php endif; ?>><?php if ($this->_vars['list']['predetermined_ok'] == "1" && $this->_vars['list']['predetermined_web'] == "1"): ?>
<a  title="求职预约" class="right yyue_button" id="<?php echo $this->_vars['list']['id']; ?>
"></a>
	<?php endif; ?>
<a <?php if ($this->_vars['list']['predetermined_ok'] == "1" && $this->_vars['list']['predetermined_web'] == "1"): ?> href="<?php echo $this->_run_modifier("QS_user,1", 'qishi_url', 'plugin', 1); ?>
company_jobfair.php?act=jobfair" title="请进入企业会员中心预定展位"<?php else: ?>title="已停止在线预定展位" href="javascript:void(null);" <?php endif; ?>></a>
<!--<a  title="个人预约" class="right yyue_button"></a>-->
</p>
			<div class="QRcode" style="display:none;" id="changeBox001"><!--这里是弹窗开始     href="../ewm.php?id=<?php echo $this->_vars['list']['id']; ?>
"-->
					<div class="QRcode_main"> 
						<h3><span class="weixin">微信</span>扫码即享个人预约服务</h3>   
						<img src="" class="changeImg" alt="" id="img001" />
					</div>
					<a class="yyue_close" title="关闭"></a>
					<div class="QRcode_zhe"></div>
				</div><!--这里是弹窗结束-->                
				<p class="xq"><a href="<?php echo $this->_vars['list']['url']; ?>
&dqid=<?php echo $this->_vars['dqid']; ?>
" target="_blank"></a></p>

			</div>

			<div class="jobfairlist">
				<dl>
					<dt><h2><a href="<?php echo $this->_vars['list']['url']; ?>
&dqid=<?php echo $this->_vars['dqid']; ?>
" target="_blank"><span style="color:#00f;font-weight:bold;"><?php echo $this->_vars['list']['title']; ?>
</span></a></h2></dt>
					<dd><span>行业主题：</span><?php echo $this->_vars['list']['industry']; ?>
</dd>
					<dd><span>会场地址：</span><?php echo $this->_vars['list']['address']; ?>
</dd>
					<dd><span>乘车线路：</span><?php echo $this->_vars['list']['bus']; ?>
</dd>
					<dd><span>举办日期：</span><?php echo $this->_run_modifier($this->_vars['list']['holddates'], 'date_format', 'plugin', 1, "%Y年%m月%d日"); ?>
</dd>
					<dd><span>报名电话：</span><?php echo $this->_vars['list']['phone']; ?>
</dd>
					<?php if ($this->_vars['list']['subsite_id'] != 8): ?>
					<dd><span>已&nbsp;预&nbsp;订：</span><?php echo $this->_vars['list']['yiyuding']; ?>
个展位<span style="margin-left:30px;">未预订：</span><?php echo $this->_vars['list']['weiyuding']; ?>
个展位</dd>
					<?php else: ?>
					<dd style="font-size:18px;"><span>已预订企业：</span><?php echo $this->_vars['list']['yiyuding']; ?>
个<span></dd>
					<?php endif; ?>
									</dl>

			</div>
		</div>
		<?php endforeach; endif; ?>		  
				  
				  
 
	
		  
		
		
		
		  


	</div>
	<table border="0" align="center" cellpadding="0" cellspacing="0" class="link_bk">
          <tr>
                        <td><?php if ($this->_vars['page']): ?><div class="page link_bk"><?php echo $this->_vars['page']; ?>
</div><?php endif; ?></td>
                    </tr>
      </table> 		
<script type="text/javascript">
					$(function(){
						$(".yyue_button").unbind().click(function() {
							$.get('../ewm.php', {"id":$(this).attr("id")}, function(data) {
								$("#img001").attr('src', data);//把返回的地址，添加到#changeImg图片src地址中
								$("#changeBox001").show();//显示二维码
							});	
						});
						$(".yyue_close").click(function(){
							$(this).parents(".QRcode").hide();
						});
					})
                	

</script>	
				
	
	
				
	
	
	
	
	
	
	
	
	
	
<script language="javascript">

function nTabs(thisObj,Num){
	if(thisObj.className == "active")return;
	var tabObj = thisObj.parentNode.id;
	var tabList = document.getElementById(tabObj).getElementsByTagName("li");
	for(i=0;i <tabList.length;i++){
		if (i == Num){
			thisObj.className = "t";
			document.getElementById(tabObj+"_Content"+i).style.display = "block";
		}
		else{
			tabList[i].className = "f";
			document.getElementById(tabObj+"_Content"+i).style.display = "none";
		}
	}
}
</script>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>




</body>
</html>