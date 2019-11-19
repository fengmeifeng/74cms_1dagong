<{include file="public/head.tpl"}>

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

<body class="bodycolor">

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="21" class="biaoti" align="left"><span style="float:left;">&nbsp;日志记录</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<{$url}>/index" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="name">操作人</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap>操作人</td>
	<td noWrap>IP</td>
	<td noWrap>操作时间</td>
	<td noWrap>操作内容</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab">
	<td noWrap  align='left'> &nbsp;<{$item.name}> </td>
	<td noWrap  align='left'> <{$item.ip}> </td>
	<td noWrap  align='left'> <{$item.time|date_format:"%Y-%m-%d %H:%M:%S"}> </td>
	<td noWrap  align='left'> <{$item.caozuo}> </td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="14">
        	没有推荐任何人
        </td>
    </tr>
<{/if}>
<tr class="biaoti">
	<td align="left" colspan="20">
	<{$fpage_weihu}>
	</td>
</tr>
</table>

<{include file="public/foot.tpl"}>