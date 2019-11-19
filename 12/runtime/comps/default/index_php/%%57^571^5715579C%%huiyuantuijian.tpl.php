<?php /* Smarty version 2.6.18, created on 2014-09-01 17:33:27
         compiled from user/huiyuantuijian.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'user/huiyuantuijian.tpl', 72, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

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
		
		$("#yin").toggle(
		  function (){
			$("#yin").attr("src","/public/images/1.gif");
			$(".xiaxian").css("display","");
			
		  },
		  function (){
			$("#yin").attr("src","/public/images/2.gif");
			$(".xiaxian").css("display","none");
		  }
		);
	
	});
</script>

<body class="bodycolor">

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="21" class="biaoti" align="left"><span style="float:left;">&nbsp;<font color="green"> <?php echo $this->_tpl_vars['user']['bianhao']; ?>
[<?php echo $this->_tpl_vars['user']['name']; ?>
] </font> 的推荐列表</span><img id='yin' style="float:left;" src="/public/images/2.gif" alt="显示" />(是否显示下线的下线) 将获得所有下线的奖金之和《<font color="red"><?php echo $this->_tpl_vars['user']['jiangjin']; ?>
元</font>》</td>
</tr>

<tr class="biaoti">
	<td noWrap>编号</td>
	<td noWrap width="120">姓名</td>
	<td noWrap width="85">推荐人编号</td>
	<td noWrap width="70">推荐人关系</td>
	<td noWrap width="102">获得下线的奖金</td>
	<td noWrap width="58">推荐人数</td>
    <td nowrap width="135">激活时间</td>
    <td nowrap width="135">添加时间</td>
    <td nowrap width="40">状态</td>
    <td nowrap width="60">操作</td>
</tr>
<?php if ($this->_tpl_vars['data']): ?>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<tr class="khbox tab" id="dengji<?php echo $this->_tpl_vars['item']['id']; ?>
" >
	<td noWrap  align='left'> <font color="#3388CE"><?php echo $this->_tpl_vars['item']['kg']; ?>
</font><?php echo $this->_tpl_vars['item']['bianhao']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['name']; ?>
 </td>
	<td noWrap  align='left'> <?php if ($this->_tpl_vars['item']['f_bianghao'] != '0'): ?> <b style="color:#565656;"><?php echo $this->_tpl_vars['item']['f_bianghao']; ?>
</b> <?php endif; ?> </td>
	<td noWrap  align='center'> <?php echo $this->_tpl_vars['item']['guanxi']; ?>
 </td>
	<td noWrap  align='right'> <?php echo $this->_tpl_vars['item']['q']; ?>
元 </td>
	<td noWrap  align='right'> <?php echo $this->_tpl_vars['item']['tj_num']; ?>
人 </td>
	<td noWrap  align='left'> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['jihuo_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
 </td>
	<td noWrap  align='left'> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['add_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
 </td>
	<td noWrap  align='left'> <?php if ($this->_tpl_vars['item']['status'] == '1'): ?> <font color="green">在职</font> <?php elseif ($this->_tpl_vars['item']['status'] == '2'): ?> <font color="red">已离职</font> <?php else: ?> 无 <?php endif; ?> </td>
    <td> 
		<?php if ($this->_tpl_vars['item']['add_gs'] != '' && $this->_tpl_vars['item']['add_gs'] != $this->_tpl_vars['gdd_user'] && $this->_tpl_vars['gdd_user'] != 'admin'): ?>
			<a href="javascript:;" onclick="alert('没有权限！')" >无法操作</a>
		<?php else: ?>
			<a href="<?php echo $this->_tpl_vars['url']; ?>
/huiyuaninfo/id/<?php echo $this->_tpl_vars['item']['id']; ?>
">查资料</a> 
		<?php endif; ?>
	</td>
</tr>
<script type="text/javascript">
	var m=<?php echo $this->_tpl_vars['item']['m']; ?>
;
	if(m > 1){
		$("#dengji<?php echo $this->_tpl_vars['item']['id']; ?>
").css("display","none");
		$("#dengji<?php echo $this->_tpl_vars['item']['id']; ?>
").attr("class","khbox tab xiaxian");
	}
</script> 
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<tr>
    	<td colspan="14">
        	没有推荐任何人
        </td>
    </tr>
<?php endif; ?>
<tr class="biaoti">
	<td align="left" colspan="20">
		<?php echo $this->_tpl_vars['fpage_weihu']; ?>

	</td>
</tr>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>