<{include file="public/head.tpl"}>
<link rel="stylesheet" type="text/css" href="<{$res}>/css/yhqx.css">
<link rel="stylesheet" type="text/css" href="<{$res}>/css/zTreeStyle/zTreeStyle.css">
<script type="text/javascript" src="<{$public}>/js/jquery.js"></script>
<script type="text/javascript" src="<{$res}>/js/jquery.ztree-3.5.js"></script>

<style type="text/css">
	body{
		background:#eee;
	}
	.content_wrap {
		height: 100%;
		margin: 0;
		padding: 0;
		text-align: center;
		overflow-y: scroll;
		overflow-x: hidden;
		
	}
	ul#treeDemo {
		width: 210px;
		height: 100%;
	}
</style>

<div class="content_wrap">
	<ul id="treeDemo" class="ztree"></ul>
</div>

<{include file="public/foot.tpl"}>