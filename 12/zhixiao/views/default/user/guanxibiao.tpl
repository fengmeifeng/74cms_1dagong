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
	<td colspan="21" class="biaoti" align="left">&nbsp;推荐关系表</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<{$url}>/guanxibiao" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="name">姓名</option>
				<option value="bianhao">编号</option>
				<option value="sphone">手机号</option>
				<option value="id_number">身份证号</option>
				<option value="ruzhi_name">入职企业</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap width="40">伯乐</td>
	<td noWrap>编号</td>
	<td noWrap width="110">姓名</td>
	<td noWrap width="70">推荐人编号</td>
	<td noWrap width="70">推荐人姓名</td>
	<td noWrap width="40">关系</td>
	<td noWrap width="65">奖金</td>
	<td noWrap width="45">推荐</td>
	<td noWrap width="62">会员类型</td>
	 <td nowrap width="70">入职时间</td>
	 <td nowrap width="75">入职企业</td>
    <td nowrap width="120">激活时间</td>
    <td nowrap width="75">添加时间</td>
    <td nowrap width="50">状态</td>
    <td nowrap width="150">操作</td>
	<td nowrap>备注</td>
</tr>

<{if $user}>
<tr class="khbox tab">
	<td noWrap > <{$item.xiezhu}> </td>
	<td noWrap  align='left'> <font color="#3388CE"><{$user.kg}></font><{$user.bianhao}> </td>
	<td noWrap  align='left'> <{$user.name}> </td>
	<td noWrap  align='left'> <{if $user.f_bianghao!='0'}> <{$user.f_bianghao}> <{/if}> </td>
	<td noWrap  align='left'> <{$user.f_name}></td>
	<td noWrap  align='left'> <{$user.guanxi}> </td>
	<td noWrap  align='right'> <{$user.jiangjin}>元 </td>
	<td noWrap  align='right'> <{$user.tj_num}>人 </td>
	<td noWrap  align='left'> <{$user.jibie}> </td>
	<td noWrap  align='left'> <{$user.ruzhi_time|date_format:"%Y-%m-%d"}> 1</td>
	<td noWrap  align='left'> <{$user.ruzhi_name}> </td>
	<td noWrap  align='left'> <{$user.jihuo_time|date_format:"%Y-%m-%d %H:%M:%S"}> </td>
	<td noWrap  align='left'> <{$user.add_time|date_format:"%Y-%m-%d"}> </td>
	<td noWrap  align='left'> <{if $user.status=='1'}> <font color="green">在职</font> <{elseif $user.status=='2'}> <font color="red">已离职</font> <{else}> 无  <{/if}> </td>
    <td> <a href="<{$url}>/huiyuaninfo/id/<{$user.id}>/dqurl/guanxibiao">查资料</a> <a href="<{$url}>/huiyuantuijian/id/<{$user.id}> "> 推荐列表</a>
		
	</td>
	<td noWrap  align='left'> <{$item.beizu}> </td>
</tr>
<{/if}>

<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab">
	<td noWrap > <{$item.xiezhu}> </td>
	<td noWrap  align='left'> <font color="#3388CE"><{$item.kg}></font><{$item.bianhao}> </td>
	<td noWrap  align='left'> <{$item.name}> </td>
	<td noWrap  align='left'> <{if $item.f_bianghao!='0'}> <{$item.f_bianghao}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.f_name}></td>
	<td noWrap  align='center'> <{$item.guanxi}> </td>
	<td noWrap  align='right'> <{$item.jiangjin}>元 </td>
	<td noWrap  align='right'> <{$item.tj_num}>人 </td>
	<td noWrap  align='left'> <{$item.jibie}> </td>
	<td noWrap  align='left'> <{$item.ruzhi_time|date_format:"%Y-%m-%d"}></td>
	<td noWrap  align='left'> <div style="width:80px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; " title="<{$item.ruzhi_name}>"><{$item.ruzhi_name}></div> </td>
	<td noWrap  align='left'> <{$item.jihuo_time|date_format:"%Y-%m-%d %H:%M:%S"}> </td>
	<td noWrap  align='left'> <{$item.add_time|date_format:"%Y-%m-%d"}> </td>
	<td noWrap  align='left'> <{if $item.status=='1'}> <font color="green">在职</font> <{elseif $item.status=='2'}> <font color="red">已离职</font> <{else}> 无  <{/if}> </td>
    <td>
	<{if $item.add_gs!='' && $item.add_gs!=$gdd_user}>
		<a href="javascript:;" onclick="alert('没有权限！')" >无法操作</a>
	<{else}>
		<a href="<{$url}>/huiyuaninfo/id/<{$item.id}>/dqurl/guanxibiao">查资料</a> <a href="<{$url}>/huiyuantuijian/id/<{$item.id}> "> 推荐列表</a>
	<{/if}>
	</td>
	<td noWrap  align='left'> <{$item.beizu}> </td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="14">
        	没有找到！
        </td>
    </tr>
<{/if}>
<tr class="biaoti">
	<td align="left" colspan="20" >
		<{$fpage_weihu}>
	</td>
</tr>
</table>

<{include file="public/foot.tpl"}>