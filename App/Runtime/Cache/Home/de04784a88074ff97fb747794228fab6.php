<?php if (!defined('THINK_PATH')) exit();?><div class="col-sm-12">
<div style="display: inline-block; vertical-align: middle;">
    <div id="j_<?php echo ($id); ?>_file_up" data-toggle="upload" data-uploader="<?php echo U('Public/uploading','sessionid='.$uid.'&attid='.$attid.'&module='.$module);?>" 
    data-file-size-limit="31457280"
    data-file-type-exts="*.jpg;*.jpeg;*.png;*.gif;*.bmp;*.mpg;*.rar;*.zip;*.txt;*.doc;*.docx;*.xls;*.xlsx;*.pdf;*.ppt;*.pptx"
    data-multi="true"
    data-button-text="添加附件"
    data-auto="true"
    data-remove-timeout="0"
    data-on-upload-success="<?php echo ($id); ?>_upload_success"
    data-icon="cloud-upload"
    data-button-css="btn-default"></div>
    <input type="hidden" name="<?php echo ($id); ?>.file" value="" id="j_<?php echo ($id); ?>_file">
</div>
<div class="uploader" id="j_<?php echo ($id); ?>_file_span">
<?php if(!empty($file_list)): if(is_array($file_list)): $i = 0; $__LIST__ = $file_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$file): $mod = ($i % 2 );++$i;?><li class="tbody" id="j_<?php echo ($id); ?>_file_span-<?php echo ($file['id']); ?>">
            <div style="width: 100%;" class="loading"></div>
            <div class="data">
                <span class="del text-center"><a href="javascript:DeleteFile_id_name_reduce('j_<?php echo ($id); ?>_file_span-<?php echo ($file['id']); ?>','<?php echo ($file['id']); ?>','<?php echo ($uid); ?>','<?php echo ($id); ?>_FileNum')" class="link del"><i class="fa fa-remove"></i></a></span>
                <span class="del text-center"><a class="link del" target="_blank" href="<?php echo U('public/down?attach_id='.f_encode($file['id']));?>"><i class="fa fa-download"></i></a></span>
                <span class="size text-right" ><?php echo (reunit($file["size"])); ?></span>
                <span class="auto autocut" title="<?php echo ($file["name"]); ?>"><?php echo ($file["filedesc"]); ?></span>
            </div>
        </li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
</div>
</div>