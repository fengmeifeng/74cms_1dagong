<{include file="public/head.tpl"}>
<link rel="stylesheet" type="text/css" href="<{$res}>/css/tab.css">
<br/>
<div class="commentbdiv">
<table class="commentb" cellspacing="1" width="99%" >
  <tr class="tbhd">	
    <td width="7%">奖金来源</td>  
	<td width="5%">推荐奖</td>
    <td width="6%">总奖金</td>    
    <td width="6%">实发奖金</td>
	<td width="6%">累计金额</td>
    <td width="6%">结算时间</td>
  </tr>
  <{foreach from=$data  key='key' item='list'}>
  <tr>  
    <td><{$list.kg}><{$list.name}>[<{$list.bianhao}>]【<{$list.id}>】</td> 	
	<td><{$list.q}></td>
    <td><{$list.q}></td>   
    <td><{$list.q}></td>
	<td><{$list.lj$key}> </td>
    <td></td>
  </tr>
  <{/foreach}>
</table>
</div>

<{include file="public/foot.tpl"}>