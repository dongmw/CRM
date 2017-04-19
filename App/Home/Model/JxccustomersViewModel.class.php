<?php
namespace Home\Model;
use Think\Model\ViewModel;

class JxccustomersViewModel extends ViewModel {
	public $viewFields=array(
		'Jxccustomers'=>array('*'),
		'Jxccontact'=>array('xingming','phone','dianhua','qq','first','address','_on'=>'Jxccustomers.attid=Jxccontact.attid'),
		'SystemTag'=>array('name'=>'tag_name','_on'=>'Jxccustomers.mc_type=SystemTag.id')
		);
}
?>