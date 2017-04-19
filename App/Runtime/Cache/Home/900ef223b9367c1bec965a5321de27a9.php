<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
<form id="pagerForm" data-toggle="ajaxsearch" action="/renhe/crm/index.php/home/dep" method="post">
	<input type="hidden" name="pageSize" value="<?php echo ($numPerPage); ?>">
	<input type="hidden" name="pageCurrent" value="<?php echo ((isset($_REQUEST['pageNum']) && ($_REQUEST['pageNum'] !== ""))?($_REQUEST['pageNum']):1); ?>">
	<div class="bjui-searchBar">
		<div class="btn-group " role="group">
			<button type="button" class="btn btn-blue" data-url="/renhe/crm/index.php/home/dep/add/type/1/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="dialog" data-width="600" data-height="300" data-id="dialog-mask" data-mask="true" data-icon="plus"> 添加</button>
			<button type="button" class="btn btn-red" data-url="/renhe/crm/index.php/home/dep/del/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" data-confirm-msg="确定要清理吗？" data-icon="remove"> 清理</button>
		</div>
		<div class="btn-group floatright" role="group">
			<button type="button" class="btn-green" onclick="$(this).navtab('reloadForm', true);" data-icon="refresh">刷新</button>
			<button type="button" class="btn-close" data-icon="close">关闭</button>
		</div>
	</div> 
</form>
</div>
<div class="bjui-pageContent tableContent">
     <table data-toggle="tablefixed" data-width="100%" data-layout-h="0" data-nowrap="false">
        <thead>
            <tr>
            <th width="10" height="27"></th>
            <th width="50">编号</th>
			<th>职位名称</th>
			<th>所属用户</th>
			<th width="30">排序</th>
			<th <?php echo display(CONTROLLER_NAME.'/edit'); ?> >操作</th>
            </tr>
        </thead>
        <tbody>

       <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr data-id="<?php echo ($v["id"]); ?>">
		<td></td>
        <td><?php echo ($v["id"]); ?></td><td>
        <?php switch($v["level"]): case "0": ?><b><?php break; case "1": ?>—<?php break; case "2": ?>——<?php break; case "3": ?>———<?php break; case "4": ?>————<?php break; case "5": ?>—————<?php break; case "6": ?>——————<?php break; case "7": ?>———————<?php break; default: endswitch; echo ($v["title"]); ?>
	    <?php if($v["status"] == 1 ): else: ?><img src="/renhe/crm/Public/images/locked.gif" border="0"/><?php endif; ?>
	    </td>
        <td>
            <?php $cate1=M('user')->where('position_id='.$v['id'])->order('truename')->select(); ?>
            <?php if(is_array($cate1)): $i = 0; $__LIST__ = $cate1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><span href="javascript:;" class="label label-default"><?php echo ($v1["truename"]); ?></span>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
        </td>
        <td><?php echo ($v["sort"]); ?></td>
		<td <?php echo display(CONTROLLER_NAME.'/edit'); ?> > <a href="/renhe/crm/index.php/home/dep/edit/id/<?php echo ($v['id']); ?>/type/1/navTabId/<?php echo CONTROLLER_NAME;?>"   class="btn btn-green btn-sm" data-toggle="dialog" data-width="600" data-height="300" data-id="dialog-mask" data-mask="true" >编辑</a>
		    <a href="/renhe/crm/index.php/home/dep/EditRule/id/<?php echo ($v['id']); ?>/type/1/navTabId/<?php echo CONTROLLER_NAME;?>" class="btn btn-green btn-sm" data-toggle="dialog" data-width="950" data-height="500" data-id="dialog-mask" data-mask="true" data-title="权限设置" >权限</a>
		    <a href="/renhe/crm/index.php/home/dep/copy/id/<?php echo ($v['id']); ?>/type/1/navTabId/<?php echo CONTROLLER_NAME;?>" class="btn btn-green btn-sm" data-toggle="dialog" data-width="950" data-height="500" data-id="dialog-mask" data-mask="true" data-title="复制该权限">复制该权限</a>
		</td>
        </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
</div>