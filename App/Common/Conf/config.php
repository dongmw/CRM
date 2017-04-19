<?php
return array( 

	'LANG_SWITCH_ON'   => true,    //开启语言包功能
	'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
    'DEFAULT_LANG'     => 'zh-cn', // 默认语言$_COOKIE['think_language']
    'LANG_LIST'        => 'zh-cn,zh-tw,en-us', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'     => 'l', // 默认语言切换变量

    'URL_MODEL'   =>  0,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
	
    'URL_CASE_INSENSITIVE' =>true, //表示URL访问不区分大小写
   
	//权限验证设置
	'AUTH_CONFIG'=>array(
        'AUTH_ON' => true, 
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'xy_auth_group', 
        'AUTH_GROUP_ACCESS' => 'xy_auth_group_access', 
        'AUTH_RULE' => 'xy_auth_rule', 
        'AUTH_USER' => 'xy_user'
    ),
	'NOT_AUTH_MODULE' => 'Public,Index', // 默认无需认证模块
    //超级管理员id,拥有全部权限,只要用户uid在这个角色组里的,就跳出认证.可以设置多个值,如array('1','2','3')
    'ADMINISTRATOR'=>array('1'),
	'SESSION_OPTIONS' =>  array('expire'=>36000),
	'SESSION_PREFIX'  =>  'xykj', 
	
	 // 加载扩展配置文件 多个用,隔开
	'LOAD_EXT_CONFIG' => 'web,db', 
	
	//上传设置
	'UPLOAD_MAXSIZE'=>31457280,
	'UPLOAD_EXTS'=>array('jpg','gif','png','jpeg','txt','doc','docx','xls','xlsx','ppt','pptx','pdf','rar','zip','wps','wpt','dot','rtf','dps','dpt','pot','pps','et','ett','xlt'),// 设置附件上传类型 
	'UPLOAD_SAVEPATH'=>'./Public/',
	
	//文件缓存安全机制
	'DATA_CACHE_KEY'=>'grazel',
	
);
