<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit" />
<title><?php echo (C("WEB_SITE_TITLE")); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script src="/renhe/crm/Public/BJUI/js/jquery-1.7.2.min.js"></script>
<script src="/renhe/crm/Public/BJUI/js/jquery.cookie.js"></script>
<script src="/renhe/crm/Public/js/sha256.js"></script>
<link href="/renhe/crm/Public/BJUI/themes/css/bootstrap.min.css" rel="stylesheet">
<link href="/renhe/crm/Public/images/favicon.ico" rel="shortcut icon" />
<script src="/renhe/crm/Public/BJUI/home/js/common.js"></script>
<style type="text/css">
* {font-family: "Verdana", "Tahoma", "Lucida Grande", "Microsoft YaHei", "Hiragino Sans GB", sans-serif;}
body {
    background: url(/renhe/crm/Public/images/loginbg/loginbg_01.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	color:#555;
}
a:link {color: #285e8e;}
.main_box {
    position: absolute; top:50%; left:50%; margin-top:-182px; margin-left: -182px; padding: 20px; width:364px; height:364px;
    background: #FAFAFA; background: rgba(255,255,255,0.5); border: 1px #DDD solid;
    border-radius: 5px;
    -webkit-box-shadow: 1px 5px 8px #888888; -moz-box-shadow: 1px 5px 8px #888888; box-shadow: 1px 5px 8px #888888;
}
.main_box .setting {position: absolute; top: 5px; right: 10px; width: 10px; height: 10px;}
.main_box .setting a {color: #FF6600;}
.main_box .setting a:hover {color: #555;}
.login_logo {margin-bottom: 10px; height: 45px; text-align: center;}
.login_logo img {height: 45px;}
.login_msg {text-align: center; font-size: 14px;}
.login_form {padding-top: 10px; font-size: 14px;}
.login_box .form-control {display: inline-block; *display: inline; zoom: 1; width: auto; font-size: 14px;}
.login_box .form-control.x200 {width: 200px;}
.login_box .form-control.x90 {width: 90px;}
.x104 {width: 104px;}
.login_box .form-group {margin-bottom: 15px;}
.login_box .form-group label.t {width: 100px; text-align: right; cursor: pointer;}
.login_box .form-group label.t1 {width: 45px; text-align: right; cursor: pointer;}
.login_box .form-group.space {padding-top: 15px; border-top: 1px #FFF dotted;}
.login_box .form-group img {margin-top: 1px; height: 32px; vertical-align: top;}
.login_box .form-group label.m {text-align: right; cursor: pointer; font-weight:normal; float:right; padding-right:48px;}
.botton {text-align: center; font-size: 14px; width:260px;}
.bottom {text-align: center; font-size: 14px;}

.whatAutologinTip{z-index:9; width:140px; height:35px;background-color:#FFEBEB; border:1px #F9B4B4 solid;text-align:left; padding:2px 5px 2px 5px;line-height:14px; color:#D90000;display:none; font-size:12px; font-weight:normal;}
#Tipchklogin{position:absolute;right:52px; width:180px;}
.unishadow{box-shadow:0px 1px 3px 0 rgba(0,0,0,0.8);-webkit-box-shadow:0px 1px 3px 0 rgba(0,0,0,0.8);-moz-box-shadow:0px 1px 3px 0 rgba(0,0,0,0.8);}
.none { display: none; }

@media only screen and (max-width:364px){
.main_box {
    position: absolute; top:50%; left:50%; margin-top:-172px; margin-left: -150px; padding: 10px 10px 10px 10px; width:300px; height:344px;
    background: #FAFAFA; background: rgba(255,255,255,0.5); border: 1px #DDD solid;
    border-radius: 5px;
    -webkit-box-shadow: 1px 5px 8px #888888; -moz-box-shadow: 1px 5px 8px #888888; box-shadow: 1px 5px 8px #888888;
}
.login_box .form-group label.t {width: 80px; text-align: right; cursor: pointer;}
.login_box .form-group label.t1 {width: 25px; text-align: right; cursor: pointer;}
.login_box .form-group label.m {text-align: right; cursor: pointer; font-weight:normal; float:right; padding-right:24px;}

#Tipchklogin{position:absolute;right:18px; width:180px;}
}
</style>
<script type="text/javascript">
var COOKIE_NAME = 'sys__username';
$(function() {
    choose_bg();
	//login_onclick();
	//changeCode();
	if ($.cookie(COOKIE_NAME)){
	    $("#j_username").val($.cookie(COOKIE_NAME));
	    $("#j_password").focus();
	    $("#j_remember").attr('checked', true);
	} else {
		$("#j_username").focus();
	}
	/*$("#captcha_img").click(function(){
		changeCode();
	});*/
	$("#login_form").submit(function(){
		var issubmit = true;
		var i_index  = 0;
		$(this).find('.in').each(function(i){
			if ($.trim($(this).val()).length == 0) {
				$(this).css('border', '1px #ff0000 solid');
				issubmit = false;
				if (i_index == 0)
					i_index  = i;
			}
		});
		if (!issubmit) {
			$(this).find('.in').eq(i_index).focus();
			return false;
		}
		var $remember = $("#j_remember");
		if ($remember.attr('checked')) {
			$.cookie(COOKIE_NAME, $("#j_username").val(), { path: '/', expires: 15 });
		} else {
			$.cookie(COOKIE_NAME, null, { path: '/' });  //删除cookie
		}
		$("#login_ok").attr("disabled", true).val('登陆中..');
		//var password = HMAC_SHA256_MAC($("#j_username").val(), $("#j_password").val());
		//$("#j_password").val(HMAC_SHA256_MAC($("#j_randomKey").val(), password));
        return true;
	});
});
function genTimestamp(){
	var time = new Date();
	return time.getTime();
}
function changeCode(){
	//$("#captcha_img").attr("src", "/captcha.jpeg?t="+genTimestamp());
}
function choose_bg() {
	var bg = Math.floor(Math.random() * 9 + 1);
	$('body').css('background-image', 'url(/renhe/crm/Public/images/loginbg/loginbg_0'+ bg +'.jpg)');
}
//显示隐藏层
function showdiv(targetid, objN) {var target = document.getElementById(targetid);var clicktext = document.getElementById(objN);target.style.display = "block";}
//隐藏显示层
function hidediv(targetid, objN) {var target = document.getElementById(targetid);var clicktext = document.getElementById(objN); target.style.display = "none";}
document.getElementById("j_username").focus();
</script>
</head>
<body>
<!--[if lte IE 7]>
<style type="text/css">
#errorie {position: fixed; top: 0; z-index: 100000; background: #FCF8E3;}
#errorie div {width: 100%; margin: 0 auto; line-height: 30px; color: orange; font-size: 12px; text-align: center;}
#errorie div a {color: #459f79;font-size: 12px;}
#errorie div a:hover {text-decoration: underline;}
</style>
<div id="errorie"><div>系统提示：您的浏览器版本较旧，与该系统存在某些不兼容问题，为了避免影响部分功能的性能或无法运行，推荐使用：<a class='noscriptLink' href='http://firefox.com.cn/' target='_blank'>火狐浏览器</a>，<a class='noscriptLink'href='http://www.opera.com/zh-cn/' target='_blank'>Opera浏览器</a>，<a class='noscriptLink'href='http://www.google.com/chrome/' target='_blank'>谷歌浏览器</a>，<a class='noscriptLink'href='http://www.apple.com.cn/safari/' target='_blank'>苹果浏览器</a>，<a class='noscriptLink'href='http://ie.sogou.com/' target='_blank'>搜狗</a>/<a class='noscriptLink'href='http://www.maxthon.cn/' target='_blank'>傲游</a>等双核浏览器的最新版本</div></div>
<![endif]-->

<div class="main_box">
    <div class="setting"><a href="javascript:;" onclick="choose_bg();" title="更换背景"><span class="glyphicon glyphicon-th-large"></span></a></div>
	<div class="login_box">
        <div class="login_logo">
            <img src="/renhe/crm/Public/images/logo.png" >
        </div>
        <!--
		<c:if test="${!empty message}">
			<div class="login_msg">
	      		<font color="red">${message }</font>
	    	</div>
	    </c:if>
        -->
        <div class="login_form">
            <input type="hidden" value="${randomKey}" id="j_randomKey" />
    		<form action="<?php echo U('Login');?>" name="frmlogin" id="login_form" method="post" class="form-horizontal">
                <input type="hidden" name="jfinal_token" id="KeyID" value="" />
    			<div class="form-group">
					<label class="t" for="j_username">用户名：</label> <input id="j_username" name="username" type="text" class="form-control x200 in" maxlength="20" autocomplete="on">
    			</div>
    			<div class="form-group">
					<label class="t" for="j_password">密　码：</label> <input id="j_password" type="password" name="password" class="form-control x200 in" maxlength="20">
    			</div>
				<?php if(!empty($is_verify_code)): ?><div class="form-group">
					<label class="t" for="verify">验证码：</label> <input class="form-control x90 in" id="verify" name="verify" maxlength="4" autocomplete="off" />
					<img class="x104" src='/renhe/crm/index.php/home/public/verify' style='cursor:pointer' title='刷新验证码' id='verifyImg' onclick='freshVerify()'>
				</div><?php endif; ?>
    			<div class="form-group">
                    <label class="t" for="l">版　本：</label> <select name="l"><?php echo ($language); ?></select>
                    <label for="j_remember" class="m" onmouseover="showdiv('Tipchklogin','lfAutoLogin');" onmouseout="hidediv('Tipchklogin','lfAutoLogin');">自动登录&nbsp;<input class="ace" type="checkbox" id="j_remember" name="remember" value="true" /><span style="display: none;" id="Tipchklogin" class="none unishadow whatAutologinTip">为了您的信息安全，请不要在网吧或公用电脑上使用此功能！</span></label>
    			</div>
    			<div class="form-group">
                    <label class="t1"></label><input id="login_ok" type="submit" value="登&nbsp;录" class="btn btn-sm btn-primary col-10 botton" /><!--&nbsp;&nbsp;&nbsp;&nbsp;
    				<input type="reset" value="&nbsp;重&nbsp;置&nbsp;" class="btn btn-default btn-lg">-->
    			</div>
    		</form>
        </div>
	</div>
	<div class="bottom">Copyright &copy; <a href="http://www.zhelininternet.com" target="_blank"><?php echo (C("WEB_SITE_TITLE")); ?></a></div>
</div>
</body>
</html>