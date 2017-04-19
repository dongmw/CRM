<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent tableContent">
    <form action="/renhe/crm/index.php/home/org/edit/navTabId/<?php echo CONTROLLER_NAME;?>" class="pageForm" data-toggle="validate">
		<input type="hidden" name="id" value="<?php echo ($id); ?>"><input type="hidden" name="type" value="<?php echo ($type); ?>">
          <table class="table table-condensed table-hover" width="100%">
           <tbody>
			<tr><td>
                <label for="j_name" class="control-label x85">所属部门：</label><select  name="pid" data-toggle="selectpicker" data-rule="required">
               <option  value="0">顶级</option>
	          <?php if(is_array($list)): foreach($list as $key=>$v): ?><option <?php if($v["id"] == $Rs['pid'] ): ?>selected value="<?php echo ($Rs['pid']); ?>" <?php else: ?>value="<?php echo ($v["id"]); ?>"<?php endif; ?> >
	          <?php switch($v["level"]): case "0": break; case "1": ?>—<?php break; case "2": ?>——<?php break; case "3": ?>———<?php break; case "4": ?>————<?php break; case "5": ?>—————<?php break; case "6": ?>——————<?php break; case "7": ?>———————<?php break; default: endswitch; echo ($v["title"]); if($v["status"] == 1 ): else: ?><font color=red>[未启用]</font><?php endif; endforeach; endif; ?>
             </select>
            </td></tr>
            <tr><td>
                <label for="j_title" class="control-label x85"><?php if($type == 0 ): ?>部门<?php else: ?>职位<?php endif; ?>名称：</label>
                <input type="text" data-rule="required" size="30" name="title" id="j_title" value="<?php echo ($Rs['title']); ?>" >
             </td></tr>
            
            <?php if($id == '' ): else: ?>
            <tr><td>
                <label for="j_status" class="control-label x85">是否启用：</label>
               <select name="status"  data-container="body"  id="j_status" data-toggle="selectpicker" data-rule="required">
			    <?php if($Rs['status'] == 1 ): ?><option value="1" selected>启用</option><?php else: ?><option value="0" selected>禁用</option><?php endif; ?>
                <option value="1">启用</option>
                <option value="0">禁用</option>
                 </select>
           </td></tr><?php endif; ?>
              <tr><td>
                <label for="j_sort" class="control-label x85">排序：</label>
                <input type="text"  size="5" data-toggle="spinner" data-min="0" data-max="100" data-step="1" data-rule="integer" name="sort" id="j_sort" value="<?php echo ($Rs['sort']); ?>" >
            </td></tr>
            </tbody>
            </table>
</div>
<div class="bjui-pageFooter">
<ul>
<li><button type="button" class="btn-close" data-icon="close">取消</button></li>
<li><button type="submit" class="btn-success" data-icon="save">保存</button></li>
</ul>
</div>