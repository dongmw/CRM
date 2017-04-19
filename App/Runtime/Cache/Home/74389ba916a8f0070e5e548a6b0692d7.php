<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
	<div class="bjui-searchBar" style="padding: 5px 15px;">
		<h5 class="panel-title">清除缓存</h5>
	</div>
</div>
<div class="bjui-pageContent tableContent">
<div class="margin-5">
	<div class="operate panel panel-default">
		<div class="panel-body">
<p><a href="/renhe/crm/index.php/home/systemclear/clear/type/all/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" class="btn btn-danger" data-icon="times">清除所有缓存</a></p>
<p><a href="/renhe/crm/index.php/home/systemclear/clear/type/runtime/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" class="btn btn-warning" data-icon="times">清除Runtime缓存</a></p>
<p><a href="/renhe/crm/index.php/home/systemclear/clear/type/cache/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" class="btn btn-warning" data-icon="times">清除Cache缓存</a></p>
<p><a href="/renhe/crm/index.php/home/systemclear/clear/type/date/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" class="btn btn-warning" data-icon="times">清除Data缓存</a></p>
<p><a href="/renhe/crm/index.php/home/systemclear/clear/type/temp/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" class="btn btn-warning" data-icon="times">清除Temp缓存</a></p>
<p><a href="/renhe/crm/index.php/home/systemclear/clear/type/log/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" class="btn btn-warning" data-icon="times">清除Logs缓存</a></p>
		</div>
	</div>
</div>
</div>