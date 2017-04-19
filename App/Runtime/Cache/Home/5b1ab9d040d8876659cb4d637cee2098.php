<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent tableContent">
    <form action="/renhe/crm/index.php/home/menu/edit/navTabId/<?php echo CONTROLLER_NAME;?>" class="pageForm" data-toggle="validate">
		<input type="hidden" name="id" value="<?php echo ($id); ?>">
          <table class="table table-condensed table-hover" width="100%">
           <tbody>
			<tr><td>
                <label for="j_pid" class="control-label x85">上级菜单：</label><select id="j_pid" name="pid" data-toggle="selectpicker" data-rule="required">
               <option  value="0">顶级</option>
	          <?php if(is_array($list)): foreach($list as $key=>$v): ?><option <?php if($v["id"] == $Rs['pid'] ): ?>selected value="<?php echo ($Rs['pid']); ?>" <?php else: ?>value="<?php echo ($v["id"]); ?>"<?php endif; ?> >
	          <?php switch($v["level"]): case "0": break; case "1": ?>—<?php break; case "2": ?>——<?php break; case "3": ?>———<?php break; case "4": ?>————<?php break; case "5": ?>—————<?php break; case "6": ?>——————<?php break; case "7": ?>———————<?php break; default: endswitch; echo ($v["catename"]); ?> <?php if($v["status"] == 1 ): else: ?><font color=red>[未启用]</font><?php endif; ?>
	         </option><?php endforeach; endif; ?>
             </select>
            </td></tr>
            <tr><td>
                <label for="j_catename" class="control-label x85">菜单名称：</label>
                <input type="text" data-rule="required" size="30" name="catename" id="j_catename" value="<?php echo ($Rs['catename']); ?>" >
            </td></tr>
            <tr><td>
                <label for="j_catename_zh-cn" class="control-label x85">中文(简体)：</label>
                <input type="text" data-rule="required" size="30" name="catename_zh-cn" id="j_catename_zh-cn" value="<?php echo ($Rs['catename_zh-cn']); ?>" >
            </td></tr>
            <tr><td>
                <label for="j_catename_zh-tw" class="control-label x85">中文(繁體)：</label>
                <input type="text" data-rule="required" size="30" name="catename_zh-tw" id="j_catename_zh-tw" value="<?php echo ($Rs['catename_zh-tw']); ?>" >
            </td></tr>
            <tr><td>
                <label for="j_catename_en-us" class="control-label x85">English：</label>
                <input type="text" data-rule="required" size="30" name="catename_en-us" id="j_catename_en-us" value="<?php echo ($Rs['catename_en-us']); ?>" >
            </td></tr>
            <tr><td>
                <label for="j_url" class="control-label x85">网址连接：</label>
                <input type="text" data-rule="required" size="30" name="alink" id="j_url" value="<?php echo ($Rs['alink']); ?>" >
           </td></tr>
            <tr><td>
                <label for="j_icon" class="control-label x85">图标样式：</label>
                <input type="text" data-rule="" size="30" name="icon" id="j_icon" value="<?php echo ($Rs['icon']); ?>" >
           </td></tr>
             <tr><td>
                <label for="j_sort" class="control-label x85">排序：</label>
                <input type="text" size="5" data-toggle="spinner" data-min="0" data-max="100" data-step="1" data-rule="integer" name="sort" id="j_sort" value="<?php echo ($Rs['sort']); ?>" >
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