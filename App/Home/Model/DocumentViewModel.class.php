<?php
namespace Home\Model;
use Think\Model\ViewModel;

class DocumentViewModel extends ViewModel {
	public $viewFields=array(
		'Document'=>array('*'),
		'SystemFolder'=>array('name'=>'folder_name','_on'=>'Document.folder=SystemFolder.id')
		);
}
?>