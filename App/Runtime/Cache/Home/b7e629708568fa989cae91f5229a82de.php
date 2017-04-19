<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
<form id="pagerForm" data-toggle="ajaxsearch" action="/renhe/crm/index.php/home/org" method="post">
	<input type="hidden" name="pageSize" value="<?php echo ($numPerPage); ?>">
	<input type="hidden" name="pageCurrent" value="<?php echo ((isset($_REQUEST['pageNum']) && ($_REQUEST['pageNum'] !== ""))?($_REQUEST['pageNum']):1); ?>">
	<div class="bjui-searchBar">
		<div class="btn-group " role="group">
			<button type="button" class="btn btn-blue" data-url="/renhe/crm/index.php/home/org/add/type/0/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="dialog" data-width="600" data-height="300" data-id="dialog-mask" data-mask="true" data-icon="plus"> 添加</button>
			<button type="button" class="btn btn-red" data-url="/renhe/crm/index.php/home/org/del/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" data-confirm-msg="确定要清理吗？" data-icon="remove"> 清理</button>
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
            <th width="50">编号</th>
			<th>部门名称</th>
			<th width="30">排序</th>
			<th <?php echo display(CONTROLLER_NAME.'/edit'); ?> >操作</th>
            </tr>
        </thead>
        <tbody>

       <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr data-id="<?php echo ($v["id"]); ?>">
		<td></td>
        <td><?php echo ($v["id"]); ?></td><td>
		<?php switch($v["level"]): case "0": ?><b><?php echo ($v["title"]); ?></b><?php break; case "1": ?>—<?php echo ($v["title"]); break; case "2": ?>——<?php echo ($v["title"]); break; case "3": ?>———<?php echo ($v["title"]); break; case "4": ?>————<?php echo ($v["title"]); break; case "5": ?>—————<?php echo ($v["title"]); break; case "6": ?>——————<?php echo ($v["title"]); break; case "7": ?>———————<?php echo ($v["title"]); break; default: endswitch;?>
	     <?php if($v["status"] == 1 ): else: ?><img src="/renhe/crm/Public/images/locked.gif" border="0"/><?php endif; ?>
	    </td>
        <td><?php echo ($v["sort"]); ?></td>
		<td <?php echo display(CONTROLLER_NAME.'/edit'); ?> > <a href="/renhe/crm/index.php/home/org/edit/id/<?php echo ($v['id']); ?>/type/0/navTabId/<?php echo CONTROLLER_NAME;?>"   class="btn btn-green btn-sm" data-toggle="dialog" data-width="600" data-height="300" data-id="dialog-mask" data-mask="true" >编辑</a>
		    <a href="/renhe/crm/index.php/home/org/EditRule/id/<?php echo ($v['id']); ?>/type/0/navTabId/<?php echo CONTROLLER_NAME;?>"   class="btn btn-green btn-sm" data-toggle="dialog" data-width="950" data-height="500" data-id="dialog-mask" data-mask="true" data-title="权限设置" >权限</a>
		    <a href="/renhe/crm/index.php/home/org/copy/id/<?php echo ($v['id']); ?>/type/0/navTabId/<?php echo CONTROLLER_NAME;?>" class="btn btn-green btn-sm" data-toggle="dialog" data-width="950" data-height="500" data-id="dialog-mask" data-mask="true" data-title="复制该权限">复制该权限</a>
		</td>
        </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
</div>