<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
<form id="pagerForm" data-toggle="ajaxsearch" action="/renhe/crm/index.php/home/cust" method="post">
	<input type="hidden" name="pageSize" value="<?php echo ($numPerPage); ?>">
	<input type="hidden" name="pageCurrent" value="<?php echo ((isset($_REQUEST['pageNum']) && ($_REQUEST['pageNum'] !== ""))?($_REQUEST['pageNum']):1); ?>">
	<div class="bjui-searchBar">
		<label>关键词：</label><input type="text" value="<?php echo ($_REQUEST['keys']); ?>" name="keys" class="form-control" size="15" />
		<label>添加时间：</label><input type="text" data-toggle='datepicker' value="<?php echo ($_REQUEST['time1']); ?>" name="time1" class="form-control" size="15" />-<input type="text" data-toggle='datepicker' value="<?php echo ($_REQUEST['time2']); ?>" name="time2" class="form-control" size="15" />
		<div class="btn-group " role="group">
			<button type="submit" class="btn-success" data-icon="search">查询</button>
			<button type="button" class="btn-orange" data-icon="undo" onclick="$(this).navtab('reloadForm', true);">清空查询</button>
		</div>
		<div class="btn-group " role="group">
			<button type="button" class="btn btn-blue" data-url="/renhe/crm/index.php/home/cust/add/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="dialog" data-width="900" data-height="500" data-id="dialog-mask" data-mask="true" data-icon="plus"> 添加</button>
			<button type="button" class="btn btn-blue" data-url="/renhe/crm/index.php/home/cust/outxls" data-toggle="doexport" data-icon="arrow-down" data-confirm-msg="确定要导出吗？"> 导出</button>
			<button type="button" class="btn btn-red" data-url="/renhe/crm/index.php/home/cust/del/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" data-confirm-msg="确定要清理吗？" data-icon="remove"> 清理</button>
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
            <th width="10" height="30"></th>
            <th data-order-direction='desc' data-order-field='id'>ID</th>
<th>公司名称</th>
<th data-order-direction='desc' data-order-field='fenlei'>进展</th>
<th data-order-direction='desc' data-order-field='xcrq'>下次联系</th>
<th>联系人</th>
<th>手机号码</th>
<th>QQ</th>
<th>客户来源</th>
<th data-order-direction='desc' data-order-field='uname'>添加人</th>
<th data-order-direction='desc' data-order-field='addtime'>添加时间</th>
<th data-order-direction='desc' data-order-field='updatetime'>更新时间</th>

			<th>详细</th>
		    <th <?php echo display(CONTROLLER_NAME.'/del'); ?> >状态</th>
		    <th <?php echo display(CONTROLLER_NAME.'/edit'); ?> >编辑</th>
            </tr>
        </thead>
        <tbody>

          <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
		   <td></td>
		   <td><?php echo ($v["id"]); ?></td>
<td><?php echo (msubstr($v["title"],0,20)); ?></td>
<td><?php echo ($v["fenlei"]); ?></td>
<td><?php echo (substr($v["xcrq"],0,10)); ?></td>
<td><?php echo (msubstr($v["xingming"],0,20)); ?></td>
<td><?php echo (msubstr($v["phone"],0,20)); ?></td>
<td><?php echo (msubstr($v["qq"],0,20)); ?></td>
<td><?php echo (msubstr($v["type"],0,20)); ?></td>
<td><?php echo ($v["uname"]); ?></td>
<td><?php echo (substr($v["addtime"],0,10)); ?></td>
<td><?php echo (substr($v["updatetime"],0,10)); ?></td>

		   <td><a href="/renhe/crm/index.php/home/cust/view/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>"  data-toggle="dialog" data-width="900" data-height="500" data-id="dialog-mask" data-mask="true" >详细</a></td>
		   <td <?php echo display(CONTROLLER_NAME.'/del'); ?> ><a href="/renhe/crm/index.php/home/cust/del/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" data-confirm-msg="确定要操作吗？"><?php if($v["status"] == 1 ): ?><img src="/renhe/crm/Public/images/ok.gif" border="0"/><?php else: ?><img src="/renhe/crm/Public/images/locked.gif" border="0"/><?php endif; ?></a></td>
		   <td <?php echo display(CONTROLLER_NAME.'/edit'); ?> > 
		   <a href="/renhe/crm/index.php/home/custcon/add/cid/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>"  class="btn btn-green btn-sm" data-toggle="dialog" data-width="900" data-height="500" data-id="dialog-mask" data-mask="true">联系人</a>
		   <a href="/renhe/crm/index.php/home/custgd/add/cid/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>"   class="btn btn-green btn-sm" data-toggle="dialog" data-width="900" data-height="500" data-id="dialog-mask" data-mask="true">进展</a>
		   <a href="/renhe/crm/index.php/home/cust/edit/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>"   class="btn btn-green btn-sm" data-toggle="dialog" data-width="900" data-height="500" data-id="dialog-mask" data-mask="true" >编辑</a>
		   </td>
		   </td>
         </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="bjui-pageFooter">
	<div class="pages"><span>共 <?php echo ($totalCount); ?> 条  每页 <?php echo ($numPerPage); ?> 条</span></div>
	<div class="pagination-box" data-toggle="pagination" data-total="<?php echo ($totalCount); ?>" data-page-size="<?php echo ($numPerPage); ?>" data-page-current="<?php echo ($currentPage); ?>"></div>
</div>