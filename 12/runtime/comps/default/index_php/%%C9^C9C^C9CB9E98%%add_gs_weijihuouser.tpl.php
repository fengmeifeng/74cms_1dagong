<?php /* Smarty version 2.6.18, created on 2014-09-20 14:35:46
         compiled from add_gs_user/add_gs_weijihuouser.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'add_gs_user/add_gs_weijihuouser.tpl', 119, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['res']; ?>
/js/WdatePicker/WdatePicker.js"></script>
<script type="text/javascript">
	$(function(){
	
		//隔行换色
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
		
		//鼠标移上换色
		$(".tab").hover(
		  function(){
		    $(this).css("background","#CFDDEA");
		  },
		  function(){
		    $(".tab:even").css("background","#FFFFFF");
			$(".tab:odd").css("background","#F8F8F8");
		});
		
		//checkbox,全选/全不选
		$(".ckbox").bind("click", function(){ 
			if($(".ckbox:checkbox").attr("checked")){
				$("[name = selectid[]]:checkbox").attr("checked", true);
			}else{
				$("[name = selectid[]]:checkbox").attr("checked", false);
			}
        });
		
	});
//离职----
	function statusl(a,b){
		if(b=='lz'){
			$(".mz").html("离职时间");
			$("input[id='shijian']").attr("name","lizhi_time");
			$("#formshijian").attr("action","<?php echo $this->_tpl_vars['app']; ?>
/user/lizhi");
		}
		$(".statusxianshil"+a).css("display","");
		$("body").append("<div class='zhezhao' onclick='gb()'> </div>");
	}
	
	//入职----
	function statusr(a,b){
		if(b=='rz'){
			$(".mz").html("入职时间");
			$("input[id='shijian']").attr("name","ruzhi_time");
		}
		$(".statusxianshir"+a).css("display","");
		$("body").append("<div class='zhezhao' onclick='gb()'> </div>");
	}
	//关闭弹出框---
	function gb(){
		$(".status").css("display","none");
		$(".zhezhao").remove();
	}
	
</script>


<body class="bodycolor">

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="21" class="biaoti" align="left">&nbsp;未激活会员列表</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<?php echo $this->_tpl_vars['url']; ?>
/add_gs_weijihuouser" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="name">姓名</option>
				<option value="bianhao">编号</option>
				<option value="sphone">手机号</option>
				<option value="id_number">身份证号</option>
				<option value="ruzhi_name">入职企业</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			
			<select name="shijianduan" class="SmallSelect">
				<option value="">选择时间段</option>
				<option value="add_time">添加时间</option>
				<option value="ruzhi_time">入职时间</option>
			</select>
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap width="40">伯乐</td>
	<td noWrap width="75">编号</td>
	<td noWrap width="70">姓名</td>
	<td noWrap width="70">推荐人编号</td>
	<td noWrap width="70">推荐人姓名</td>
	<td noWrap width="60">关系</td>
	<td noWrap width="100">手机号码</td>
	<td noWrap width="90">QQ号码</td>
	<td noWrap width="75">会员类型</td>
    <td nowrap width="130">注册时间</td>
	<td nowrap width="90">入职时间</td>
	<td nowrap width="60">入职天数</td>
	<td nowrap width="60">入职企业</td>
	<td nowrap width="60">添加地区</td>
    <td nowrap width="300">操作</td>
	<td nowrap>备注</td>
</tr>
<?php if ($this->_tpl_vars['data']): ?>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<tr class="khbox tab" >
	<td noWrap > <?php echo $this->_tpl_vars['item']['xiezhu']; ?>
 </td>
	<td noWrap  align='left'>&nbsp; <?php echo $this->_tpl_vars['item']['bianhao']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['name']; ?>
 </td>
	<td noWrap  align='left'> <?php if ($this->_tpl_vars['item']['f_bianghao'] != '0'): ?> <?php echo $this->_tpl_vars['item']['f_bianghao']; ?>
 <?php endif; ?> </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['f_name']; ?>
 </td>
	<td noWrap  align='center'> <?php echo $this->_tpl_vars['item']['guanxi']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['sphone']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['qq']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['jibie']; ?>
 </td>
	<td noWrap  align='left'> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['add_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
 </td>
	<td noWrap  align='center'> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['ruzhi_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
 </td>
	<td noWrap  align='center'> <?php echo $this->_tpl_vars['item']['ts']; ?>
天 </td>
	<td noWrap  align='center'> <?php echo $this->_tpl_vars['item']['ruzhi_name']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['add_gs']; ?>
 </td>
    <td> <?php if ($this->_tpl_vars['priv'] == '1' && $this->_tpl_vars['priv'] == '4'): ?> <a href="javascript:alert('没有权限!')"> 激活会员 </a> <?php else: ?><a onclick="return confirm('你确定要激活吗? ')" href="<?php echo $this->_tpl_vars['app']; ?>
/user/jihuohuiyuan/id/<?php echo $this->_tpl_vars['item']['id']; ?>
"> 激活会员</a><?php endif; ?> <a href="<?php echo $this->_tpl_vars['app']; ?>
/user/huiyuaninfo/id/<?php echo $this->_tpl_vars['item']['id']; ?>
/dqurl/weijihuouser">查资料</a>  <?php if ($this->_tpl_vars['item']['status'] == '1'): ?>
		 <a href="javascript:;" onclick="statusl(<?php echo $this->_tpl_vars['item']['id']; ?>
,'lz')"> 离职 </a> 
		 <?php elseif ($this->_tpl_vars['item']['status'] == '2'): ?>
		 <a href="javascript:;" onclick="statusr(<?php echo $this->_tpl_vars['item']['id']; ?>
,'rz')"> 入职 </a> 
		 <?php endif; ?>
		 
		 <div class="status statusxianshil<?php echo $this->_tpl_vars['item']['id']; ?>
" style='display:none;margin: 4px -25px;'>  
			<div class="content"> 
				<form method="post" action="<?php echo $this->_tpl_vars['app']; ?>
/user/lizhi" id="formshijian">
					<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['item']['id']; ?>
" />
					<span class="mz"></span>：<input type="text" id="shijian" size="8" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})" />
					<input type="submit" value="提交"/>
				</form> </div><s style="left: 162px"><i></i></s> 
		 </div>
		 
		<div class="status statusxianshir<?php echo $this->_tpl_vars['item']['id']; ?>
" style='display:none;margin: 4px -25px;'>  
			<div class="content" style="height:60px;line-height:25px; padding-top:15px;"> 
				<form method="post" action="<?php echo $this->_tpl_vars['app']; ?>
/user/ruzhihuiyuan" id="formshijian">
					<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['item']['id']; ?>
" />
					<span>入职公司</span>：<input type="text" id="ruzhi_name" name="ruzhi_name" size="13" /> <br/>
					<span class="mz"></span>：<input type="text" id="shijian" size="8" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})" />
					<input type="submit" value="提交"/>
				</form> </div><s style="left: 162px"><i></i></s> 
		</div> </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['beizu']; ?>
 </td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<tr>
    	<td colspan="21">
        	没有找到要激活的会员
        </td>
    </tr>
<?php endif; ?>
<tr class="biaoti">
	<td align="left" colspan="21">
		<?php echo $this->_tpl_vars['fpage_weihu']; ?>

	</td>
</tr>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>