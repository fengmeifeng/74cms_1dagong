<?php /* Smarty version 2.6.18, created on 2014-04-17 15:30:11
         compiled from index/qiehuan.tpl */ ?>
<html>
<head>
<title>系统切换栏</title>
<meta http-equiv="Content-Type" content="text/html" charset="utf8">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['res']; ?>
/css/nemu.css">
<script type="text/javascript">
//--------------------- 状态初始 ----------------------
var MENU_SWITCH;
function panel_menu_open()
{
 MENU_SWITCH=0;
 panel_menu_ctrl();
}
//------------------ 面板状态切换 ---------------------
function panel_menu_ctrl()
{
   if(MENU_SWITCH==0)
   {
      parent.document.getElementById("frame2").cols="7,190,5,10,*";
      MENU_SWITCH=1;
   }
   else
   {
      parent.document.getElementById("frame2").cols="0,0,0,10,*";
      MENU_SWITCH=0;
   }
}
</script>
</head>
<body onload="panel_menu_open()">
   <div class="qiehuan" onclick="panel_menu_ctrl()" >
      <sapn>
         <div class="zt4"> </div> 
         <div class="zt5"> </div>
         <div class="anniu"> </div>
      </sapn>
   </div>
</body>
</html>