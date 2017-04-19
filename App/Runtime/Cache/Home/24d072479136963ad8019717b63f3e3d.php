<?php if (!defined('THINK_PATH')) exit();?><form id="j_pwschange_form" action="/renhe/crm/index.php/home/public/changePwd/navTabId/changepwd_page" data-toggle="validate" method="post">
<div class="bjui-pageContent tableContent">
		<div class="pageFormContent" data-layout-h="0">
            <hr>
            <div class="form-group">
                <label for="j_pwschange_oldpassword" class="control-label x85">旧密码：</label>
                <input type="password" data-rule="旧密码:required" name="oldpassword" id="j_pwschange_oldpassword" value="" placeholder="旧密码" size="20">
            </div>
            <div class="form-group" style="margin: 20px 0 20px; ">
                <label for="j_pwschange_newpassword" class="control-label x85">新密码：</label>
                <input type="password" data-rule="新密码:required,password" name="password" id="j_pwschange_newpassword" value="" placeholder="新密码" size="20">
            </div>
            <div class="form-group">
                <label for="j_pwschange_secpassword" class="control-label x85">确认密码：</label>
                <input type="password" data-rule="确认密码:required;match(password)" name="repassword" id="j_pwschange_secpassword" value="" placeholder="确认新密码" size="20">
            </div>
		</div>
</div>
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close">取消</button></li>
		<li><button type="submit" class="btn-success" data-icon="save">保存</button></li>
	</ul>
</div>
</form>