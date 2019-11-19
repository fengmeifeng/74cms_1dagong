<div class="tx_box">
<link rel="stylesheet" type="text/css" href="<{$res}>/css/xiaoxi.css">
<!--******************-->
<div class="float_layer" id="miaov_float_layer">
    <h2>
        <strong>消息提醒</strong>
        <a id="btn_min" href="javascript:;" class="min"></a>
        <a href="javascript:;"><span id="btn_close" onclick="gbt();" class="close"></span></a>
    </h2>
    <div class="content" id="con" style="padding-top:0px; height:150px; ">
    	<div class="wrap">
        	
			<table>
				<tr>
					<td align='right' >联系人编号：</td>
					<td><{$xx.bianhao}></td>
				</tr>
				<tr>
					<td align='right' >联系人姓名：</td>
					<td><{$xx.name}> </td>
				</tr>
				<tr>
					<td align='right' >联系人手机号：</td>
					<td><{$xx.sphone}> <span onclick="ydzt('<{$xx.id}>','<{$app}>/index/gxtx');" ><a href="#">已读</a> </span></td>
				</tr>
			</table>
			<p style="margin:3px;" > <b>联系内容：</b> <{$xx.nextneirong}> </p>
		</div>
     </div>
</div>
<!--******************-->
</div>