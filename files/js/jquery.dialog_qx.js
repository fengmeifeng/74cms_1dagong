var dialogFirst=true;
function dialog(title,content,width,height,cssName,displayClose)
{
	if (width=='')
	{
		width="150px"
	}
	if (height=='')
	{
		height="auto"
	}
if(dialogFirst==true){
  var temp_float=new String;
  temp_float="<div class=\"FloatBg\"  style=\"height:"+$(document).height()+"px;width:"+$(document).width()+"px; background-color:#000000; background:#f00\9; filter:alpha(opacity=50); opacity:0.3\"></div>";
  temp_float+="<div class=\"FloatBox\">";
  temp_float+="<div class=\"Box\">";
  temp_float+="<div class=\"title\"><h4></h4><span class=\"DialogClose\" title=\"关闭\" id=\"DialogClose\"></span></div>";
  temp_float+="<div class=\"content link_lan\" style=\" padding-top:10px;\"><div class=\"loading\"></div></div>";
  temp_float+="</div></div>";
  //temp_float+="<div class=\"personal_infor\"><div class=\"write_pinfor\" style=\"display:block\"><form method=\"post\" action=\"\" id=\"Form1\" name=\"Form1\"> <ul><li><span>姓名：</span><input class=\"text_infor\" name=\"name\" id=\"name\" type=\"text\"><span>性别：</span><input name=\"sex\" value=\"1\" id=\"sex\" type=\"radio\">男&nbsp;<input name=\"sex\" id=\"sex\" value=\"0\" type=\"radio\">女</li><li><span>身高：</span><input class=\"text_infor\" name=\"height\" id=\"height\" type=\"text\"><span>体重：</span><input class=\"text_infor\" name=\"weight\" type=\"text\">&nbsp;kg</li><li><span>工号部门：</span><input class=\"text_infor\" name=\"depratment\" id=\"depratment\" type=\"text\"><span>联系方式：</span><input class=\"text_infor\" name=\"phone\" id=\"phone\" type=\"text\"></li><li><span>出生年月：</span><input class=\"text_infor\" name=\"brithday\" id=\"brithday\" type=\"text\"><span>籍贯：</span><input class=\"text_infor\" name=\"home\" id=\"home\" type=\"text\"></li><li><span>兴趣爱好：</span><textarea name=\"hobby\" id=\"hobby\"></textarea></li><li><span>择偶标准：</span><textarea name=\"selected\" id=\"selected\"></textarea></li><li class=\"submit_center Fright\"><input value=\"确认提交\" class=\"submit_xinxi\" type=\"button\"></li><li><p>*为了活动的顺利进行，请填写真实的个人资料。一旦通过活动组审核，我们将与您联系。</p></li></ul></form></div><div class=\"submit_success pd\"><h2><i class=\"fa fa-smile-o\"></i>报名成功！感谢您的参与！！！</h2></div><div class=\"close personal_close\"><a href=\"javascript:void();\" id=\"close\" title=\"\" onclick=\"hide('pop')\" class=\"close_btn\"></a></div></div>";
  $("body").append(temp_float);
  $(".FloatBox").css("width","100px");
  dialogFirst=true;
}
$('.DialogClose').live('click', function() {
	$(".FloatBg").remove();
	$(".FloatBox").remove();
});
$(".FloatBox .title h4").html(title);
contentType=content.substring(0,content.indexOf(":"));
content=content.substring(content.indexOf(":")+1,content.length);
switch(contentType){
  case "url":
  $.get(content, function(data){
   $(".FloatBox .content").html(data);
	});
  break;
  case "text":
  $(".FloatBox .content").html('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall"><tr><td width="20" align="right"></td><td>'+content+'</td></tr></table>');
  break;
  case "id":
  $(".FloatBox .content").html($("#"+content+"").html());
  break;
  case "iframe":
  $(".FloatBox .content").html("<iframe src=\""+content+"\" width=\"100%\" height=\""+(parseInt(height)-30)+"px"+"\" scrolling=\"auto\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\"></iframe>");
}

$(".FloatBg").show();
if (cssName)
{
	$(".FloatBox").addClass(cssName);
}
if (displayClose)
{
	$(".FloatBox #DialogClose").css("display","none");
}
$(".FloatBox").css({display:"block",left:(($(document).width())/2-(parseInt(width)/2))+"px",top:($(document).scrollTop()+180)+"px",width:width,height:height});
//$(".FloatBox").css({display:"block",left:(($(document).width())/2-(parseInt(width)/2))+"px",top:"260px",width:width,height:height});
$(".FloatBox .title .DialogClose").hover(function(){$(this).addClass("spanhover")},function(){$(this).removeClass("spanhover")});
}


function alert_dialog(content,width,height,cssName,displayClose)
{
  if (width=='')
  {
    width="150px"
  }
  if (height=='')
  {
    height="auto"
  }
if(dialogFirst==true){
  var temp_float=new String;
  temp_float="<div class=\"AlertFloatBg\"  style=\"height:"+$(document).height()+"px;width:"+$(document).width()+"px; background-color:rgba(212,0,0,0.5); background:#f00\9; filter:alpha(opacity=50); opacity:0;\"></div>";
  temp_float+="<div class=\"AlertFloatBox\">";
  temp_float+="</div></div>";
  $("body").append(temp_float);
  $(".AlertFloatBox").css("width","117px");
  dialogFirst=true;
}
$('.AlertFloatBg').live('click', function() {
  $(".AlertFloatBg").remove();
  $(".AlertFloatBox").remove();
});
var seconds = 3;
window.setInterval(redirection, 1000);
function redirection()
{
  if (seconds <= 0)
  {
    window.clearInterval();
    return;
  }

  seconds --;

  if (seconds == 0)
  {
    window.clearInterval();
    $(".AlertFloatBg").remove();
    $(".AlertFloatBox").remove();
  }
}

contentType=content.substring(0,content.indexOf(":"));
content=content.substring(content.indexOf(":")+1,content.length);
switch(contentType){
  case "success":
  $(".AlertFloatBox").html('<div class="save_success"><div class="save_txt">'+content+'</div></div>');
  break;
  case "fail":
  $(".AlertFloatBox").html('<div class="save_fail"><div class="save_txt">'+content+'</div></div>');
  break;
}

$(".AlertFloatBg").show().css("opacity", 0);
if (cssName)
{
  $(".AlertFloatBox").addClass(cssName);
}
if (displayClose)
{
  $(".AlertFloatBox #DialogClose").css("display","none");
}
$(".AlertFloatBox").css({display:"block",left:(($(document).width())/2-(parseInt(width)/2))+"px",top:(($(window).height() - $('.refresh_resume').outerHeight())/2 + $(document).scrollTop())+"px",width:width,height:height});
//$(".AlertFloatBox").css({display:"block",left:(($(document).width())/2-(parseInt(width)/2))+"px",top:($(window).height())+"px",width:width,height:height});
// $(".FloatBox .title .DialogClose").hover(function(){$(this).addClass("spanhover")},function(){$(this).removeClass("spanhover")});
}