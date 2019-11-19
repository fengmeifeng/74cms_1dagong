<{include file="public/head.tpl"}>
<script type="text/javascript" src="<{$res}>/js/WdatePicker/WdatePicker.js"></script>
<style>
.regwrap {
	margin-top: -5px;
	padding: 30px;
	text-align: left;
}
.regwrap h3 {
	display: block;
	color: #025db3;
	font-size: 14px;
	font-weight: bold;
	line-height: 40px;
	height: 40px;
	border-top: 1px solid #eee;
	margin-bottom: 5px;
}
.regwrap ul {
	display: block;
	padding-left: 20px;
}
ul {
	list-style-image: none;
	list-style-type: none;
}
.regwrap li {
	display: block;
	clear: both;
	margin-bottom: 10px;
	font-size: 14px;
	color: #111;
}
.regwrap label {
	width: 120px;
	text-align: right;
	display: block;
	float: left;
	margin-right: 5px;
	font-size: 14px;
	font-weight: normal;
	color: #999;
}
.ipt {
	height: 18px;
	line-height: 18px;
	padding: 3px 4px;
	font-family: Verdana,宋体,微软雅黑;
	background: url(/public/images/ipt.gif) 0 0 no-repeat;
	border: 1px solid #9A9A9A;
	border-bottom: 1px solid #CDCDCD;
	border-right: 1px solid #CDCDCD;
}
.regwrap span.red {
	font-family: 宋体;
	color: red;
	font-size: 12px;
}
.bt {
	height: 28px;
	line-height: 28px;
	width: 88px;
	background: url(/public/images/bt.gif) no-repeat;
	border: 0px;
	color: #fff;
	font-weight: bold;
	font-size: 14px;
	text-align: center;
}

</style>

<script type="text/javascript">

$("#tuijianbiaohao").live("blur",function(){
	var key=$("#tuijianbiaohao").val();
	var url='<{$url}>/getbianhao';
	$.post(url,{bh:key}, function(data){
		//alert(data);
		$(".ts").html(data);
	});
 }); 
 
 $("#soujihaoma").live("blur",function(){
	var key=$("#soujihaoma").val();
	var url='<{$url}>/getshouji';
	$.post(url,{sphone:key}, function(data){
		//alert(data);
		$(".sts").html(data);
	});
 }); 
 
  $("#id_number").live("blur",function(){
	var key=$("#id_number").val();
	var url='<{$url}>/getid_number';
	$.post(url,{id_number:key}, function(data){
		//alert(data);
		$(".sf").html(data);
	});
 }); 
</script>

<div class="regwrap">
	<form name="form1" method="post" action="<{$url}>/zhucedaima">
	
		<input type="hidden" name="bh" value="<{$bh}>"  /><!---->
		<input type="hidden" name="sid" value="<{$id}>"  /><!---->
		
		<h3>注册用户：</h3>
		
		<ul class="">
			<li><label>推荐人编号：</label><input class="ipt" type="text" id="tuijianbiaohao" name="tuijianbiaohao" size="20" maxlength="7" > <span class='ts'> <span class="red">* 不填默认当前地区的一级会员</span> </span> </li>
			<li><label>与推荐人的关系：</label><select class="ipt" name="guanxi" style="height: 28px;">
				<option value=" ">请选择</option>
				<{foreach from=$guanxi item=item}>
				<option value="<{$item.guanxi}>"><{$item.guanxi}></option>
				<{/foreach}>
				</select>
			</li>
			<li><label>编号：</label><input class="ipt" type="text" name="bianhao" size="20" value="<{$bianhao}>" readonly> <span class="red">*</span></li>
			<li><label>姓名：</label><input class="ipt" type="text" name="name" size="8" maxlength="4" > <span class="red">*</span></li>
			<li><label>手机号：</label><input class="ipt" type="text" id="soujihaoma" name="sphone" size="20" maxlength="11" > <span class='sts'> <span class="red">*</span> </span></li>
			<li><label>QQ/微信号：</label><input class="ipt" type="text" name="qq" size="20" maxlength="13" >
			<li><label>身份证号码：</label><input class="ipt" type="text" id="id_number" name="id_number" size="30" maxlength="18" > <span class='sf'> <span class="red">*</span> </span> </li>
		</ul>
		<hr>
		<ul class="">
			<li><label>伯乐：</label><input class="ipt" type="text" name="xiezhu" size="30" maxlength="19" > </li>
		</ul>
		
		<ul class="">
		  <li><label>&nbsp;</label><input type="submit" value="确定提交" class="bt"></li>
		</ul>
		
	</form>
</div>


<{include file="public/foot.tpl"}>