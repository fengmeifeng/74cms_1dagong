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
	<td colspan="21" class="biaoti" align="left">&nbsp;推荐未激活的账户（注：只有推荐的帐户激活后才可以拿到奖金）</span></td>
</tr>
<tr class="biaoti">
	<td noWrap width="120">编号</td>
	<td noWrap width="110">姓名</td>
	<td noWrap width="100">推荐人编号</td>
	<td noWrap width="45">关系</td>
	<td noWrap width="65">手机号</td>
	<td noWrap width="45">QQ</td>
    <td nowrap width="135">添加时间</td>
    <td nowrap width="80">状态</td>
	<td nowrap width="80">操作</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab" onDblClick="location.href='#'">
	<td noWrap  align='left'>&nbsp; <{$item.bianhao}> </td>
	<td noWrap  align='left'> <{$item.name}> </td>
	<td noWrap  align='left'> <{if $item.f_bianghao!='0'}> <{$item.f_bianghao}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.guanxi}> </td>
	<td noWrap  align='right'> <{$item.sphone}> </td>
	<td noWrap  align='right'> <{$item.qq}> </td>
	<td noWrap  align='left'> <{$item.add_time|date_format:"%Y-%m-%d %H:%M:%S"}> </td>
	<td noWrap  align='center'> 
		<{if $item.jihuo=='1'}> <font color="green">已激活</font> <{else}> <font color="red">未激活</font> <{/if}>	&nbsp;&nbsp;
		<{if $item.status=='1'}> <font color="green">已入职</font> <{else}> <font color="red">未入职</font> <{/if}>
	</td>
	<td noWrap  align='center'> <a  <{if $item.status=='1'}>  href="javascript:alert('没有权限删除!');" <{else}>  href="<{$url}>/deluser/id/<{$item.id}>" onclick="return confirm('你确定要删除吗? ')" <{/if}> >删除</a> </td>
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