<{include file="public/head.tpl"}>
<script type="text/javascript" src="<{$res}>/js/WdatePicker/WdatePicker.js"></script>
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
	});	
	
</script>

<body class="bodycolor"  width='100%'>

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">

<tr>
	<td colspan="21" class="biaoti" align="left">&nbsp;跟踪记录</span></td>
</tr>
<tr class="biaoti">
	<td noWrap width="40">隶属人</td>
	<td noWrap width="40">编号</td>
	<td noWrap width="45">姓名</td>
	<td noWrap width="45">手机号</td>
	<td noWrap width="45">联系时间</td>
	<td noWrap width="65">联系内容</td>
    <td nowrap width="50">预约联系时间</td>
	<td nowrap width="80">预约联系内容</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab" onDblClick="location.href='#'">
	<td noWrap  align='center'> <{$item.lsrname}> </td>
	<td noWrap  align='center'><{$item.bianhao}> </td>
	<td noWrap  align='center'> <{$item.name}> </td>
	<td noWrap  align='center'> <{$item.sphone}> </td>
	<td noWrap  align='left'> <{$item.lianxitime|date_format:'%Y-%m-%d %H:%M:%S'}> </td>
	<td noWrap  align='left'> <{$item.lianxineirong}> </td>
	<td noWrap  align='left'> <{if $item.nexttime!='0'}> <{$item.nexttime|date_format:'%Y-%m-%d %H:%M:%S'}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.nextneirong}> </td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="14">
        	没有找到相关信息
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