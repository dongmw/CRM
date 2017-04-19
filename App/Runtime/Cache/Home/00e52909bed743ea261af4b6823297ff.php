<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="<?php echo (cookie('think_language')); ?>">
<head>
<meta charset="utf-8">
<!--<meta name="renderer" content="webkit" />-->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo L('_INDEX_TITLE_');?></title>
<meta name="Keywords" content="<?php echo L('_INDEX_Keywords_');?>"/>
<meta name="Description" content="<?php echo L('_INDEX_Description_');?>"/> 
<!-- shortcut icon -->
<link rel="shortcut icon" href="/renhe/crm/Public/images/favicon.ico" />
<!-- bootstrap - css -->
<link href="/renhe/crm/Public/BJUI/themes/css/bootstrap.css" rel="stylesheet">
<!-- core - css -->
<link href="/renhe/crm/Public/BJUI/themes/css/style.css?v=201507130926" rel="stylesheet">
<link href="/renhe/crm/Public/BJUI/themes/green/core.css" id="bjui-link-theme" rel="stylesheet">
<!-- plug - css -->
<link href="/renhe/crm/Public/BJUI/plugins/kindeditor_4.1.10/themes/default/default.css" rel="stylesheet">
<link href="/renhe/crm/Public/BJUI/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="/renhe/crm/Public/BJUI/plugins/niceValidator/jquery.validator.css" rel="stylesheet">
<link href="/renhe/crm/Public/BJUI/plugins/bootstrapSelect/bootstrap-select.css" rel="stylesheet">
<link href="/renhe/crm/Public/BJUI/themes/css/FA/css/font-awesome.min.css?v=201506192237" rel="stylesheet">
<!--[if lte IE 7]>
<link href="/renhe/crm/Public/BJUI/themes/css/ie7.css" rel="stylesheet">
<![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lte IE 9]>
    <script src="/renhe/crm/Public/BJUI/other/html5shiv.min.js"></script>
    <script src="/renhe/crm/Public/BJUI/other/respond.min.js"></script>
<![endif]-->
<!-- jquery -->
<script src="/renhe/crm/Public/BJUI/js/jquery-1.7.2.min.js"></script>
<script src="/renhe/crm/Public/BJUI/js/jquery.cookie.js"></script>
<!--[if lte IE 9]>
<script src="/renhe/crm/Public/BJUI/other/jquery.iframe-transport.js"></script>    
<![endif]-->
<!-- BJUI.all 分模块压缩版 -->
<script src="/renhe/crm/Public/BJUI/js/bjui-regional.<?php echo (cookie('think_language')); ?>.js"></script>
<script src="/renhe/crm/Public/BJUI/js/bjui-all.js?t=201505311439"></script>
<script src="/renhe/crm/Public/BJUI/js/main.js?t=201505301843"></script>
<!-- 以下是B-JUI的分模块未压缩版，建议开发调试阶段使用下面的版本 -->
<!--
<script src="BJUI/js/bjui-core.js"></script>
<script src="BJUI/js/bjui-frag.js"></script>
<script src="BJUI/js/bjui-extends.js"></script>
<script src="BJUI/js/bjui-basedrag.js"></script>
<script src="BJUI/js/bjui-slidebar.js"></script>
<script src="BJUI/js/bjui-contextmenu.js"></script>
<script src="BJUI/js/bjui-navtab.js"></script>
<script src="BJUI/js/bjui-dialog.js"></script>
<script src="BJUI/js/bjui-taskbar.js"></script>
<script src="BJUI/js/bjui-ajax.js"></script>
<script src="BJUI/js/bjui-alertmsg.js"></script>
<script src="BJUI/js/bjui-pagination.js"></script>
<script src="BJUI/js/bjui-util.date.js"></script>
<script src="BJUI/js/bjui-datepicker.js"></script>
<script src="BJUI/js/bjui-ajaxtab.js"></script>
<script src="BJUI/js/bjui-datagrid.js"></script>
<script src="BJUI/js/bjui-tablefixed.js"></script>
<script src="BJUI/js/bjui-tabledit.js"></script>
<script src="BJUI/js/bjui-spinner.js"></script>
<script src="BJUI/js/bjui-lookup.js"></script>
<script src="BJUI/js/bjui-tags.js"></script>
<script src="BJUI/js/bjui-upload.js"></script>
<script src="BJUI/js/bjui-theme.js"></script>
<script src="BJUI/js/bjui-initui.js"></script>
<script src="BJUI/js/bjui-plugins.js"></script>
-->
<!-- plugins -->
<!-- swfupload for uploadify && kindeditor -->
<script src="/renhe/crm/Public/BJUI/plugins/swfupload/swfupload.js"></script>
<!-- kindeditor -->
<script src="/renhe/crm/Public/BJUI/plugins/kindeditor_4.1.10/kindeditor-all.min.js?v=201506231958"></script>
<script src="/renhe/crm/Public/BJUI/plugins/kindeditor_4.1.10/lang/<?php echo (cookie('think_language')); ?>.js"></script>
<!-- colorpicker -->
<script src="/renhe/crm/Public/BJUI/plugins/colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- ztree -->
<script src="/renhe/crm/Public/BJUI/plugins/ztree/jquery.ztree.all-3.5.js"></script>
<!-- nice validate -->
<script src="/renhe/crm/Public/BJUI/plugins/niceValidator/jquery.validator.js"></script>
<script src="/renhe/crm/Public/BJUI/plugins/niceValidator/jquery.validator.themes.js"></script>
<!-- bootstrap plugins -->
<script src="/renhe/crm/Public/BJUI/plugins/bootstrap.min.js"></script>
<script src="/renhe/crm/Public/BJUI/plugins/bootstrapSelect/bootstrap-select.min.js"></script>
<script src="/renhe/crm/Public/BJUI/plugins/bootstrapSelect/defaults-<?php echo (cookie('think_language')); ?>.min.js"></script>
<!-- icheck -->
<script src="/renhe/crm/Public/BJUI/plugins/icheck/icheck.min.js"></script>
<!-- dragsort -->
<script src="/renhe/crm/Public/BJUI/plugins/dragsort/jquery.dragsort-0.5.1.min.js"></script>
<!-- HighCharts -->
<script src="/renhe/crm/Public/BJUI/plugins/highcharts/highcharts.js"></script>
<script src="/renhe/crm/Public/BJUI/plugins/highcharts/highcharts-3d.js"></script>
<script src="/renhe/crm/Public/BJUI/plugins/highcharts/themes/gray.js"></script>
<!-- ECharts -->
<script src="/renhe/crm/Public/BJUI/plugins/echarts/echarts.js"></script>
<!-- other plugins -->
<script src="/renhe/crm/Public/BJUI/plugins/other/jquery.autosize.js"></script>
<link href="/renhe/crm/Public/BJUI/plugins/uploadify/css/uploadify.css" rel="stylesheet">
<script src="/renhe/crm/Public/BJUI/plugins/uploadify/scripts/jquery.uploadify.min.js"></script>
<!-- init -->
<script type="text/javascript">
$(function() {
    BJUI.init({
        JSPATH       : '/renhe/crm/Public/BJUI/',         //[可选]框架路径
        PLUGINPATH   : '/renhe/crm/Public/BJUI/plugins/', //[可选]插件路径
        loginInfo    : {url:'<?php echo U('Public/login');?>', title:'<?php echo L("_INDEX_Login_");?>', width:400, height:200}, // 会话超时后弹出登录对话框
        statusCode   : {ok:200, error:300, timeout:301}, //[可选]
        ajaxTimeout  : 50000, //[可选]全局Ajax请求超时时间(毫秒)
        pageInfo     : {pageCurrent:'pageCurrent', pageSize:'pageSize', orderField:'orderField', orderDirection:'orderDirection'}, //[可选]分页参数
        alertMsg     : {displayPosition:'topcenter', displayMode:'slide', alertTimeout:3000}, //[可选]信息提示的显示位置，显隐方式，及[info/correct]方式时自动关闭延时(毫秒)
        keys         : {statusCode:'statusCode', message:'message'}, //[可选]
        ui           : {
                         showSlidebar     : <?php if ($Rs['navigation'] == 1) { echo 'true';} else { echo 'false';} ?>, //[可选]左侧导航栏锁定/隐藏
                         clientPaging     : true, //[可选]是否在客户端响应分页及排序参数
                         overwriteHomeTab : false //[可选]当打开一个未定义id的navtab时，是否可以覆盖主navtab(我的主页)
                       },
        debug        : true,    // [可选]调试模式 [true|false，默认false]
        theme        : 'blue' // 若有Cookie['bjui_theme'],优先选择Cookie['bjui_theme']。皮肤[五种皮肤:default, orange, purple, blue, red, green]
    })

    // main - menu
    $('#bjui-accordionmenu')
        .collapse()
        .on('hidden.bs.collapse', function(e) {
            $(this).find('> .panel > .panel-heading').each(function() {
                var $heading = $(this), $a = $heading.find('> h4 > a')
                
                if ($a.hasClass('collapsed')) $heading.removeClass('active')
            })
        })
        .on('shown.bs.collapse', function (e) {
            $(this).find('> .panel > .panel-heading').each(function() {
                var $heading = $(this), $a = $heading.find('> h4 > a')
                
                if (!$a.hasClass('collapsed')) $heading.addClass('active')
            })
        })
    
    $(document).on('click', 'ul.menu-items > li > a', function(e) {
        var $a = $(this), $li = $a.parent(), options = $a.data('options').toObj()
        var onClose = function() {
            $li.removeClass('active')
        }
        var onSwitch = function() {
            $('#bjui-accordionmenu').find('ul.menu-items > li').removeClass('switch')
            $li.addClass('switch')
        }
        
        $li.addClass('active')
        if (options) {
            options.url      = $a.attr('href')
            options.onClose  = onClose
            options.onSwitch = onSwitch
            if (!options.title) options.title = $a.text()
            
            if (!options.target)
                $a.navtab(options)
            else
                $a.dialog(options)
        }
        
        e.preventDefault()
    })
    
    //时钟
    var today = new Date(), time = today.getTime()
    $('#bjui-date').html(today.formatDate('yyyy/MM/dd'))
    setInterval(function() {
        today = new Date(today.setSeconds(today.getSeconds() + 1))
        $('#bjui-clock').html(today.formatDate('HH:mm:ss'))
    }, 1000)
	
})

//2015-05-29 新增 调用在线信息
$(document).ready(function () {
	startOnline();
	setInterval("startOnline()","30000");
});

//菜单-事件
function MainMenuClick(event, treeId, treeNode) {
    event.preventDefault()
    
    if (treeNode.isParent) {
        var zTree = $.fn.zTree.getZTreeObj(treeId)
        zTree.expandNode(treeNode, !treeNode.open, false, true, true)
        return
    }
    
    if (treeNode.target && treeNode.target == 'dialog')
        $(event.target).dialog({id:treeNode.tabid, url:treeNode.url, title:treeNode.name})
    else
        $(event.target).navtab({id:treeNode.tabid, url:treeNode.url, title:treeNode.name, fresh:treeNode.fresh, external:treeNode.external})
}
</script>
</head>
<body>
    <!--[if lte IE 7]>
        <div id="errorie"><div>系统提示：您的浏览器版本较旧，与该系统存在某些不兼容问题，为了避免影响部分功能的性能或无法运行，推荐使用：<a class='noscriptLink' href='http://firefox.com.cn/' target='_blank'>火狐浏览器</a>，<a class='noscriptLink'href='http://www.opera.com/zh-cn/' target='_blank'>Opera浏览器</a>，<a class='noscriptLink'href='http://www.google.com/chrome/' target='_blank'>谷歌浏览器</a>，<a class='noscriptLink'href='http://www.apple.com.cn/safari/' target='_blank'>苹果浏览器</a>，<a class='noscriptLink'href='http://ie.sogou.com/' target='_blank'>搜狗</a>/<a class='noscriptLink'href='http://www.maxthon.cn/' target='_blank'>傲游</a>等双核浏览器的最新版本</div></div>
    <![endif]-->
<div id="bjui-window">
<header id="bjui-header">
<div class="bjui-navbar-header">
	<button type="button" class="bjui-navbar-toggle btn-default" data-toggle="collapse" data-target="#bjui-navbar-collapse"><i class="fa fa-bars"></i></button>
	<a class="bjui-navbar-logo" href="./" title="<?php echo L('_INDEX_Refresh_');?>"><img src="/renhe/crm/Public/images/logo-<?php echo (cookie('think_language')); ?>.png"></a>
</div>
<nav id="bjui-navbar-collapse">
	<ul class="bjui-navbar-right">
		<li class="datetime"><div><span id="bjui-date"></span> <span id="bjui-clock"></span></div></li>
		<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><?php echo L("_LANGUAGE_NAME_");?> <span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
				<li><a href="./?l=zh-cn">&nbsp;<span class="glyphicon glyphicon-th-large"></span> 中文(简体)&nbsp;</a></li>
				<li><a href="./?l=zh-tw">&nbsp;<span class="glyphicon glyphicon-th-large"></span> 中文(繁體)</a></li>
				<li><a href="./?l=en-us">&nbsp;<span class="glyphicon glyphicon-th-large"></span> English</a></li>
			</ul>
		</li>
		<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><?php echo ($TrueName); ?> <span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
				<li><a href="javascript:;" data-url="<?php echo U('public/changepwd');?>" data-toggle="dialog" data-id="changepwd_page" data-mask="true">&nbsp;<i class="fa fa-lock"></i> <?php echo L('_INDEX_ChangePass_');?>&nbsp;</a></li>
				<li><a href="javascript:;" data-url="<?php echo U('public/changeinfo');?>" data-toggle="dialog" data-id="changepwd_page" data-mask="true" data-width="600" data-height="350">&nbsp;<i class="fa fa-user"></i> <?php echo L('_INDEX_MyInfo_');?></a></li>
				<li><a href="javascript:;" data-url="<?php echo U('public/usersettings');?>" data-toggle="dialog" data-id="changepwd_page" data-mask="true" data-width="400" data-height="250">&nbsp;<i class="fa fa-cog"></i> <?php echo L('_INDEX_UserSettings_');?></a></li>
				<li class="divider"></li>
				<li><a href="<?php echo U('public/logout');?>" class="red">&nbsp;<i class="fa fa-signout"></i> <?php echo L('_INDEX_Logout_');?></a></li>
			</ul>
		</li>
		<li><a href="javascript:;" data-url="<?php echo U('message/index');?>" data-toggle="navtab" data-id="message/index" data-title="<?php echo L('_INDEX_MessageTitle_');?>" data-fresh="true"><?php echo L('_INDEX_Message_');?> <span class="badge" id="Message">0</span></a></li>
		<li class='tLM'><a href="javascript:;"><?php echo L('_INDEX_Mail_');?> <span class="badge" id="Mail">0</span></a></li>
		<li><a href="javascript:;" data-url="<?php echo U('public/online');?>" data-toggle="dialog" data-id="online" data-fresh="true" data-height="500" data-width="320" data-title="<?php echo L('_INDEX_OnlineChat_');?>"><?php echo L('_INDEX_Online_');?> <span class="badge" id="Online"><?php $where['update_time']=array('gt',time()-120);echo M('user')->where($where)->count(); ?></span></a></li>
		<li><a href="javascript:;" data-url="<?php echo U('public/note');?>" data-toggle="dialog" data-id="note" data-width="500" data-height="308"><?php echo L('_INDEX_Note_');?></a></li>
		<li class="dropdown"><a href="javascript:;" title="<?php echo L('_INDEX_Help_');?>" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-question-sign"></i></a>
			<ul class="dropdown-menu" role="menu">
				<li><a href="javascript:;" data-url="<?php echo U('public/versionshow');?>" data-toggle="navtab" data-id="versionshow" data-title="<?php echo L('_INDEX_Version_');?>">&nbsp;<span class="glyphicon glyphicon-info-sign"></span> <?php echo L('_INDEX_Version_');?>&nbsp;</a></li>
				<li><a href="javascript:;" data-url="<?php echo U('public/helpcenter');?>" data-toggle="navtab" data-id="helpcenter" data-title="<?php echo L('_INDEX_HelpCenter_');?>">&nbsp;<span class="glyphicon glyphicon-question-sign"></span> <?php echo L('_INDEX_HelpCenter_');?></a></li>
				<li><a href="javascript:;" data-url="<?php echo U('public/feedback');?>" data-toggle="navtab" data-id="feedback" data-title="<?php echo L('_INDEX_Feedback_');?>">&nbsp;<span class="glyphicon glyphicon-send"></span> <?php echo L('_INDEX_Feedback_');?></a></li>
			</ul>
		</li>
        <?php if(($userid) == "1"): ?><li><a href="javascript:;" data-url="<?php echo U('systemclear/clear','type=all&navTabId='.CONTROLLER_NAME);?>" data-toggle="doajax" title="<?php echo L('_INDEX_CleanCache_');?>"><i class="glyphicon glyphicon glyphicon-trash"></i></a></li><?php endif; ?>
		<li class="dropdown"><a href="javascript:;" title="<?php echo L('_INDEX_MoreStyles_');?>" class="dropdown-toggle theme blue" data-toggle="dropdown"><i class="fa fa-tree"></i></a>
		<ul class="dropdown-menu" role="menu" id="bjui-themes">
		<li class="active"><a href="javascript:;" class="theme_blue" data-toggle="theme" data-theme="blue">&nbsp;<i class="fa fa-tree"></i> <?php echo L('_INDEX_Cyanine_');?></a></li>
		<li><a href="javascript:;" class="theme_green" data-toggle="theme" data-theme="green">&nbsp;<i class="fa fa-tree"></i> <?php echo L('_INDEX_DarkGreen_');?>&nbsp;</a></li>
		<li><a href="javascript:;" class="theme_default" data-toggle="theme" data-theme="default">&nbsp;<i class="fa fa-tree"></i> <?php echo L('_INDEX_Inkiness_');?></a></li>
		<li><a href="javascript:;" class="theme_orange" data-toggle="theme" data-theme="orange">&nbsp;<i class="fa fa-tree"></i> <?php echo L('_INDEX_Chrysoidine_');?></a></li>
		<li><a href="javascript:;" class="theme_purple" data-toggle="theme" data-theme="purple">&nbsp;<i class="fa fa-tree"></i> <?php echo L('_INDEX_PurpleBlue_');?></a></li>
		<li><a href="javascript:;" class="theme_red" data-toggle="theme" data-theme="red">&nbsp;<i class="fa fa-tree"></i> <?php echo L('_INDEX_Pink_');?></a></li>
		</ul>
		</li>
	</ul>
</nav>

	<div id="bjui-hnav">
		<button type="button" class="btn-default bjui-hnav-more-left" title="<?php echo L('_INDEX_MenuLeft_');?>"><i class="fa fa-angle-double-left"></i></button>
		<div id="bjui-hnav-navbar-box">
			<ul id="bjui-hnav-navbar">
				<li class="active"><a href="javascript:;" data-toggle="slidebar"><i class="fa fa-home"></i> <?php echo L('_INDEX_HomePage_');?></a>

                    <div class="items hide" data-noinit="true">
                        <ul class="menu-items" data-faicon="fa fa-home">


<li><a href="javascript:;" data-url="<?php echo U('public/changepwd');?>" data-toggle="dialog" data-id="changepwd_page" data-mask="true"><i class="fa fa-lock"></i><?php echo L('_INDEX_ChangePass_');?></a></li>

<li><a href="javascript:;" data-url="<?php echo U('public/changeinfo');?>" data-toggle="dialog" data-id="changepwd_page" data-mask="true" data-width="600" data-height="350"><i class="fa fa-user"></i><?php echo L('_INDEX_MyInfo_');?></a></li>

<li><a href="javascript:;" data-url="<?php echo U('public/usersettings');?>" data-toggle="dialog" data-id="changepwd_page" data-mask="true" data-width="400" data-height="250"><i class="fa fa-cog"></i><?php echo L('_INDEX_UserSettings_');?></a></li>

<li><a href="javascript:;" data-url="<?php echo U('message/index');?>" data-toggle="navtab" data-id="message/index" data-title="<?php echo L('_INDEX_MessageTitle_');?>"><i class="fa fa-comment"></i><?php echo L('_INDEX_MessageTitle_');?></a></li>

<li><a href="javascript:;" data-url="<?php echo U('public/online');?>" data-toggle="dialog" data-id="online" data-fresh="true" data-width="320" data-height="500"  data-title="<?php echo L('_INDEX_OnlineChat_');?>"><i class="fa fa-comments"></i><?php echo L('_INDEX_OnlineChat_');?></a></li>

<li><a href="javascript:;" data-url="<?php echo U('public/note');?>" data-toggle="dialog" data-id="note" data-width="500" data-height="308"><i class="fa fa-tag"></i><?php echo L('_INDEX_MyNote_');?></a></li>

<li><a href="<?php echo U('public/logout');?>" class="red"><i class="fa fa-signout"></i><?php echo L('_INDEX_Logout_');?></a></li>

                            
						</ul>
					</div>
				</li>

<!--导航菜单 开始-->
<?php ?>
<?php $cate=M('menu')->where('level=0 and status=1')->order('sort')->select(); ?>
<?php if(is_array($cate)): foreach($cate as $key=>$c): if(authcheck('Home/'.$c['alink'],session('uid'))): ?><li><a data-toggle="slidebar" href="javascript:;" ><i class="<?php echo ($c["icon"]); ?> bigger-100"></i> <?php echo ($c["$catename"]); ?></a>
	<div class="items hide" data-noinit="true">
	<ul id="bjui-hnav-tree<?php echo ($c["id"]); ?>" class="ztree ztree_main" data-toggle="ztree" data-on-click="MainMenuClick" data-expand-all="<?php if ($Rs['navigation1'] == 1) { echo 'true';} else { echo 'false';} ?>" data-noinit="true" data-faicon="<?php echo ($c["icon"]); ?> bigger-100">
	<?php ?>
    <?php $cate1=M('menu')->where('level=1 and status=1 and pid='.$c['id'])->order('sort')->select(); ?>
	<?php if(is_array($cate1)): foreach($cate1 as $key=>$v): if(authcheck('Home/'.$v['alink'],session('uid'))): ?>
            <?php $count2=M('menu')->where('level=2 and status=1 and pid='.$v['id'])->count(id); ?>
            <?php if($count2 == 0 ): ?><li data-id="<?php echo ($v["id"]); ?>" data-pid="<?php echo ($c["id"]); ?>" data-url="index.php/home/<?php echo ($v["alink"]); ?>" data-tabid="<?php echo ($v["alink"]); ?>" data-fresh="true" data-faicon="<?php if(!empty($v['icon'])){echo $v['icon'];}else{echo 'caret-right';} ?>"><?php echo ($v["$catename"]); ?></li>
            <?php else: ?>
                <li data-id="<?php echo ($v["id"]); ?>" data-pid="<?php echo ($c["id"]); ?>"><?php echo ($v["$catename"]); ?></li>
                <?php $cate2=M('menu')->where('level=2 and status=1 and pid='.$v['id'])->order('sort')->select(); ?>
                <?php if(is_array($cate2)): foreach($cate2 as $key=>$vv): if(authcheck('Home/'.$vv['alink'],session('uid'))): ?>
                        <?php $count3=M('menu')->where('level=3 and status=1 and pid='.$vv['id'])->count(id); ?>
                        <?php if($count3 == 0 ): ?><li data-id="<?php echo ($vv["id"]); ?>" data-pid="<?php echo ($v["id"]); ?>" data-url="index.php/home/<?php echo ($vv["alink"]); ?>" data-tabid="<?php echo ($vv["alink"]); ?>" data-fresh="true" data-faicon="<?php if(!empty($vv['icon'])){echo $vv['icon'];}else{echo 'caret-right';} ?>"><?php echo ($vv["$catename"]); ?></li>
                        <?php else: ?>
                            <li data-id="<?php echo ($vv["id"]); ?>" data-pid="<?php echo ($v["id"]); ?>"><?php echo ($vv["$catename"]); ?></li>
                            <?php $cate3=M('menu')->where('level=3 and status=1 and pid='.$vv['id'])->order('sort')->select(); ?>
                            <?php if(is_array($cate3)): $i = 0; $__LIST__ = $cate3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvv): $mod = ($i % 2 );++$i; if(authcheck('Home/'.$vvv['alink'],session('uid'))): ?><li data-id="<?php echo ($vvv["id"]); ?>" data-pid="<?php echo ($vv["id"]); ?>" data-url="index.php/home/<?php echo ($vvv["alink"]); ?>" data-tabid="<?php echo ($vvv["alink"]); ?>" data-fresh="true" data-faicon="<?php if(!empty($vvv['icon'])){echo $vvv['icon'];}else{echo 'caret-right';} ?>"><?php echo ($vvv["$catename"]); ?></li><?php endif; endforeach; endif; else: echo "" ;endif; endif; endif; endforeach; endif; endif; endif; endforeach; endif; ?>
	</ul>
	</div>
</li><?php endif; endforeach; endif; ?>
<!--导航菜单 结束-->

        </ul>
    </div>
	<button type="button" class="btn-default bjui-hnav-more-right" title="<?php echo L('_INDEX_MenuRight_');?>"><i class="fa fa-angle-double-right"></i></button>
    </div>
</header>


<div id="bjui-container">
	<div id="bjui-leftside">
		<div id="bjui-sidebar-s">
			<div class="collapse"></div>
		</div>
		<div id="bjui-sidebar">
			<div class="toggleCollapse"><h2><i class="fa fa-bars"></i> <?php echo L('_INDEX_Navigation_');?> <i class="fa fa-bars"></i></h2><a href="javascript:;" class="lock"><i class="fa fa-lock"></i></a></div>
			<div class="panel-group panel-main" data-toggle="accordion" id="bjui-accordionmenu" data-heightbox="#bjui-sidebar" data-offsety="26"></div>
		</div>
	</div>
        <div id="bjui-navtab" class="tabsPage">
            <div class="tabsPageHeader">
                <div class="tabsPageHeaderContent">
                    <ul class="navtab-tab nav nav-tabs">
                        <!--<li data-tabid="main" class="main active"><a href="javascript:;"><span><i class="fa fa-home"></i> #maintab#</span></a></li>-->
                        <li data-tabid="main" data-url="<?php echo U('index/index_layout');?>"><a href="javascript:;"><span><i class="fa fa-home"></i> <?php echo L('_INDEX_MyHomePage_');?></span></a></li>
                    </ul>
                </div>
                <div class="tabsLeft"><i class="fa fa-angle-double-left"></i></div>
                <div class="tabsRight"><i class="fa fa-angle-double-right"></i></div>
                <div class="tabsMore"><i class="fa fa-angle-double-down"></i></div>
            </div>
            <ul class="tabsMoreList">
                <li><a href="javascript:;"><?php echo L('_INDEX_MyHomePage_');?></a></li>
            </ul>
            
			<div class="navtab-panel tabsPageContent">
				<div class="navtabPage unitBox">
					<div class="bjui-pageContent" style="background:#FFF;">
                        
						                        <?php echo L('_INDEX_Loading_');?>

                        
					</div>
				</div>
            </div>

        </div>
    </div>
    <footer id="bjui-footer">&nbsp;<!--您好！<?php echo (session('depname')); ?> <?php echo (session('posname')); ?> <?php echo (session('truename')); ?> (<?php echo (session('username')); ?>)登录IP:<?php echo (session('loginip')); ?>&nbsp;&nbsp;登录时间:<?php echo (session('logintime')); ?>&nbsp;&nbsp;-->Copyright © <a href="http://www.whrhkj.com" target=_blank><?php echo L('_INDEX_TITLE_');?></a>
    </footer>
    </div>
</body>
</html>