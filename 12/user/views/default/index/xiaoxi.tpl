<div class="tx_box">
<link rel="stylesheet" type="text/css" href="<{$res}>/css/xiaoxi.css">
<!--******************-->
<div class="float_layer" id="miaov_float_layer">
    <h2>
        <strong>客户联系提醒</strong>
        <a id="btn_min" href="javascript:;" class="min"></a>
        <a href="javascript:;"><span id="btn_close" onclick="gbt();" class="close"></span></a>
    </h2>
    <div class="content" id="con">
    	<div class="wrap">
        	<b><{$xx.msgtype}>: </b><a href="<{$app}>/xiaoshou/ckgz/id/<{$xx.guanlianid}>" ><{$xx.content}></a>
			<p><{$xx.attime}> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="javascript:;"><span onclick="ydzt('<{$xx.id}>','<{$app}>/index/gxtx');" >标记为已读</span></a></p>
        </div>
     </div>
</div>
<!--******************-->
</div>