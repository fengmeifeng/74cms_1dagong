<{include file="public/head.tpl"}>
<div class="bodycolor">
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

<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="12">&nbsp;单位管理</td>
</tr>
<tr class="biaoti" >
	<td>选择</td>
	<td>单位名称</td>
	<td>单位电话</td>
	<td>传真</td>
	<td>邮政编码</td>
	<td>单位地址</td>
	<td>网址</td>
	<td>电子邮件</td>
	<td>银行帐号名</td>
	<td>银行帐号</td>
	<td>税号</td>
	<td>操作</td>
</tr>
<tr>
<{foreach from=$data item=list}>
<tr class="tab">
	<td>
		<input type="checkbox" name="selectid[]" id="selectid" value="<{$list.id}>">
		<a href="#"><img src="<{$res}>/images/edit1.gif" border="0"></a>
	</td>
	<td><{$list.unit_name}></td>
	<td><{$list.tel_no}></td>
	<td><{$list.fax_no}></td>
	<td><{$list.post_no}></td>
	<td><{$list.address}></td>
	<td><{$list.url}></td>
	<td><{$list.email}></td>
	<td><{$list.bank_name}></td>
	<td><{$list.bank_no}></td>
	<td><{$list.numzero}></td>
	<td></td>
</tr>
<{/foreach}>
</table>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</div>
<{include file="public/foot.tpl"}>