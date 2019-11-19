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

<body class="bodycolor">

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="21" class="biaoti" align="left">&nbsp;未激活会员列表</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<{$url}>/weijihuouser" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="name">姓名</option>
				<option value="bianhao">编号</option>
				<option value="sphone">手机号</option>
				<option value="id_number">身份证号</option>
				<option value="ruzhi_name">入职企业</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			
			<select name="shijianduan" class="SmallSelect">
				<option value="">选择时间段</option>
				<option value="add_time">添加时间</option>
				<option value="ruzhi_time">入职时间</option>
			</select>
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap width="75">编号</td>
	<td noWrap width="100">姓名</td>
	<td noWrap width="70">推荐人编号</td>
	<td noWrap width="70">推荐人姓名</td>
	<td noWrap width="60">关系</td>
	<td noWrap width="100">手机号码</td>
	<td noWrap width="90">QQ号码</td>
	<td noWrap width="75">会员类型</td>
    <td nowrap width="130">注册时间</td>
	<td nowrap width="90">入职时间</td>
	<td nowrap width="60">入职天数</td>
	<td nowrap width="60">入职企业</td>
	<td nowrap width="60">添加地区</td>
    <td nowrap width="180">操作</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab" >
	<td noWrap  align='left'>&nbsp; <{$item.bianhao}> </td>
	<td noWrap  align='left'> <{$item.name}> </td>
	<td noWrap  align='left'> <{if $item.f_bianghao!='0'}> <{$item.f_bianghao}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.f_name}> </td>
	<td noWrap  align='center'> <{$item.guanxi}> </td>
	<td noWrap  align='left'> <{$item.sphone}> </td>
	<td noWrap  align='left'> <{$item.qq}> </td>
	<td noWrap  align='left'> <{$item.jibie}> </td>
	<td noWrap  align='left'> <{$item.add_time|date_format:"%Y-%m-%d %H:%M:%S"}> </td>
	<td noWrap  align='center'> <{$item.ruzhi_time|date_format:"%Y-%m-%d"}> </td>
	<td noWrap  align='center'> <{$item.ts}>天 </td>
	<td noWrap  align='center'> <{$item.ruzhi_name}> </td>
	<td noWrap  align='left'> <{$item.add_gs}> </td>
    <td> <{if $priv=='1' and $priv=='4'}> <a href="javascript:alert('没有权限!')"> 激活会员 </a> <{else}><a onclick="return confirm('你确定要激活吗? ')" href="<{$url}>/jihuohuiyuan/id/<{$item.id}>"> 激活会员</a><{/if}> <a href="<{$url}>/huiyuaninfo/id/<{$item.id}>/dqurl/weijihuouser">查资料</a> <a onclick="return confirm('你确定要删除吗? ')" href="<{$url}>/delhuiyuan/id/<{$item.id}>"> 删除 </a> </td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="14">
        	没有找到要激活的会员
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