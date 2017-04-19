<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
<form id="pagerForm" data-toggle="ajaxsearch" action="/renhe/crm/index.php/home/menu" method="post">
	<input type="hidden" name="pageSize" value="<?php echo ($numPerPage); ?>">
	<input type="hidden" name="pageCurrent" value="<?php echo ((isset($_REQUEST['pageNum']) && ($_REQUEST['pageNum'] !== ""))?($_REQUEST['pageNum']):1); ?>">
	<div class="bjui-searchBar">
		<div class="btn-group " role="group">
			<button type="button" class="btn btn-blue" data-url="/renhe/crm/index.php/home/menu/add/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="dialog" data-width="600" data-height="350" data-id="dialog-mask" data-mask="true" data-icon="plus"> 添加</button>
			<button type="button" class="btn btn-red" data-url="/renhe/crm/index.php/home/menu/del/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" data-confirm-msg="确定要清理吗？" data-icon="remove"> 清理</button>
		</div>
		<div class="btn-group floatright" role="group">
			<button type="button" class="btn-green" onclick="$(this).navtab('reloadForm', true);" data-icon="refresh">刷新</button>
			<button type="button" class="btn-close" data-icon="close">关闭</button>
		</div>
	</div> 
</form>
</div>
<div class="bjui-pageContent tableContent">
     <table data-toggle="tablefixed" data-width="100%" data-layout-h="0" data-nowrap="true">
        <thead>
            <tr>
            <th width="10" height="27"></th>
            <th>编号</th>
				<th>菜单名称</th>
				<th>中文(简体)</th>
				<th>中文(繁體)</th>
				<th>English</th>
				<th>排序</th>
				<th>链接网址</th>
				<th <?php echo display(CONTROLLER_NAME.'/del'); ?> >状态</th>
				<th <?php echo display(CONTROLLER_NAME.'/edit'); ?> >操作</th> 
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr data-id="<?php echo ($v["id"]); ?>">
        <td height=25></td><td><?php echo ($v["id"]); ?></td><td>
		<?php switch($v["level"]): case "0": ?><i class="<?php echo ($v["icon"]); ?>"></i> <B><?php echo ($v["catename"]); ?></b><?php break; case "1": ?>—<i class="fa fa-<?php echo ($v["icon"]); ?>"></i> <?php echo ($v["catename"]); break; case "2": ?>——<i class="fa fa-<?php echo ($v["icon"]); ?>"></i> <?php echo ($v["catename"]); break; case "3": ?>———<i class="fa fa-<?php echo ($v["icon"]); ?>"></i> <?php echo ($v["catename"]); break; case "4": ?>————<i class="fa fa-<?php echo ($v["icon"]); ?>"></i> <?php echo ($v["catename"]); break; case "5": ?>—————<i class="fa fa-<?php echo ($v["icon"]); ?>"></i> <?php echo ($v["catename"]); break; default: endswitch;?>
	   </td>
	    <td><?php echo ($v["catename_zh-cn"]); ?></td>
	    <td><?php echo ($v["catename_zh-tw"]); ?></td>
	    <td><?php echo ($v["catename_en-us"]); ?></td>
	    <td><?php echo ($v["sort"]); ?></td>
        <td><?php echo ($v["alink"]); ?></td>
        <td <?php echo display(CONTROLLER_NAME.'/del'); ?> ><a href="/renhe/crm/index.php/home/menu/del/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" data-confirm-msg="确定要操作吗？"><?php if($v["status"] == 1 ): ?><img src="/renhe/crm/Public/images/ok.gif" border="0"/><?php else: ?><img src="/renhe/crm/Public/images/locked.gif" border="0"/><?php endif; ?></a></td>
		<td <?php echo display(CONTROLLER_NAME.'/edit'); ?> > <a href="/renhe/crm/index.php/home/menu/edit/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>"   class="btn btn-green btn-sm" data-toggle="dialog" data-width="600" data-height="350" data-id="dialog-mask" data-mask="true" >编辑</a></td>
        </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
</div>