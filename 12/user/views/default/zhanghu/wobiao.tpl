<{include file="public/head.tpl"}>

<script type="text/javascript">
	$(function(){
		//隔行换色
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
		
		//鼠标移上换色
		$(".tab").hover(
		  function(){
		    $(this).css("background","#CFDDEA");
		  },
		  function(){
		    $(".tab:even").css("background","#FFFFFF");
			$(".tab:odd").css("background","#F8F8F8");
		});
		
		$("#yin").toggle(
		  function (){
			$("#yin").attr("src","/public/images/1.gif");
			$(".xiaxian").css("display","");
			
		  },
		  function (){
			$("#yin").attr("src","/public/images/2.gif");
			$(".xiaxian").css("display","none");
		  }
		);
	
	});
</script>

<body class="bodycolor">

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="21" class="biaoti" align="left"><span style="float:left;">&nbsp;<font color="green"> <{$user.bianhao}>[<{$user.name}>] </font> 的推荐列表</span><img id='yin' style="float:left;" src="/public/images/2.gif" alt="显示" />(是否显示下线的下线) 将获得所有下线的奖金之和《<font color="red"><{$user.jiangjin}>元</font>》</td>
</tr>

<tr class="biaoti">
	<td noWrap>编号</td>
	<td noWrap width="150">姓名</td>
	<td noWrap width="120">推荐人编号</td>
	<td noWrap width="120" >推荐人关系</td>
	<td noWrap width="95" >获得下线的钱</td>
	<td noWrap width="60" >推荐</td>
    <td nowrap width="145" >添加时间</td>
    <td nowrap width="60" >状态</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab" id="dengji<{$item.id}>" >
	<td noWrap  align='left'> <font color="#3388CE"><{$item.kg}></font><{$item.bianhao}> </td>
	<td noWrap  align='left'> <{$item.name}> </td>
	<td noWrap  align='left'> <{if $item.f_bianghao!='0'}> <{$item.f_bianghao}> <{/if}> </td>
	<td noWrap  align='center'> <{$item.guanxi}> </td>
	<td noWrap  align='center'> <{$item.q}>元 </td>
	<td noWrap  align='right'> <{$item.tj_num}>人 </td>
	<td noWrap  align='left'> <{$item.add_time|date_format:"%Y-%m-%d %H:%M:%S"}> </td>
	<td noWrap  align='center'> <{if $item.status=='1'}> <font color="green">在职</font> <{elseif $item.status=='2'}> <font color="red">已离职</font> <{/if}> </td>
</tr>
<script type="text/javascript">
	var m=<{$item.m}>;
	if(m > 1){
		$("#dengji<{$item.id}>").css("display","none");
		$("#dengji<{$item.id}>").attr("class","khbox tab xiaxian");
	}
</script> 
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="14">
        	没有推荐任何人
        </td>
    </tr>
<{/if}>
<tr class="biaoti">
	<td align="left" colspan="20">
		<{$fpage_weihu}>
	</td>
</tr>
</table>

<{include file="public/foot.tpl"}>