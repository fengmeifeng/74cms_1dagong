<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>�Զ�����</title>
<link href="css/base.css" rel="stylesheet" type="text/css">
</head>
<body background='images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#cfcfcf">
  <tr>
   <td height="28" background="images/tbg.gif" colspan="7"  style="padding-left:10px;">
     <b>�Զ����ǹ���</b>
     &nbsp;[<a href="mytag_add.php"><u>����һ�����</u></a>]
     &nbsp;[<a href="mytag_tag_guide.php"><u>���ܱ����</u></a>]
	</td>
</tr>
  <tr align="center" bgcolor="#FBFCE2" height="24"> 
      <td width="10%">���</td>
      <td width="20%">�������</td>
      <td width="15%">������Ŀ</td>
      <td width="15%">ʱ������</td>
      <td width="20%">����ʱ��</td>
      <td width="20%">����</td>
   </tr>
   <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
    <tr align="center" bgcolor="#FFFFFF" height="24" onMouseMove="javascript:this.bgColor='#FCFDEE';"
    	 onMouseOut="javascript:this.bgColor='#FFFFFF';"> 
        <td><?php echo $fields['aid']; ?></td>
        <td><?php echo $fields['tagname']; ?></td>
        <td><?php echo TestType($fields['typename']); ?></td>
        <td><?php echo TimeSetValue($fields['timeset']); ?></td>
        <td><?php echo GetDateMk($fields['endtime']); ?></td>
        <td>
          	<a href='mytag_edit.php?aid=<?php echo $fields['aid']; ?>&dopost=edit'>����</a> | 
		        <a href='mytag_edit.php?aid=<?php echo $fields['aid']; ?>&dopost=delete'>ɾ��</a> | 
		        <a href='mytag_edit.php?aid=<?php echo $fields['aid']; ?>&dopost=getjs'>JS����</a>
		    </td>
     </tr>
		<?php
}
}?>
     <tr align="center" bgcolor="#F9FCEF" height="36"> 
      <td colspan="7">
      	<?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '6';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>

      </td>
     </tr>
   </table>
   </td>
</tr>
</table>
</body>
</html>