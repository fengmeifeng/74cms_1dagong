<?php /* Smarty version 2.6.18, created on 2015-08-22 10:18:27
         compiled from index/zhqy.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'index/zhqy.tpl', 72, false),array('modifier', 'date_format', 'index/zhqy.tpl', 75, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<?php echo $this->_tpl_vars['public']; ?>
/css/common.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->_tpl_vars['public']; ?>
/css/zhqy.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['public']; ?>
/js/jquery.js"></script>
<title>查看参会企业</title>
</head>
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
  });
</script>
<body style="background-color:#E0F0FE; width:120%;">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 查看 <?php echo $this->_tpl_vars['jobfair_text']; ?>
 预定名单</div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>查看: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['app']; ?>
/excel/zhqy/zhid/<?php echo $this->_tpl_vars['zid']; ?>
">生成Excel</a></h2>
</div>

<input type="button" value="添加" class="tj admin_submit">&nbsp;&nbsp;
| &nbsp;&nbsp;
<form action="<?php echo $this->_tpl_vars['url']; ?>
/selssqy" method="post" style="display:inline-block;">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['zid']; ?>
" />
<input type="text" name="name" >
<input type="submit" value="查找" >
</form>
<hr />
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="list" class="link_bk" >
  <tr>
  <th scope="col" class="admin_list_tit" width="130" align="left" style="padding-left:5px;"><input type="checkbox" />企业用户名</th>
  <th scope="col" class="admin_list_tit" width="220" align="left">企业公司名</th>
    <th scope="col" class="admin_list_tit" width="60" align="center">销售代表</th>
	<th scope="col" class="admin_list_tit" width="60" align="center">地区</th>
  <th scope="col" class="admin_list_tit" width="80" align="center">企业电话</th>
  <th scope="col" class="admin_list_tit" width="150" align="center">企业邮箱</th>
  <th scope="col" class="admin_list_tit" width="50" align="center">展位号</th>
  <th scope="col" class="admin_list_tit" width="80" align="center">会员类型</th>
	<th scope="col" class="admin_list_tit" width="65" align="center">套餐类型</th>
	<th scope="col" class="admin_list_tit" width="65" align="center">预定方式</th>
	<th scope="col" class="admin_list_tit" width="120" align="center">预定时间</th>
	<th scope="col" class="admin_list_tit" width="120" align="center">操作</th>
  <th scope="col" class="admin_list_tit" align="center">备注</th>
  </tr>
<?php unset($this->_sections['ls']);
$this->_sections['ls']['loop'] = is_array($_loop=$this->_tpl_vars['data']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ls']['name'] = 'ls';
$this->_sections['ls']['show'] = true;
$this->_sections['ls']['max'] = $this->_sections['ls']['loop'];
$this->_sections['ls']['step'] = 1;
$this->_sections['ls']['start'] = $this->_sections['ls']['step'] > 0 ? 0 : $this->_sections['ls']['loop']-1;
if ($this->_sections['ls']['show']) {
    $this->_sections['ls']['total'] = $this->_sections['ls']['loop'];
    if ($this->_sections['ls']['total'] == 0)
        $this->_sections['ls']['show'] = false;
} else
    $this->_sections['ls']['total'] = 0;
if ($this->_sections['ls']['show']):

            for ($this->_sections['ls']['index'] = $this->_sections['ls']['start'], $this->_sections['ls']['iteration'] = 1;
                 $this->_sections['ls']['iteration'] <= $this->_sections['ls']['total'];
                 $this->_sections['ls']['index'] += $this->_sections['ls']['step'], $this->_sections['ls']['iteration']++):
$this->_sections['ls']['rownum'] = $this->_sections['ls']['iteration'];
$this->_sections['ls']['index_prev'] = $this->_sections['ls']['index'] - $this->_sections['ls']['step'];
$this->_sections['ls']['index_next'] = $this->_sections['ls']['index'] + $this->_sections['ls']['step'];
$this->_sections['ls']['first']      = ($this->_sections['ls']['iteration'] == 1);
$this->_sections['ls']['last']       = ($this->_sections['ls']['iteration'] == $this->_sections['ls']['total']);
?>
  <tr class="tab">
    <td class="admin_list" align="left" style="padding-left:5px;"><input type="checkbox" name="id[]" value='<?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['username']; ?>
</td>
    <td class="admin_list"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['title']; ?>
</td>
	<td class="admin_list" align="center"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['xs_user']; ?>
</td>
	<td class="admin_list" align="center"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['dq']; ?>
</td>
    <td class="admin_list" align="center"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['phone']; ?>
</td>
    <td class="admin_list" align="center"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['email']; ?>
</td>
    <td class="admin_list" align="center"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['number']; ?>
</td>
	<td class="admin_list" align="center"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data'][$this->_sections['ls']['index']]['huiyuan'])) ? $this->_run_mod_handler('replace', true, $_tmp, '0', "正式会员") : smarty_modifier_replace($_tmp, '0', "正式会员")))) ? $this->_run_mod_handler('replace', true, $_tmp, '2', "免费体验") : smarty_modifier_replace($_tmp, '2', "免费体验")))) ? $this->_run_mod_handler('replace', true, $_tmp, '3', "橱窗赠送") : smarty_modifier_replace($_tmp, '3', "橱窗赠送")))) ? $this->_run_mod_handler('replace', true, $_tmp, '4', "苏州用户") : smarty_modifier_replace($_tmp, '4', "苏州用户")); ?>
</td>
	<td class="admin_list" align="center"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data'][$this->_sections['ls']['index']]['yhtype'])) ? $this->_run_mod_handler('replace', true, $_tmp, '1', "套餐用户") : smarty_modifier_replace($_tmp, '1', "套餐用户")))) ? $this->_run_mod_handler('replace', true, $_tmp, '2', "积分用户") : smarty_modifier_replace($_tmp, '2', "积分用户")))) ? $this->_run_mod_handler('replace', true, $_tmp, '3', "临时用户") : smarty_modifier_replace($_tmp, '3', "临时用户")))) ? $this->_run_mod_handler('replace', true, $_tmp, '4', "无") : smarty_modifier_replace($_tmp, '4', "无")); ?>
</td>
	<td class="admin_list" align="center"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data'][$this->_sections['ls']['index']]['online_aoto'])) ? $this->_run_mod_handler('replace', true, $_tmp, '1', "自动预定") : smarty_modifier_replace($_tmp, '1', "自动预定")))) ? $this->_run_mod_handler('replace', true, $_tmp, '2', "在线预定") : smarty_modifier_replace($_tmp, '2', "在线预定")))) ? $this->_run_mod_handler('replace', true, $_tmp, '3', "手动添加") : smarty_modifier_replace($_tmp, '3', "手动添加")))) ? $this->_run_mod_handler('replace', true, $_tmp, '4', "无") : smarty_modifier_replace($_tmp, '4', "无")); ?>
</td>
	<td class="admin_list" align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['data'][$this->_sections['ls']['index']]['add_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</td>
	<td class="admin_list" align="center"><a href="<?php echo $this->_tpl_vars['url']; ?>
/gzw/id/<?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['id']; ?>
">更改展位</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['url']; ?>
/gdel/id/<?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['id']; ?>
/zhid/<?php echo $this->_tpl_vars['zid']; ?>
" onclick="return confirm('你确定要删除吗？')">删除</a></div>
  <td class="admin_list" align="left"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['text']; ?>
</td>
  </tr>
<?php endfor; else: ?>
   <tr>
     <td colspan="9">暂时没有找到用户!</td>
   </tr>
<?php endif; ?>

<tr>
  <td colspan="10" class="admin_list"><?php echo $this->_tpl_vars['fpage']; ?>
</td>
<tr>

</table>

</div>

<script type="text/javascript">
  $(function(){
      $(".tj").click(function(){
          $(".box").show();
      })
      //--------------------------------------------
      $(".yd").click(function(){
          var a=$(this).text();
          $("#number").val(a);
          $(".yd").css("color","#000");
          $(this).css("color","red");
      });
      //--------------------------------------------
      $(".ydl").click(function(){
          alert("这个展位被预定了 （＞﹏＜）");
      })
      //--------------------------------------------
      $(".sub").click(function(){
          var url=$(this).attr("url");
          var number=$("#number").val(),
              zid=$("input[name=zid]").val(),
              yhtype=$("input[name=yhtype]").val(),
              online_aoto=$("input[name=online_aoto]").val(),
              title=$("input[name=title]").val(),
              subsite_id=$("input[name=subsite_id]").val(),
              qq=$("input[name=qq]").val(),
              phone=$("input[name=phone]").val(),
              email=$("input[name=email]").val(),
			  xs_user=$("input[name=xs_user]").val(),
              text=$("textarea[name=text]").val();
			  //验证是否是否输入-------------------------
			  if(number==""){
					alert("展位号必须选择！才可以预定！");
			  }else if(title==""){
					alert("企业公司名必须选择！才可以预定！");
			  }else{
			  //--------------------------
				  $.post(url, { number:number,zid:zid,yhtype:yhtype,online_aoto:online_aoto,title:title,subsite_id:subsite_id,qq:qq,phone:phone,email:email,text:text,xs_user:xs_user },
				  function(data){
					  alert(data);
					  window.location.reload(); 
				  });
			  }
      })
  });
  //--------------------
  function gb(){
     $(".box").hide();
  };

</script>
<!--***************************************-->
<div class="box">
    <div class="ock" onclick="gb();"> </div>
    <div class="nr">

      <div class="myd">
        <p style="text-align: center; padding-bottom: 10px;">没有被预订的展位 o(∩_∩)o </p>
        <!--没有预定的展位-->
        <?php unset($this->_sections['ls']);
$this->_sections['ls']['loop'] = is_array($_loop=$this->_tpl_vars['all']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ls']['name'] = 'ls';
$this->_sections['ls']['show'] = true;
$this->_sections['ls']['max'] = $this->_sections['ls']['loop'];
$this->_sections['ls']['step'] = 1;
$this->_sections['ls']['start'] = $this->_sections['ls']['step'] > 0 ? 0 : $this->_sections['ls']['loop']-1;
if ($this->_sections['ls']['show']) {
    $this->_sections['ls']['total'] = $this->_sections['ls']['loop'];
    if ($this->_sections['ls']['total'] == 0)
        $this->_sections['ls']['show'] = false;
} else
    $this->_sections['ls']['total'] = 0;
if ($this->_sections['ls']['show']):

            for ($this->_sections['ls']['index'] = $this->_sections['ls']['start'], $this->_sections['ls']['iteration'] = 1;
                 $this->_sections['ls']['iteration'] <= $this->_sections['ls']['total'];
                 $this->_sections['ls']['index'] += $this->_sections['ls']['step'], $this->_sections['ls']['iteration']++):
$this->_sections['ls']['rownum'] = $this->_sections['ls']['iteration'];
$this->_sections['ls']['index_prev'] = $this->_sections['ls']['index'] - $this->_sections['ls']['step'];
$this->_sections['ls']['index_next'] = $this->_sections['ls']['index'] + $this->_sections['ls']['step'];
$this->_sections['ls']['first']      = ($this->_sections['ls']['iteration'] == 1);
$this->_sections['ls']['last']       = ($this->_sections['ls']['iteration'] == $this->_sections['ls']['total']);
?>
        <div class="z yd" title="这个展位还没被预定。"><span class="yc"> <?php echo $this->_tpl_vars['all'][$this->_sections['ls']['index']]['number']; ?>
 </span></div>
        <?php endfor; endif; ?>
      </div>
      <div class="yyd">
        <p style="text-align: center; padding-bottom: 10px;">已经被预订的展位 (╯＾╰) </p>
        <!--预定过的展位-->
        <?php unset($this->_sections['ls']);
$this->_sections['ls']['loop'] = is_array($_loop=$this->_tpl_vars['ok']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ls']['name'] = 'ls';
$this->_sections['ls']['show'] = true;
$this->_sections['ls']['max'] = $this->_sections['ls']['loop'];
$this->_sections['ls']['step'] = 1;
$this->_sections['ls']['start'] = $this->_sections['ls']['step'] > 0 ? 0 : $this->_sections['ls']['loop']-1;
if ($this->_sections['ls']['show']) {
    $this->_sections['ls']['total'] = $this->_sections['ls']['loop'];
    if ($this->_sections['ls']['total'] == 0)
        $this->_sections['ls']['show'] = false;
} else
    $this->_sections['ls']['total'] = 0;
if ($this->_sections['ls']['show']):

            for ($this->_sections['ls']['index'] = $this->_sections['ls']['start'], $this->_sections['ls']['iteration'] = 1;
                 $this->_sections['ls']['iteration'] <= $this->_sections['ls']['total'];
                 $this->_sections['ls']['index'] += $this->_sections['ls']['step'], $this->_sections['ls']['iteration']++):
$this->_sections['ls']['rownum'] = $this->_sections['ls']['iteration'];
$this->_sections['ls']['index_prev'] = $this->_sections['ls']['index'] - $this->_sections['ls']['step'];
$this->_sections['ls']['index_next'] = $this->_sections['ls']['index'] + $this->_sections['ls']['step'];
$this->_sections['ls']['first']      = ($this->_sections['ls']['iteration'] == 1);
$this->_sections['ls']['last']       = ($this->_sections['ls']['iteration'] == $this->_sections['ls']['total']);
?>
        <div class="z ydl" title="这个展位被<?php echo $this->_tpl_vars['ok'][$this->_sections['ls']['index']]['title']; ?>
预定了，请下次再来把!"><span class="yc"><?php echo $this->_tpl_vars['ok'][$this->_sections['ls']['index']]['number']; ?>
</span></div>
        <?php endfor; endif; ?>
      </div>
    <!--**********************-->
  <input type="hidden" name="number" id="number" value="" />
  <input type="hidden" name="zid" value="<?php echo $this->_tpl_vars['zid']; ?>
" />
  <input type="hidden" name="yhtype" value="3" />
  <input type="hidden" name="online_aoto" value="3" />
  <div style="float:none;"></div>
  <table width="100%" border="0" cellpadding="3" cellspacing="3"  class="admin_table" style="float:left; margin-top: 10px; ">
  <tr>
    <th scope="row" align="right" width="100">企业公司名：&nbsp;</th>
    <td width="240">&nbsp;<input type="text" name="title" size="40" value="" /></td>
    <td rowspan="5">
      <span style="font-size: 12px; font-weight: bolder;">备注：</span><br/>
      <textarea rows="8" cols="33" name="text"></textarea>
    </td>
  </tr>
  <tr>
    <th scope="row" align="right">地区：</th>
    <td><?php echo $this->_tpl_vars['dq']; ?>
</td>
  <input type="hidden" name="subsite_id" value="<?php echo $this->_tpl_vars['dqid']; ?>
" />
  </tr>
  <tr>
    <th scope="row" align="right">企业qq：&nbsp;</th>
    <td>&nbsp;<input type="text" name="qq" size="40" value="" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业电话：&nbsp;</th>
    <td>&nbsp;<input type="text" name="phone" size="40" value="" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业邮箱：&nbsp;</th>
    <td>&nbsp;<input type="text" name="email" size="40" value="" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">销售代表：&nbsp;</th>
    <td>&nbsp;<input type="text" name="xs_user" size="40" value="" /></td>
  </tr>
</table>
<input type="button" value="添加" class="admin_submit sub" url="<?php echo $this->_tpl_vars['url']; ?>
/jinji">
    </div>
</div>
<!--***************************************-->
<!--底栏-->
<div class="footer link_lan">
Powered by <a href="http://www.74cms.com" target="_blank"><span style="color:#009900">74</span><span style="color: #FF3300">CMS</span></a> 3.3.20130614
</div>
<div class="admin_frameset" >
  <div class="open_frame" title="全屏" id="open_frame"></div>
  <div class="close_frame" title="还原窗口" id="close_frame"></div>
</div>
</body>
</html>