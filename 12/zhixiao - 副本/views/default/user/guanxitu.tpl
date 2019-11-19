<{include file="public/head.tpl"}>
<link rel="stylesheet" type="text/css" href="<{$res}>/css/zTreeStyle/zTreeStyle.css">
<script type="text/javascript" src="<{$res}>/js/jquery.ztree-3.5.js"></script>

<style type="text/css">
	.content_wrap {
		height: 100%;
		margin: 0;
		padding: 0;
		text-align: center;
		overflow-y: auto;
		overflow-x: hidden;
	}
	ul#treeDemo{
	
	}
</style>

<div class="bodycolor">
	<br />
	<form action="<{$url}>/guanxitu" method="get">
		<select name="search" class="SmallSelect">
			<option value="name">姓名</option>
			<option value="bianhao">编号</option>
		</select>
		<input type="text" class="SmallInput" name="findvalue">
		<input type="submit" value=" 查找 " class="sub">
	</form>
	<br />
	
	<div class="yh_bj">
		<div class="content_wrap">
			<ul id="treeDemo" class="ztree"></ul>
		</div>
	</div>
</div>


<{include file="public/foot.tpl"}>