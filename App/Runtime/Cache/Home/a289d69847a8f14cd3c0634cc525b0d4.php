<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
<form id="pagerForm" data-toggle="ajaxsearch" action="/renhe/crm/index.php/home/public/jxcinformation" method="post">
	<input type="hidden" name="pageSize" value="<?php echo ($numPerPage); ?>">
	<input type="hidden" name="pageCurrent" value="<?php echo ((isset($_REQUEST['pageNum']) && ($_REQUEST['pageNum'] !== ""))?($_REQUEST['pageNum']):1); ?>">
	<div class="bjui-searchBar">
		<label>筛选:</label>
		<select name="filter" data-toggle="selectpicker">
		<option value="">全部</option>
		<?php if(is_array($filters)): foreach($filters as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if($v["id"] == $_REQUEST['filter'] ): ?>selected <?php else: endif; ?> >
			<?php switch($v["level"]): case "0": break; case "1": ?>—<?php break; case "2": ?>——<?php break; case "3": ?>———<?php break; case "4": ?>————<?php break; case "5": ?>—————<?php break; case "6": ?>——————<?php break; case "7": ?>———————<?php break; default: endswitch; echo ($v["name"]); ?>
		</option><?php endforeach; endif; ?>
		</select>
		<label>关键词：</label><input type="text" value="<?php echo ($_REQUEST['keys']); ?>" name="keys" class="form-control" size="12" />
		<div class="btn-group " role="group">
			<button type="submit" class="btn btn-success" data-icon="search">查询</button>
		</div>
            <!--<a class="btn btn-orange" href="javascript:;" data-toggle="reloadsearch" data-clear-query="true" data-icon="undo">清空查询</a>-->
		<div class="btn-group pull-right" role="group">
            <button type="button" class="btn btn-close" data-icon="close">关闭</button>
			<!--<button type="button" class="btn-blue" data-toggle="lookupback" data-lookupid="ids" data-warn="请至少选择一项" data-icon="check-square-o">选中</button>-->
		</div>
	</div>
</form>
</div>
<div class="bjui-pageContent tableContent">
    <table data-toggle="tablefixed" data-width="100%" data-layout-h="0">
        <thead>
            <tr>
				<th data-order-field="id" height="30">ID</th>
				<th data-order-field='mc_id'>商品类别</th>
				<th data-order-field='mi_bh'>商品编号</th>
				<th data-order-field='mi_mc'>商品名称</th>
				<th data-order-field='mi_gg'>规格型号</th>
				<th data-order-field='mi_dw'>单位</th>
				<!--<th width="28"><input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck"></th>-->
				<th width="35" class="textcenter">库存</th>
				<th width="70">操作</th>
            </tr>
        </thead>
        <tbody>
		  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
             <td><?php echo ($v["id"]); ?></td>
			 <td><?php echo (get_table_field($v["mc_id"],'id','name','jxccategory')); ?></td>
             <td><?php echo ($v["mi_bh"]); ?></td>
		     <td><?php echo ($v["mi_mc"]); ?> </td>
		     <td><?php echo ($v["mi_gg"]); ?></td>
		     <td><?php echo (get_table_field($v["mi_dw"],'id','name','system_tag')); ?></td>
             <!--<td><input type="checkbox" name="ids" data-toggle="icheck" value="{juid:'<?php echo ($v["id"]); ?>', juname:'<?php echo ($v["truename"]); ?>'}"></td>-->
		     <td class="textcenter"><button href="javascript:;" data-url="index.php?m=home&c=public&a=jxcwarehouselist&id=<?php echo ($v["id"]); ?>" data-toggle="dialog" data-id="dialog-jxcwarehouselist" data-mask="true" data-height="400" data-width="550" style="width:100%" data-title="查看库存"><i class="fa fa-search"></i></a></button></td>
             <td><a href="javascript:;" data-toggle="lookupback" data-args="{mc:'<?php echo ($v["mi_bh"]); ?> <?php echo ($v["mi_mc"]); ?>_规格:<?php echo ($v["mi_gg"]); ?>_单位:<?php echo (get_table_field($v["mi_dw"],'id','name','system_tag')); ?>', id:'<?php echo ($v["id"]); ?>'}" class="btn btn-blue" title="选择本项" data-icon="check">选择</a>
             </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="bjui-pageFooter">
<div class="pages"><span>共 <?php echo ($totalCount); ?> 条  每页 <?php echo ($numPerPage); ?> 条</span></div>
<div class="pagination-box" data-toggle="pagination" data-total="<?php echo ($totalCount); ?>" data-page-size="<?php echo ($numPerPage); ?>" data-page-current="<?php echo ($currentPage); ?>"></div>
</div>