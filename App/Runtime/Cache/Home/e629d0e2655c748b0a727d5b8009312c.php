<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent tableContent">
<div style="position:absolute;width:100%;" class="p5">


<!-- nav-tabs 开始 -->
<ul class="nav nav-tabs" role="tablist">
	<li class="active"><a href="javascript:;" data-url="<?php echo U('index/index_flow');?>" role="tab" data-toggle="ajaxtab" data-target="#index_flow" data-reload="true" class="font14"><i class="fa fa-table"></i> <?php echo L('_INDEX_LAYOUT_WorkFlow_');?><!--流程--></a></li>
	<li><a href="javascript:;" data-url="<?php echo U('index/index_task');?>" role="tab" data-toggle="ajaxtab" data-target="#index_task" data-reload="true" class="font14"><i class="fa fa-pencil-square-o"></i> <?php echo L('_INDEX_LAYOUT_MyTask_');?><!--任务--></a></li>
	<li><a href="javascript:;" data-url="<?php echo U('index/index_notice');?>" role="tab" data-toggle="ajaxtab" data-target="#index_notice" data-reload="true" class="font14"><i class="fa fa-volume-up"></i> <?php echo L('_INDEX_LAYOUT_Notice_');?><!--通知--></a></li>
	<li><a href="javascript:;" data-url="<?php echo U('index/index_document');?>" role="tab" data-toggle="ajaxtab" data-target="#index_document" data-reload="true" class="font14"><i class="fa fa-file"></i> <?php echo L('_INDEX_LAYOUT_DocumentView_');?><!--文档--></a></li>
	<li><a href="javascript:;" data-url="<?php echo U('index/index_whereabouts');?>" role="tab" data-toggle="ajaxtab" data-target="#index_whereabouts" data-reload="true" class="font14"><i class="fa fa-user-md"></i> <?php echo L('_INDEX_LAYOUT_StaffWhereabouts_');?><!--去向--></a></li>
	<li><a href="javascript:;" onclick="$(this).navtab('refresh', 'main');" class="font14"><i class="fa fa-refresh"></i> <?php echo L('_INDEX_LAYOUT_RefreshHomePage_');?><!--刷新首页--></a></li>
</ul>
<!-- tab-content 开始 -->
<div class="tab-content">
	<div class="tab-pane fade active in" id="index_flow"><!--流程-->
	
    <!--//流程 开始-->
    <div class="w100">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-table"></i> <?php echo L('_INDEX_LAYOUT_ToDoProcess_');?><!--待办的流程--> <a class="pull-right" href="javascript:;" data-url="<?php echo U('flow/confirm');?>" data-toggle="navtab" data-id="flow/confirm" data-title="<?php echo L('_INDEX_LAYOUT_ToDoProcess_');?>"><i class="fa fa-caret-right"></i> <?php echo L('_INDEX_LAYOUT_Detail_');?></a></h3></div>
			<div style="min-height:185px;">

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th height=30><?php echo L('_INDEX_LAYOUT_Title_');?></th>
                            <th><?php echo L('_INDEX_LAYOUT_InputPerson_');?></th>
                            <th><?php echo L('_INDEX_LAYOUT_InputTime_');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($list_confirm)): $i = 0; $__LIST__ = $list_confirm;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo (msubstr($v["name"],0,20)); ?></td>
                            <td><?php echo ($v["user_name"]); ?></td>
                            <td><?php echo (toDate($v["create_time"],'Y-m-d')); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
          
			</div>
		</div>
	</div>

	<div class="w100">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-table"></i> <?php echo L('_INDEX_LAYOUT_InitiateProcess_');?><!--发起的流程--> <a class="pull-right" href="javascript:;" data-url="<?php echo U('flow/submit');?>" data-toggle="navtab" data-id="flow/submit" data-title="<?php echo L('_INDEX_LAYOUT_InitiateProcess_');?>"><i class="fa fa-caret-right"></i> <?php echo L('_INDEX_LAYOUT_Detail_');?></a></h3></div>
			<div style="min-height:185px;">
          
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th height=30><?php echo L('_INDEX_LAYOUT_Title_');?></th>
                            <th><?php echo L('_INDEX_LAYOUT_InputTime_');?></th>
                            <th><?php echo L('_INDEX_LAYOUT_Status_');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($list_submit)): $i = 0; $__LIST__ = $list_submit;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo (msubstr($v["name"],0,20)); ?></td>
                            <td><?php echo (toDate($v["create_time"],'Y-m-d')); ?></td>
                            <td><?php echo (show_step($v["step"],1)); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
          
			</div>
		</div>
	</div>
    <!--//流程 结束-->

    </div>
    
    
	<div class="tab-pane fade" id="index_task"><!--任务-->
    loading...
    </div>


	<div class="tab-pane fade" id="index_notice"><!--通知-->
    loading...
    </div>


	<div class="tab-pane fade" id="index_document"><!--文档-->
    loading...
    </div>


	<div class="tab-pane fade" id="index_whereabouts"><!--去向-->
    loading...
    </div>


    
</div>



</div>
</div>