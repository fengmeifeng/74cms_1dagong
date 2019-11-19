<{include file="public/head.tpl"}>
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


<div class="regwrap">
	<form name="form1" method="post" action="<{$url}>/zhucedaima">
		<h3>注册用户：</h3>
		
		<ul class="">
			<{if $pid <= 1}>
			<li><label>推荐人编号：</label><input class="ipt" type="text" name="tuijianbiaohao" size="20" maxlength="7" > <span class="red">* 不填默认当前报单中心</span></li>
			<{/if}>
			<li><label>和我的关系：</label><select class="ipt" name="guanxi" style="height: 28px;">
				<option value="">请选择</option>
				<{foreach from=$guanxi item=item}>
					<option value="<{$item.guanxi}>"><{$item.guanxi}></option>
				<{/foreach}>
				</select>
			</li>
			<li><label>编号：</label><input class="ipt" type="text" name="bianhao" size="20" value="<{$bianhao}>" readonly> <span class="red">*</span></li>
			<li><label>姓名：</label><input class="ipt" type="text" name="name" size="8" maxlength="4" > <span class="red">*</span></li>
			<li><label>手机号：</label><input class="ipt" type="text" name="sphone" size="20" maxlength="13" > <span class="red">*</span></li>
			<li><label>QQ/微信号：</label><input class="ipt" type="text" name="qq" size="20" maxlength="13" >
			<li><label>身份证号码：</label><input class="ipt" type="text" name="id_number" size="30" maxlength="19" > <span class="red">*</span></li>
		</ul>
		
		<ul class="">
		  <li><label>&nbsp;</label><input type="submit" value="确定提交" class="bt"></li>
		</ul>
		
	</form>
</div>


<{include file="public/foot.tpl"}>