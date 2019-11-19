<{include file="public/head.tpl"}>
<div class="bodycolor">

<table align="center" class="addtab" width='60%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="6">&nbsp;发放路费金额</td>
</tr>
<tr>
	<td class="tabhead" nowrap="" align="middle" colspan="6" >&nbsp;&nbsp;</td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">姓名:</td>
	<td align="left"> <{$data.xingming}> </td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">电话:</td>
	<td align="left"> <{$data.dianhua}> </td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">身份证号码:</td>
	<td align="left"> <{$data.nameid}> </td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">户籍:</td>
	<td align="left"> <iframe src="http://api.k780.com/?app=idcard.get&appkey=10003&sign=b59bc3ef6191eb9f747dd4e83c99f2a4&format=json&idcard=<{$data.nameid}>"></iframe> </td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">公司名:</td>
	<td align="left"> <{$data.gongshiming}> </td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">开户行:</td>
	<td align="left"> <{$data.yinhangming}> </td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">银行卡号:</td>
	<td align="left"><b> <{$data.yinghaohao}> </b></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">审核人:</td>
	<td align="left"> <{$data.shenheren}> </td>
</tr>
<form action="<{$url}>/fafang" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<{$data.id}>">
<tr>
	<td align="left" width="20%" class="cdm">报销路费金额:</td>
	<td align="left"> <input type="text" name="jine" size="30" class="SmallInput" /></td>
</tr>
<tr>
	<td class="tabhead" nowrap="" align="middle" colspan="6">&nbsp;&nbsp;</td>
</tr>
<tr class="tabhead">
	<td class="TableHeader" align="left" colspan="6">
		<input type="submit" value=" 保存 " class="sub">
	</td>
</tr>
</table>
</form>
<!---->
</div>
<{include file="public/foot.tpl"}>