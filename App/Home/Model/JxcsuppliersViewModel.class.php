<?php
namespace Home\Model;
use Think\Model\ViewModel;

class JxcsuppliersViewModel extends ViewModel {
	public $viewFields=array(
		'Jxcsuppliers'=>array('*'),
		//'Jxccontact'=>array('xingming','phone','dianhua','qq','first','_on'=>'Jxcsuppliers.attid=Jxccontact.attid'),
		'SystemTag'=>array('name'=>'tag_name','_on'=>'Jxcsuppliers.ms_type=SystemTag.id')
		);
}
?>