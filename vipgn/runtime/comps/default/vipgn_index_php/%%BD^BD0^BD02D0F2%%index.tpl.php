<?php /* Smarty version 2.6.18, created on 2015-08-22 10:18:16
         compiled from dzshuju/index.tpl */ ?>
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
<body style="background-color:#E0F0FE;">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
  <div class="ptit"> 查看的参会企业 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>查看: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if ($this->_tpl_vars['dq'] != ""): ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;地址：&nbsp;
<?php $_from = $this->_tpl_vars['dq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['l']):
?>  
<a href="<?php echo $this->_tpl_vars['url']; ?>
/index/id/0/dqid/<?php echo $this->_tpl_vars['l']['s_id']; ?>
"><?php echo $this->_tpl_vars['l']['s_districtname']; ?>
</a>&nbsp;&nbsp;
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
</h2>
</div>

<form action="<?php echo $this->_tpl_vars['url']; ?>
/index/id/<?php echo $this->_tpl_vars['dqid']; ?>
" method="post" style="display:inline-block;">
查找企业: <input type="text" name="name" >
<input type="hidden" name="dqid" value="<?php echo $this->_tpl_vars['dqid']; ?>
" />
<input type="submit" value="查找" >
</form>
<hr />
<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0" id="list" class="link_bk" >
  <tr>
  <th scope="col" class="admin_list_tit" width="220" align="left" style="padding-left:10px;"><input type="checkbox" />企业用户名</th>
  <th scope="col" class="admin_list_tit" width="320" align="left">企业公司名</th>
  <th scope="col" class="admin_list_tit" width="80" align="left">销售代表</th>
  <th scope="col" class="admin_list_tit" width="80" align="center">地区</th>
  <th scope="col" class="admin_list_tit" width="80" align="center">企业qq</th>
  <th scope="col" class="admin_list_tit" width="120" align="center">企业电话</th>
  <th scope="col" class="admin_list_tit" width="180" align="center">企业邮箱</th>
  <th scope="col" class="admin_list_tit" width="100" align="center">操作</th>
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
  <td class="admin_list" align="left" style="padding-left:10px;"><input type="checkbox" name="id[]" value='<?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['username']; ?>
</td>
  <td class="admin_list"><a href="<?php echo $this->_tpl_vars['url']; ?>
/ckdz/id/<?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['qid']; ?>
"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['title']; ?>
</a></td>
  <td class="admin_list"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['xs_user']; ?>
</td>
  <td class="admin_list" align="center"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['dq']; ?>
</td>
  <td class="admin_list" align="center"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['qq']; ?>
</td>
  <td class="admin_list" align="center"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['phone']; ?>
</td>
  <td class="admin_list" align="center"><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['email']; ?>
</td>
  <td class="admin_list" align="center"><a href="<?php echo $this->_tpl_vars['url']; ?>
/ckdz/id/<?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['qid']; ?>
">查看</a></td>
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
</body>
</html>