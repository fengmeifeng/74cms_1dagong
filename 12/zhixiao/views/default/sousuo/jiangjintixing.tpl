<{include file="public/head.tpl"}>
<script type="text/javascript" src="<{$res}>/js/WdatePicker/WdatePicker.js"></script>

<script type="text/javascript">
	$(function(){
		//隔行换色
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	});
</script>

<body class="bodycolor">

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="21" class="biaoti" align="left">&nbsp;有奖金的会员发送短信提醒　 <font color="red">（注意：每个月只可以提醒一次！ 提醒时间：每月1号到3号。）<input type="button" value=" 一键发送 " class="sub_b" onclick="location='<{$url}>/yijianfasong';"></font> </td>
</tr>
<tr class="biaoti">
	<td noWrap width="40">伯乐</td>
	<td noWrap width="60">编号</td>
	<td noWrap width="60">姓名</td>
	<td noWrap width="70">推荐人姓名</td>
	<td noWrap width="50">关系</td>
	<td noWrap width="55">推荐人数</td>
	<td noWrap width="55">奖金</td>
	<td noWrap width="70">手机号</td>
	<td noWrap width="120">身份证号码</td>
	<td noWrap width="80">地址</td>
	<td noWrap width="65">会员类型</td>
	<td nowrap width="80">入职时间</td>
	<td nowrap width="70">入职企业</td>
	<td nowrap width="50">状态</td>
    <td nowrap width="85">添加时间</td>
	<td nowrap>操作</td>
	<td nowrap>备注</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab" >
	<td noWrap > <{$item.xiezhu}> </td>
	<td noWrap  align='left'> <{$item.bianhao}> </td>
	<td noWrap  align='left'> <{$item.name}> </td>
	<td noWrap  align='left'> <{$item.f_name}> </td>
	<td noWrap  align='left'> <{$item.guanxi}> </td>
	<td noWrap  align='right'> <{$item.tj_num}>人 </td>
	<td noWrap  align='right'> <b style="color:red"><{$item.jiangjin}></b>元 </td>
	<td noWrap  align='left'> <{$item.sphone}> </td>
	<td noWrap  align='left'> <{$item.id_number}> </td>
	<td nowrap  align="center"> <div style="width:80px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; " title="<{$item.address}>"> <{$item.address}> </div> </td>
	<td noWrap  align='left'> <{$item.jibie}> </td>
	<td noWrap  align='center'> <{$item.ruzhi_time|date_format:"%Y-%m-%d"}> </td>
	<td noWrap  align='center'> <div style="width:80px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; " title="<{$item.ruzhi_name}>"> <{$item.ruzhi_name}> </div> </td>
	<td noWrap  align='center'> <{if $item.status=='1'}> <font color="green">在职</font> <{elseif $item.status=='2'}> <font color="red">已离职</font>  <{else}> 无 <{/if}> </td>
	<td noWrap  align='center'> <{if $item.jihuo_time!='0'}> <font color="green">已激活</font> <{$item.jihuo_time|date_format:"%Y-%m-%d"}> <{else}> <font color="red"> 未激活 </font>  <{/if}> </td>
	<td noWrap  align='center'> <{if $item.tixing==1}> 已提醒 <{else}>　<a href="<{$url}>/fasongtixing/id/<{$item.id}>"> 发送提醒 </a>　<{/if}> </td>
	<td noWrap  align='left'> <{$item.beizu}> </td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="21">
        	没有了！
        </td>
    </tr>
<{/if}>
<tr class="biaoti">
	<td align="left" colspan="21" >
		<{$fpage_weihu}>
	</td>
</tr>
</table>

<{include file="public/foot.tpl"}>