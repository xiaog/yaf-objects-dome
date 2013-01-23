<?php
/**
 * 评论管理
 * @author 张洋 2050479@qq.com
 */
class Manage_CommentController extends Ctrl_Base{
	/**
	 * 列表
	 */
	public function listAction(){
		$tMC = new CommentModel();
		$this->assign('datas', $tMC->limit(20)->fList());
	}

	/**
	 * 删除
	 */
	public function delAction($id=0){
		if(!$id = abs($id)){
			$this->showMsg('参数错误');
		}
		$tMC = new CommentModel();
		$tMC->del($id);
		$this->showMsg('删除成功');
	}
}