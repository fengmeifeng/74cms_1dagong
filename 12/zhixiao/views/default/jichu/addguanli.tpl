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
	width: 100px;
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
	<form name="form1" method="post" action="<{$url}>/guanliadd">
		<input type="hidden" name="bianhao" value="<{$bianhao}>"  />
		<h3>新建报单中心</h3>
		<ul class="">
			<li><label>登录名：</label><input class="ipt" type="text" name="username" size="30" > <span class="red">*</span></li>
			<li><label>姓名：</label><input class="ipt" type="text" name="name" size="30" > <span class="red">*</span></li>
			<li><label>权限：</label><select name="quanxian" class="ipt" style="height: 28px;">
				<option value=""> 请选择 </option>
				<option value="3"> 报单员 </option>
				<option value="4"> 审核员 </option>
				<option value="5"> 财务 </option>
			</select></li>
			<li><label>登录密码：</label><input class="ipt" type="password" name="pass1" size="30" > <span class="red">*</span></li>
			<li><label>确认登录密码：</label><input class="ipt" type="password" name="pass2" size="30" > <span class="red">*</span></li>
		</ul>
		<ul class="">
		  <li><label>&nbsp;</label><input type="submit" value="确定提交" class="bt"></li>
		</ul>
	</form>
</div>


<{include file="public/foot.tpl"}>