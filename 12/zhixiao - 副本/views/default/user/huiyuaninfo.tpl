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
<form method="post" action="<{$url}>/modinfo/dqurl/<{$dqurl}>" >
	<input type="hidden" name="id" value="<{$info.id}>" />
	<h3>推荐信息</h3>
	<ul class="">
	  <li><label>姓名：</label> <{$info.name}> </li>
	  <li><label>我的编号：</label><{$info.bianhao}></li>
	  <li><label>推荐链接：</label> http://12.1d501.com/tj.php?bh=<{$tjurl}> &nbsp; </li>
	  <li><label>推荐人数：</label>  <{$info.tj_num}>人 &nbsp; </li>
	  <li><label>获得的奖金：</label>  <{$info.jiangjin}>元 &nbsp; </li>
	</ul>
    <h3>个人信息</h3>
	<ul class="">
	  <li><label>姓别：</label><input name="sex" type="radio" value="男" <{if $info.sex=='男'}> checked <{/if}> > 男 &nbsp;&nbsp; <input type="radio" name="sex" value="女" <{if $info.sex=='女'}> checked <{/if}> > 女 <span class="red">*</span></li>
	  <li><label>联系电话：</label><input class="ipt" type="text" name="sphone" value="<{$info.sphone}>" size="20"> <span class="red">*</span></li>
	  <li><label>身份证号：</label><input class="ipt" type="text" name="id_number" value="<{$info.id_number}>" size="25" > <span class="red">*</span></li>
	  <li><label>详细地址：</label><input class="ipt" type="text" name="address" value="<{$info.address}>" size="35" > <span class="red">*</span></li>
	  <li><label>QQ/MSN：</label><input class="ipt" type="text" name="qq" value="<{$info.qq}>" size="20" ></li>
	  <li><label>推荐人关系：</label><select class="ipt" name="guanxi" style="height: 28px;">
			<option value="">请选择</option>
			<{foreach from=$guanxi item=item}>
				<option value="<{$item.guanxi}>" <{if $item.guanxi==$info.guanxi}> selected="selected"  <{/if}> > <{$item.guanxi}></option>
			<{/foreach}>
			</select> </li>
	</ul>
	
	<h3>职位信息</h3>
	<ul class="">
	  <li><label>入职企业：</label> <input class="ipt" type="text" name="ruzhi_name" value="<{$info.ruzhi_name}>" size="20"> <span class="red">*</span></li>
	  <li><label>入职时间：</label> <input class="ipt" type="text" name="ruzhi_time" value="<{if $info.ruzhi_time!='0'}><{$info.ruzhi_time|date_format:'%Y-%m-%d'}><{/if}>" size="20" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> <span class="red">*</span> </li>
	</ul>
	
	<h3>银行信息</h3>
	<ul class="">
	  <{if $user!="admin"}><li><label>  </label> <span class="red"> (没有权限修改银行账户信息!) </span> </li><{/if}>
	  <li><label>开户银行：</label><input type="text" class="ipt" name="bank" value="<{$info.bank}>"  <{if $user!="admin"}> disabled <{/if}> /> <span class="red">*</span></li>
	  <li><label>开户所在支行：</label><input type="text" class="ipt" name="subbranch" value="<{$info.subbranch}>"  <{if $user!="admin"}> disabled <{/if}> /> <span class="red">*</span></li>
	  <li><label>银行账号：</label><input type="text" class="ipt" name="bank_account" value="<{$info.bank_account}>"  <{if $user!="admin"}> disabled <{/if}> /> <span class="red">* 开户名默认和您注册的真实姓名保持一致</span></li>
	</ul>
	<ul class="">
	  <li><label>&nbsp;</label><input type="submit" value="确定提交" ID="Submit1" class="bt"></li>
	</ul>
	
</form>

</div>

<{include file="public/foot.tpl"}>