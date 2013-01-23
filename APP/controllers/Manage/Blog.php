<?php
/**
 * Blog管理
 * @author 张洋 2050479@qq.com
 */
class Manage_BlogController extends Ctrl_Base{
	/**
	 * 列表
	 */
	public function listAction(){
		$tMB = new BlogModel();
		$this->assign('datas', $tMB->limit(20)->fList());
	}

	/**
	 * 增、改
	 */
	public function saveAction($id=0){
		$tMB = new BlogModel();
		$tMBI = new BloginfoModel();
		if('POST' == $_SERVER['REQUEST_METHOD']){
			$id && $_POST['id'] = $id;
			$id || $_POST['created'] = $_SERVER['REQUEST_TIME'];
			# 博客标题
			if($tId = $tMB->save($_POST)){
				# 博客内容
				$tMBI->del($tId);
				$tMBI->insert(array('id' => $tId, 'content' => $_POST['content']));
			}
			$this->showMsg('保存成功');
		}
		# 博客内容初始化
		if($id){
			$tBlog = $tMB->fRow($id);
			$tBlog['content'] = $tMBI->where("id='$id'")->fOne('content');
			$this->assign('blog', $tBlog);
		}
	}

	/**
	 * 删除
	 */
	public function delAction($id=0){
		if(!$id = abs($id)){
			$this->showMsg('参数错误');
		}
		$tMB = new BlogModel();
		$tMB->del($id);
		$tMBI = new BloginfoModel();
		$tMBI->del($id);
		$this->showMsg('删除成功');
	}
}