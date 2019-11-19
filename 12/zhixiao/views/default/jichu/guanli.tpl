<{include file="public/head.tpl"}>

<script type="text/javascript">
	$(function(){
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	})
</script>

<div class="bodycolor">

<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td align="left" colspan="7">
		<input type="button" value=" 新建 " class="sub" onclick="location='<{$url}>/addguanli/bianhao/<{$bianhao}>';" >
	</td>
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="7">&nbsp;报单中心管理</td>
</tr>
<tr class="biaoti">
	<td noWrap >选择</td>
	<td noWrap >登录名</td>
	<td noWrap >姓名</td>
	<td noWrap >会员级别</td>
	<td noWrap >操作</td>
</tr>
<{foreach from=$data item=list}>
<tr class="tab">
	<td noWrap >
		<input type="checkbox" name="box" value="<{$list.id}>">
		<a href="<{$url}>/modguanli/id/<{$list.id}>"><img src="<{$res}>/images/edit1.gif" border="0"></a>
	</td>
	<td noWrap align="center">&nbsp;&nbsp;<{$list.username}></td>
	<td noWrap align="left"> &nbsp;&nbsp;<{$list.name}> </td>
	<td noWrap align="center">&nbsp;&nbsp;<{$list.priv_name}></td>
	<td noWrap > <a href="<{$url}>/modguanli/id/<{$list.id}>">修改</a> |&nbsp;&nbsp;<a href="<{$url}>/guanlidel/id/<{$list.id}>" onclick="return confirm('你确定要删除吗? ')" >删除</a> </td>
</tr>
<{/foreach}>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="7">&nbsp;<{$fpage}></td>
</tr>
</table>
</div>

<{include file="public/foot.tpl"}>