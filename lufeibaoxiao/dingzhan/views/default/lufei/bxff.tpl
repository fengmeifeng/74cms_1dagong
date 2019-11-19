<{include file="public/head.tpl"}>
<link rel="stylesheet" type="text/css" href="<{$res}>/css/lufei.css">
<script type="text/javascript" src="<{$res}>/js/example.js"></script>

<div class="bodycolor">
<script type="text/javascript">
	$(function(){
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	})
	//立即申请发放
	function sh(id){
		$('.id').val(id);
		$(".duihuakuangbox").show();


	}
	//正在等待发放
	function cg(){
		$('.id').val(id);
		$(".duihuakuangbox").show();

	}
</script>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="10">&nbsp;审核成功满15天用户管理</td>
</tr>
<tr class="TableControl">
	<td class="Tabhead" align="left" colspan="10">
		<form action="<{$url}>/bxff" method="get" style="display:inline;">&nbsp;
		查找人员：	
		<input type="text" class="SmallInput" maxlength="200" size="20" name="name" style="display:inline-block">
		<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td width="100">姓名</td>
	<td width="100">入职已满</td>
	<td width="120">电话</td>
	<td>身份证号码</td>
	<td>公司名</td>
	<td>开户行</td>
	<td width="180">卡号</td>
	<td width="100">入职时间</td>
	<td width="100">审核人</td>
	<td width="80">操作</td>
</tr>
<{foreach from=$data item=list}>
<tr class="tab">
	<td><input type="checkbox" name="box" value="<{$list.id}>">&nbsp;<{$list.xingming}></td>
	<td align="left">&nbsp;&nbsp;<{$list.rzt}></td>
	<td align="left">&nbsp;&nbsp;<{$list.dianhua}></td>
	<td align="left">&nbsp;&nbsp;<{$list.nameid}></td>
	<td align="left">&nbsp;&nbsp;<{$list.gongshiming}></td>
	<td align="left">&nbsp;&nbsp;<{$list.yinhangming}></td>
	<td align="left">&nbsp;&nbsp;<b><{$list.yinghaohao}></b></td>
	<td align="left">&nbsp;&nbsp;<{$list.rztime|date_format:"%Y-%m-%d"}></td>
	<td align="left">&nbsp;&nbsp;<b><{$list.shenheren}></b></td>
	<td align="center">
		<{if $list.dff==0}>
			<a href="javascript:;" onclick="sh('<{$list.id}>')">立即申请发放</a>
		<{elseif $list.dff==1}>
			<a href="javascript:;" onclick="cg('<{$list.id}>')">正在等待发放</a>
		<{/if}>
	</td>
</tr>
<{/foreach}>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="10">&nbsp;<{$fpage}></td>
</tr>
</table>

</div>
<{include file="public/foot.tpl"}>



<div class="duihuakuangbox" id="duihuakuangbox">
	<div class="duihuakuang">
		<div class="tit" id="tit">
			<div class="title" id="title">是否合格</div>
			<div class="close" onclick="gb()"> </div>
		</div>
		<div class="com">
			<form method="post" action="<{$url}>/sf">
				<div class="xz"><input type="radio" name="sh" value="1"  checked="checked" onclick="radio_click(this)">合格&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="sh" value="0" onclick="radio_click(this)" >已离职</div>
				<div class="text"><input type="hidden" name="id" class="id" value=""><textarea name="text" class="tt"></textarea><input type="submit" value="提交" class="but"></div>

			</form>
		</div>
	</div>
</div>

<script>
var exampB = new DragObject({
	el: 'duihuakuangbox',
	attachEl: 'tit'
});
//关闭
function gb(){
	$(".duihuakuangbox").hide();
}
//-----------
function radio_click(obj){
	if(obj.value==0){
		$(".tt").show();
	}else{
		$(".tt").hide();
	}
}

</script>