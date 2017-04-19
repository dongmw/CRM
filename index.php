<?php
/**
 *      入口文件
 *      Version: yhsys_1.2
 *      Author:  grazel <13811836808@qq.com> <http://www.yahua-med.com.cn>
 */

if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

//define('APP_DEBUG',True);

define('APP_PATH','./App/');

require './Core/index.php';

