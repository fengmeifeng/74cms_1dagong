<{include file="public/head.tpl"}>
<link rel="stylesheet" type="text/css" href="<{$res}>/css/duihuakuang.css" />
<script type="text/javascript" src="<{$res}>/js/example.js"></script>
<script type="text/javascript" src="<{$res}>/js/WdatePicker/WdatePicker.js"></script>

<style>
td{
	background-color:#fff;
}
</style>

<div class="bodycolor">
<form action="<{$url}>/addgzjl" method="post">

<input type="hidden" name="lsrid" value="<{$user.id}>">
<input type="hidden" name="lsrname" value="<{$user.name}>">

<table align="center" class="addtab" width='550' cellspacing='0' cellpadding='0' border="1" bgcolor="#fff">
	<tr>
		<td class="tabhead" align="left" colspan="2">&nbsp; 新建联系记录</td>
	</tr>
	<tr>
		<td colspan="2" class="tabhead" align="left">
			<input type="button" value=" 返回 " class="sub" onclick="javascript:history.back();">
		</td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;编号:</td>
		<input type="hidden" name="kuhuid" value="<{$data.id}>">
		<input type="hidden" name="bianhao" value="<{$data.bianhao}>">
		<td align="left">&nbsp; <{$data.bianhao}> </td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;姓名:</td>
		<input type="hidden" name="name" value="<{$data.name}>">
		<td align="left">&nbsp;	<{$data.name}> </td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;联系电话:</td>
		<input type="hidden" name="sphone" value="<{$data.sphone}>">
		<td align="left">&nbsp;	<{$data.sphone}></td>
	</tr>
	
	<tr>
		<td width="20%" align="left">&nbsp;联系内容:</td>
		<td align="left">&nbsp;
			<textarea class="BigInput" name="lianxineirong" title="" rows="3" cols="40"></textarea>
		</td>
	</tr>	
	<tr>
		<td width="20%" align="left">&nbsp;联系时间:</td>
		<td align="left">&nbsp;
			<input class="SmallInput" maxlength="20" name="lianxitime" readonly value="<{$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}>" style="background:#E0E0E0"> 
			<img src="<{$res}>/images/clock.gif" width="16" height="16" title="设置时间" align="absMiddle" border="0" style="cursor:pointer" onclick="alert('不可以修改时间的')">
		</td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;预约联系时间:</td>
		<td align="left">&nbsp;
			<input class="SmallInput" maxlength="20" name="nexttime" value="" title="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"> <img src="<{$res}>/images/clock.gif" width="16" height="16" title="设置时间" align="absMiddle" border="0" style="cursor:pointer" onclick="nextcontacttime.click();">
		</td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;预约联系内容:</td>
		<td align="left">&nbsp;
			<textarea class="BigInput" name="nextneirong" title="" rows="3" cols="40"></textarea>
		</td>
	</tr>
	<tr align="left">
		<td colspan="2" class="tabhead"><input type="submit" class="sub" value="提交"></td>
	</tr>
</table>

</form>
</div>
<{include file="public/foot.tpl"}>