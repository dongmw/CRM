<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
		<div class="btn-group " role="group">
			<!--<button type="submit" class="btn btn-success" data-icon="search">查询</button>-->
		</div>
		<div class="btn-group pull-right" role="group">
            <button type="button" class="btn btn-close" data-icon="close">关闭<?php echo ($type); ?></button>
			<!--<button type="button" class="btn-blue" data-toggle="lookupback" data-lookupid="ids" data-warn="请至少选择一项" data-icon="check-square-o">选中</button>-->
		</div>
	</div>
</div>
<div class="bjui-pageContent tableContent">
     <table data-toggle="tablefixed" data-width="100%" data-layout-h="0" data-nowrap="true">
        <thead>
            <tr>
<th width="10" height="30"></th>
<th>ID</th>
<th>名称</th>
<th>编号</th>
<th>备注</th>
<th width="74">操作</th>
            </tr>
        </thead>
        <tbody>

          <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
<td></td>
<td><?php echo ($v["id"]); ?></td>
<td>
		<?php switch($v["level"]): case "0": ?><b><?php echo ($v["name"]); ?></b><?php break; case "1": ?>—<?php echo ($v["name"]); break; case "2": ?>——<?php echo ($v["name"]); break; case "3": ?>———<?php echo ($v["name"]); break; case "4": ?>————<?php echo ($v["name"]); break; case "5": ?>—————<?php echo ($v["name"]); break; case "6": ?>——————<?php echo ($v["name"]); break; case "7": ?>———————<?php echo ($v["name"]); break; default: endswitch;?>
	     <?php if($v["status"] == 1 ): else: ?><img src="/renhe/crm/Public/images/locked.gif" border="0"/><?php endif; ?>
</td>
<td><?php echo ($v["number"]); ?></td>
<td><?php echo (msubstr($v["beizhu"],0,20)); ?></td>
<td>
<a href="javascript:;" data-toggle="lookupback" data-args="{name:'<?php echo ($v["name"]); ?>', id:'<?php echo ($v["id"]); ?>'}" class="btn btn-blue" title="选择本项" data-icon="check">选择</a>
</td>
         </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>