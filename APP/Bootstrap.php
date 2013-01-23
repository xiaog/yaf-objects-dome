<?php
class Bootstrap extends Yaf_Bootstrap_Abstract{

	/**
	 * 把配置存到注册表
	 */
	function _initConfig(){
		Yaf_Registry::set("config",  Yaf_Application::app()->getConfig());
		define('PATH_APP', Yaf_Registry::get("config")->application->directory);
		define('PATH_TPL', PATH_APP . '/views');
	}
}