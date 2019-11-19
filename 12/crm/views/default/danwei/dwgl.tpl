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
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<FORM action="<{$url}>/dwgl" method="post" style="display:inline;" >
	<td colspan="12" align="left">
		<input type="button" value=" 新建 " class="sub" onclick="alert('no')" /> <!--location='<{$url}>/add';-->
		<select class="SmallSelect" name="searchfield" >
			<option value="dept_name">部门名称</option>
			<option value="tel_no">部门电话</option>
			<option value="manager">部门主管</option>
		</select>
		<input type="text" class="SmallInput" maxlength="200" size="12" name="searchvalue" value="" />
		<input type="submit" value=" 查找 " class="sub" />
		</FORM>	
	</td>
</tr>
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="12">&nbsp;系统菜单</td>
</tr>
<tr class="biaoti">
	<td align="middle" width="80">选择</td>
	<td align="middle" width="180">部门名称</td>
	<td align="middle" width="120">部门电话</td>
	<td align="middle" width="120">父部门</td>
	<td align="middle" width="80">部门主管</td>
	<td align="middle">部门人员</td>
	<td align="middle" width="150">操作</td>	
</tr>
<{foreach from=$data item=list}>
<FORM action="<{$url}>/del" method="post" >
<tr class="tab">
	<td>
		<input type="checkbox" name="selectid[]" id="selectid" value="<{$list.dept_id}>">
		<a href="<{$url}>/mod/id/<{$list.dept_id}>"><img src="<{$res}>/images/edit1.gif" border="0"></a>
	</td>
	<td align="left">&nbsp;<{$list.kg}><{$list.dept_name}></td>
	<td align="left">&nbsp;<{$list.tel_no}></td>
	<td align="left">&nbsp;<{$list.dept}></td>
	<td align="left">&nbsp;<{$list.manager}></td>
	<td align="left">&nbsp;<{$list.dept_func}></td>
	<td>
		<a href="<{$url}>/add/dept_parent_id/<{$list.dept_id}>">添加子部门</a>
		<a onclick="return confirm('你确定要删除吗? ')" href="<{$url}>/del/id/<{$list.dept_id}>">删除</a>
	</td>
</tr>
<{/foreach}>
<tr>
	<td colspan="12" align="left">
		&nbsp;&nbsp;&nbsp;<input type="checkbox" class="ckbox" style="display:inline-block">全选
		<input type="submit" value="删除" class="sub" onclick="return confirm('你确定要删除吗? ')" />
	</td>
</tr>
</FORM>
</table>
</div>
<{include file="public/foot.tpl"}>
