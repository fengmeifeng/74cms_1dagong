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
	
	//移交。。。。。
    function yijiao(){
    	var str=new Array();
	    $('[name = selectid[]]:checkbox').each(function(){
	    	if($(this).attr("checked")){
		 		str+=$(this).val()+",";
		 	}
		});
		//调用方法 如        
		var postForm = document.createElement("form");//表单对象 
		postForm.method="post" ; 
		postForm.action = '<{$url}>/yaofenpeiuser' ; 

		var emailInput = document.createElement("input") ; //email input 
		emailInput.setAttribute("name", "id") ; 
		emailInput.setAttribute("value", str); 
		postForm.appendChild(emailInput) ; 

		document.body.appendChild(postForm) ; 
		postForm.submit() ; 
		document.body.removeChild(postForm) ;
    } 
</script>

<body class="bodycolor"  width='100%'>

<br/>
<table align="center" class="addtab" width='110%' cellspacing='0' cellpadding='0' border="1">

<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<{$url}>/yaofenpei" method="get" style="display:inline;">
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
				<option value="jihuo_time">激活时间</option>
			</select>
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			
			<select name="status" class="SmallSelect">
				<option value="">选择在职状态</option>
				<option value="1">在职</option>
				<option value="2">离职</option>
				<option value="5">未入职</option>
			</select>
			
			<select name="jihuo" class="SmallSelect">
				<option value="">选择激活状态</option>
				<option value="1">已激活</option>
				<option value="5">未激活</option>
			</select>
			
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>

<tr>
	<td colspan="21" class="biaoti" align="left">&nbsp;未分配的会员</span></td>
</tr>
<tr class="biaoti">
	<td noWrap width="45">操作</td>
	<td noWrap width="45">编号</td>
	<td noWrap width="65">姓名</td>
	<td noWrap width="70">推荐人编号</td>
	<td noWrap width="70">推荐人姓名</td>
	<td noWrap width="25">关系</td>
	<td noWrap width="30">性别</td>
	<td noWrap width="45">手机号</td>
	<td noWrap width="45">QQ</td>
	<td noWrap width="65">地址</td>
    <td nowrap width="50">添加时间</td>
	<td nowrap width="80">入职状态于时间</td>
	<td nowrap width="50">入职企业</td>
	<td nowrap width="85">激活状态于时间</td>
	<td nowrap width="80">备注</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab" onDblClick="location.href='#'">
	<td noWrap  align='left'> 
		<input type="checkbox" name="selectid[]" id="selectid" value="<{$item.id}>|<{$item.name}>">
		<a href="<{$url}>/yaofenpeiuser/id/<{$item.id}>/name/<{$item.name}>"><img src="<{$res}>/ico/6710.gif" title="分配" border="0"></a>
	</td>
	<td noWrap  align='left'><{$item.bianhao}> </td>
	<td noWrap  align='left'> <{$item.name}> </td>
	<td noWrap  align='left'> <{if $item.f_bianghao!='0'}> <{$item.f_bianghao}> <{/if}> </td>
	<td noWrap  align='left'> <{if $item.f_name!=''}> <{$item.f_name}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.guanxi}> </td>
	<td noWrap  align='left'> <{$item.sex}> </td>
	<td noWrap  align='right'> <{$item.sphone}> </td>
	<td noWrap  align='right'> <{$item.qq}> </td>
	<td noWrap  align='left'> <{$item.address}> </td>
	<td noWrap  align='center'> <{$item.add_time|date_format:"%Y-%m-%d"}> </td>
	<td noWrap  align='center'> <{if $item.status=='1'}> <font color="green">已入职</font> <{elseif $item.status=='2'}> <font color="red">离职</font> <{else}> <font color="red">未入职</font> <{/if}> &nbsp; <{if $item.ruzhi_time!='0'}> <{$item.ruzhi_time|date_format:"%Y-%m-%d"}> <{/if}> </td>
	<td noWrap  align='right'> <{$item.ruzhi_name}> </td>
	<td noWrap  align='center'> <{if $item.jihuo=='1'}> <font color="green">已激活</font> <{else}> <font color="red">未激活</font> <{/if}> &nbsp; <{if $item.jihuo_time!='0'}> <{$item.jihuo_time|date_format:"%Y-%m-%d"}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.beizu}> </td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="21">
        	没有找到相关信息
        </td>
    </tr>
<{/if}>
<tr class="biaoti">
	<td align="left" colspan="21">
		<input type="checkbox" name="rowid[]" id="selectid" class="ckbox">全选
		<input type="button" value="分配" class="sub" onclick="yijiao();">
		<{$fpage_weihu}>
	</td>
</tr>
</table>

<{include file="public/foot.tpl"}>