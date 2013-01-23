<?php
/**
 * Index 控制器
 * @author 张洋 2050479@qq.com
 */
class IndexController extends Ctrl_Base{
	/**
	 * 首页
	 */
	public function indexAction(){
		$tMB			= new BlogModel();
		Yaf_loader::import("page/pagination.php");
		$page_size = 5;
		$current_page_number = $_GET['page'] ? $_GET['page'] : 1;
		$limit = ($current_page_number-1)*$page_size;
		$ocount=$tMB->count();
		$pagi           = new Page_Pagination('/',$page_size,$ocount,$pagination_size=10,$conf);
		$navigation_str = $pagi->generate($current_page_number);
		$this->assign('page',$navigation_str);
		$this->assign('blogs', $tMB->limit($limit,$page_size)->fList());
	}
}