<?php require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_pageinfo.php'); $this->register_function("qishi_pageinfo", "tpl_function_qishi_pageinfo",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-13 16:38 中国标准时间 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php echo tpl_function_qishi_pageinfo(array('set' => "列表名:page,调用:QS_login"), $this);?>
<title><?php echo $this->_vars['page']['title']; ?>
</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta name="description" content="<?php echo $this->_vars['page']['description']; ?>
">
<meta name="keywords" content="<?php echo $this->_vars['page']['keywords']; ?>
">
<link href="/files/css/common.css" rel="stylesheet" type="text/css" />
<link href="/files/css/font-awesome.min.css" rel="stylesheet" >
<link href="/files/css/reg.css" rel="stylesheet" type="text/css" />
<script src="/files/js/jquery.js" type='text/javascript' language="javascript"></script>
<script src="/files/form/formValidator-4.1.3.js" type='text/javascript' language="javascript"></script>
<script src="/files/form/formValidatorRegex.js" type='text/javascript' language="javascript"></script>

<!---->
<link href="/files/css/header.css" rel="stylesheet" type="text/css" />
<!---->
<script type="text/javascript">
$(document).ready(function()
{
//
$("#username").focus(function(){
	if ($("#username").val()=="用户名/邮箱/手机号")
	{
	$("#username").val('');
	$("#username").css("color","");
	}  
});
$("#passwordtxt").focus(function(){
	$("#passwordtxt").hide();
	$("#password").show();
	$('#password').trigger("focus");
});
//
$(".but-login").hover(function(){$(this).addClass("but-login-hover")},function(){$(this).removeClass("but-login-hover")});
//验证
$("form[id=Formlogin]").submit(function(e) {
e.preventDefault();
	if ($("#username").val()=="" || $("#username").val()=="用户名/邮箱/手机号")
	{			
		$(".login_err").html("请填写：用户名 / 邮箱 / 手机号");	
		$(".login_err").show();
	}
	else if($("#password").val()=="")
	{	
	$(".login_err").html("请填写密码！");
	$(".login_err").show();
	}
	<?php if ($this->_vars['verify_userlogin'] == "1"): ?>
	else if($("#postcaptcha").val()=="" || $("#postcaptcha").val()=="点击获取验证码")
	{	
	$(".login_err").html("请填写验证码！");
	$(".login_err").show();
	}
	<?php endif; ?>
	else
	{
		$("#reg").hide();
		$("#waiting").show();
		$("#sub").hide();
		 if($("#expire").attr("checked")==true)
		 {
		 var expire=$("#expire").val();
		 }
		 else
		 {
		 var expire="";
		 }
		$.post("/plus/ajax_user.php", {"username": $("#username").val(),"password": $("#password").val(),"expire":expire,"url":"<?php echo $_GET['url']; ?>
","postcaptcha":$("#postcaptcha").val(),"time": new Date().getTime(),"act":"do_login"},
	 	function (data,textStatus)
	 	 {
			if (data=="err" || data=="errcaptcha")
			{			
				$("#reg").show();
				$("#waiting").hide();
				$("#sub").show();
				$("#password").attr("value","");
				$(".login_err").show();	
				if (data=="err")
				{
				errinfo="帐号或者密码错误";
				}
				else if(data=="errcaptcha")
				{
				$("#imgdiv img").attr("src",$("#imgdiv img").attr("src")+"1");
				errinfo="验证码错误";
				}
				$(".login_err").html(errinfo);
			}
			else
			{
				$("body").append(data);
			}
	 	 })		
	}
	return false;
});
//========ffff
//
$("#username2").focus(function(){
	if ($("#username2").val()=="用户名/邮箱/手机号")
	{
	$("#username2").val('');
	$("#username2").css("color","");
	}  
});
$("#passwordtxt2").focus(function(){
	$("#passwordtxt2").hide();
	$("#password2").show();
	$('#password2').trigger("focus");
});
//
$(".but-login2").hover(function(){$(this).addClass("but-login-hover2")},function(){$(this).removeClass("but-login-hover2")});
//验证
$("form[id=Formlogin2]").submit(function(e) {
e.preventDefault();
	if ($("#username2").val()=="" || $("#username2").val()=="用户名/邮箱/手机号")
	{			
		$(".login_err").html("请填写：用户名 / 邮箱 / 手机号");	
		$(".login_err").show();
	}
	else if($("#password2").val()=="")
	{	
	$(".login_err").html("请填写密码！");
	$(".login_err").show();
	}
	<?php if ($this->_vars['verify_userlogin'] == "1"): ?>
	else if($("#postcaptcha2").val()=="" || $("#postcaptcha2").val()=="点击获取验证码")
	{	
	$(".login_err").html("请填写验证码！");
	$(".login_err").show();
	}
	<?php endif; ?>
	else
	{
		$("#reg").hide();
		$("#waiting2").show();
		$("#sub2").hide();
		 if($("#expire").attr("checked")==true)
		 {
		 var expire=$("#expire").val();
		 }
		 else
		 {
		 var expire="";
		 }
		$.post("/plus/ajax_user.php", {"username": $("#username2").val(),"password": $("#password2").val(),"expire":expire,"url":"<?php echo $_GET['url']; ?>
","postcaptcha":$("#postcaptcha2").val(),"time": new Date().getTime(),"act":"do_login"},
	 	function (data,textStatus)
	 	 {
			if (data=="err" || data=="errcaptcha")
			{			
				$("#reg").show();
				$("#waiting2").hide();
				$("#sub2").show();
				$("#password").attr("value","");
				$(".login_err").show();	
				if (data=="err")
				{
				errinfo="帐号或者密码错误";
				}
				else if(data=="errcaptcha")
				{
				$("#imgdiv2 img").attr("src",$("#imgdiv2 img").attr("src")+"1");
				errinfo="验证码错误";
				}
				$(".login_err").html(errinfo);
			}
			else
			{
				$("body").append(data);
			}
	 	 })		
	}
	return false;
});
//-----------ffff

//
//验证码部分
<?php if ($this->_vars['verify_userlogin'] == "1"): ?>
function imgcaptcha(inputID,imgdiv)
{
	$(inputID).focus(function(){
		if ($(inputID).val()=="点击获取验证码")
		{
		$(inputID).val("");
		$(inputID).css("color","#333333");
		}
		$(inputID).parent("div").css("position","relative");
		//设置验证码DIV
		$(imgdiv).css({ position: "absolute", right: "-34px", "top": "68px" , "z-index": "10", "background-color": "#FFFFFF", "border": "1px #A3C8DC solid","display": "none","margin-left": "15px"});
		$(imgdiv).show();
		if ($(imgdiv).html()=='')
		{
		$(imgdiv).append("<img src=\"/include/imagecaptcha.php?t=<?php echo $this->_vars['random']; ?>
\" id=\"getcode\" align=\"absmiddle\"  style=\"cursor:pointer; margin:3px;\" title=\"看不请验证码？点击更换一张\"  border=\"0\"/>");
		}
		$(imgdiv+" img").click(function()
		{
			$(imgdiv+" img").attr("src",$(imgdiv+" img").attr("src")+"1");
		});
		$(document).unbind().click(function(event)
		{
			var clickid=$(event.target).attr("id");
			if (clickid!="getcode" &&  clickid!="postcaptcha")
			{
			$(imgdiv).hide();
			$(inputID).parent("div").css("position","");
			$(document).unbind();
			}			
		});
	});
}
imgcaptcha("#postcaptcha","#imgdiv");
//验证码结束
<?php endif; ?>
//
});
</script>

<script type="text/javascript">
$(document).ready(function(){
	$.formValidator.initConfig({theme:"126",submitOnce:true,formID:"form1",
		onError:function(msg){alert(msg);},
		submitAfterAjaxPrompt : '有数据正在异步验证，请稍等...'
	});
	$("#username").formValidator({onShowFixText:"6~30个字符，包括字母、数字、下划线，以字母开头，字母或数字结尾",onShowText:"请输入用户名",onCorrect:""}).inputValidator({min:6,max:30,onError:"用户名长度不正确,请确认"}).regexValidator({regExp:"username",dataType:"enum",onError:"用户名格式不正确"});

});
</script>

</head>
<body>
<!--头部开始-->
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("user/header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<!--头部结束-->
<div class="kua">
  <div class="panel-heading">欢迎加入壹打工网</div>
        <div class="left_list height400">
        
            
                <script type="text/javascript"> 
            function setTab(name,m,n){ 
            for( var i=1;i<=n;i++){ 
            var menu = document.getElementById(name+i); 
            var showDiv = document.getElementById("cont_"+name+"_"+i); 
            menu.className = i==m ?"on":""; 
            showDiv.style.display = i==m?"block":"none"; 
            } 
            } 
            </script> 
            
            <div class="tab news"> 
                <ul> 
                    <li id="one1" class="on" onmouseover='setTab("one",1,5)'>个人会员登录</li> 
                    <li id="one2" onmouseover='setTab("one",2,5)'>企业会员登录</li> 
                </ul> 
            </div> 
            <div class="tabList"> 
                <div id="cont_one_1" class="the01 one block"> 
                    <form id="Formlogin" name="Formlogin" method="post" class="form-horizontal home-form">
					<input type="hidden" name="url" id="url" value="<?php echo $this->_vars['url']; ?>
">
    
                            <div class="form-group">
                                <h2>个人会员登录</h2>
                            </div>
                            <div class="form-group ">
                                <label class="control-label fl">手机号（会员名）：</label>
                                <div class="fl">
								<input type="text" name="username" id="username" class="form-control" value="用户名/邮箱/手机号" maxlength="30" style="color:#999999;" />
                                </div><span id="usernameTip" style="width:180px"></span><div class="login_err" style="color:#f00; font-size:14px;"></div>
								
                            </div>
    						
                            <div class="form-group">
                                <label class="control-label fl">密码：</label>
                                <div class="fl">
								<input type="text" name="passwordtxt" id="passwordtxt" class="form-control" value="密码"  maxlength="30" style="color:#999999;"/>
								<input type="password" name="password" id="password" class="form-control" value=""  maxlength="30" style="display:none"/>
                                    <br/><br/>
                                    <p class="form-control-static">首次登录，默认密码为您手机号码的后四位。</p>
                                    <p class="form-control-static"><a href="/user/user_getpass.php">忘记密码？点击找回</a></p>
                                </div>
                            </div>
                            <!--登陆之后提示-->
							<div class="form-group" id="waiting" style="display:none;">
                                <label class="control-label fl">&nbsp;</label>
                                <div class="fl">
                                    <input type="submit" name="submitlogin" style="background:#999; color:#FFF;" id="login" value="正在登录中..." class="btn" />
                                </div>
							</div>
                            <!--登陆之前提示-->
                            <div class="form-group" id="sub">
                                <label class="control-label fl">&nbsp;</label>
                                <div class="fl">
                                    <input type="submit" name="submitlogin" id="login" value="点击登录" class="btn" />
                                </div>
                            </div>
    						<?php if ($this->_vars['verify_userlogin'] == "1"): ?>
							<div class="postcaptcha">
							<div id="imgdiv"></div>
							<input  class="txtinput" name="postcaptcha" id="postcaptcha" type="text" value="点击获取验证码" style="color:#999999;"/>
							</div>
							<?php endif; ?>
                        </form>
                </div> 
                <div id="cont_one_2" class="the01 the02 one"> 
    				<form id="Formlogin2" name="Formlogin" method="post" class="form-horizontal home-form">
					<input type="hidden" name="url" id="url2" value="<?php echo $this->_vars['url']; ?>
">
                            <div class="form-group">
                                <h2>企业会员登录</h2>
                            </div>
    
    
                            <div class="form-group">
                                <label class="control-label fl">用户名（会员名）：</label>
                                <div class="fl">
								<input type="text" name="username" id="username2" class="form-control" value="用户名/邮箱/手机号" maxlength="30" style="color:#999999;" />
                                </div><div class="login_err" style="color:#f00; font-size:14px;"></div>
                            </div>
    
                            <div class="form-group">
                                <label class="control-label fl">密码：</label>
                                <div class="fl">
                                <input type="text" name="passwordtxt" id="passwordtxt2" class="form-control" value="密码"  maxlength="30" style="color:#999999;"/>
								<input type="password" name="password" id="password2" class="form-control" value=""  maxlength="30" style="display:none"/>							
                                    <br/><br/>
                                   <p class="form-control-static"><a href="/user/user_getpass_c.php">忘记密码？点击找回</a></p>
    
                                </div>
                            </div>
    						<!--登陆之后-->
                            <div class="form-group" id="waiting2" style="display:none;">
                                <label class="control-label fl">&nbsp;</label>
                                <div class="fl">
                                    <input type="submit" name="submitlogin" style="background:#999; color:#FFF;" id="login" value="正在登录中..." class="btn" />
                                </div>
							</div>
                            <!--登陆之前-->
                            <div class="form-group" id='sub2'>
                                <label class="control-label fl">&nbsp;</label>
                                <div class="fl">
                                     <input type="submit" name="submitlogin" id="login2" value="点击登录" class="btn" />
                                </div>
                            </div>
    
                            
                        </form>
                </div> 
            </div> 
                        
				<!--<div class="input-box-waiting" id="waiting">
					正在登录中...
				</div>-->
        </div>





        <div class="right_list">
                
                <div class="h_anniu">
                <p>您还不是会员？请点击注册：</p>
                <a href="/user/user_reg.php" class="btn-success">个人 / 企业注册入口</a>
				 <p>您还不是培训会员？请注册：</p>
                <a href="/user/user_reg.php?member_type=4" class="btn-success">培训注册入口</a>
                </div>

                <div class="h_tishi">
                    <p>全国免费服务热线：</p>
                    <a href="tel:400-118-5188">400-118-5188</a>
                </div>

        </div>

</div>
<!--底部开始-->
   <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("user/footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<!--底部结束-->

</body>
</html>