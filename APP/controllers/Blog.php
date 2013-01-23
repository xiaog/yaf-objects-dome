<?php
/**
 * 博客
 * @author 张洋 2050479@qq.com
 */
class BlogController extends Ctrl_Base{
	/**
	 * 查看博客
	 */
	public function viewAction($id=0){
		# 参数验证
		if(!$id = abs($id)){
			$this->showMsg('参数错误');
		}
		#左边导航
		$tMB = new BlogModel();
		$this->assign('blogs', $tMB->limit(20)->fList());
		# 日志
		$tBlog = new BlogModel($id);
		$tBlog->id || $this->showMsg('日志不存在');
		# 日志内容
		$tMBI = new BloginfoModel($tBlog->id);
		$tBlog->content = $tMBI->content;
		$this->assign('blog', $tBlog);
		# 评论列表
		$tMC = new CommentModel();
		$this->assign('comment', $tMC->where('bid='.$id)->fList());
		# 访问数 +1
		$tBlog->update(array('id'=>$id, 'view'=>$tBlog->view+1));
	}

	/**
	 * 添加评论
	 */
	public function commentsaveAction($id=0){
		$tMC = new CommentModel();
		# 插入评论
		$tMC->insert(array(
			'bid' => abs($id),
			'content' => $_POST['content'],
			'created' => $_SERVER['REQUEST_TIME']
		));
		# 更新评论数
		$tMB = new BlogModel($id);
		$tMB->update(array('id'=>$id, 'comment'=>$tMB->comment+1));
		$this->showMsg('评论提交成功');
	}
}