<{include file="public/head.tpl"}>
<link rel="stylesheet" type="text/css" href="<{$res}>/css/zTreeStyle/zTreeStyle.css">
<script type="text/javascript" src="<{$res}>/js/jquery.ztree-3.5.js"></script>

<style type="text/css">
	p{
		padding: 25px;;
	}
	.content_wrap {
		height: 100%;
		margin: 0;
		padding: 0;
		text-align: center;
		overflow-y: auto;
		overflow-x: hidden;
	}
	ul#treeDemo {
	
	}
</style>

<div class="bodycolor">
	<br/>
	<div class="yh_bj">
		<div class="content_wrap">
			<ul id="treeDemo" class="ztree"></ul>
		</div>
	</div>
	
	
	<{if $dat==1}>
		<p>没有找到你推荐的会员</p>	
	<{/if}>
	<br>
	<br>
	<br>

</div>
<{include file="public/foot.tpl"}>