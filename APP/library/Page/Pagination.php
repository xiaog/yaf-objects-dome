<?php
/**
 *A pagination generation class
 *@class  : Pagination
 *@version: 1.0.0
 *@author : huixinchen at baidu.com
 *@useage:
 *      $pagi                   =  new Pagination($url_prefix, $page_size, $mesgs_count, $pagination_size=10, array $conf);
 *  $navigation_str = $pagi->generate($current_page_number);
 */
class Page_Pagination{
        private $page, $total_page, $total, $page_size, $size;
        private $prev_str = "&lt", $next_str = "&gt";
        private $class, $selected_class = "selected", $prev_class="prev", $next_class="next",
                $de_prev_class="de_prev", $de_next_class="de_next";
        private $url_prefix="", $split_char="?";
        private $para_name = "page", $target = "";
        public function Page_Pagination($url_prefix, $page_size, $total, $size=10, $conf=array()){
                $this->page       = 1;
                $this->page_size  = $page_size;
                $this->total      = $total;
                $this->total_page = intval(ceil($total/$page_size));
                $this->size               = $size;
                if(!empty($conf)){
                        $configure = array("prev_str", "next_str", "class", "selected_class");
                        foreach($conf as $key => $val){
                                if(in_array($key, $configure)){
                                        $this->$val = $val;
                                }
                        }
                }
                $this->url_prefix = $url_prefix;
                if(strstr($url_prefix, '?') !== false){
                        $this->url_prefix .= "&" . $this->para_name . "=";
                }else{
                        $this->url_prefix .= "?" . $this->para_name . "=";
                }
        }
 
        public function generate($page){
                $this->page = $page;
                if(isset($this->page[$page])){
                        return $this->page_str[$page];
                }
                $page_start = 1;
                $half           = intval($this->size/2);
                $page_start = max(1, $page - $half);
                $page_end       = min($page_start + $this->size - 1, $this->total_page);
                $page_start = max(1, $page_end - $this->size + 1);
              
                $this->page_str[$page] = $this->build_nav_str($page_start, $page_end);
                return $this->page_str[$page];
        }
 
        private function build_nav_str($page_start, $page_end){
                $page_nums = range($page_start, $page_end);
                $target    = $this->target? " target=\"{$this->target}\"" : "";
                if($this->page == 1){
                        $page_str = <<<HTML
                        <span class="{$this->de_prev_class}"> {$this->prev_str} </span>
HTML;
                }else{
                        $page     = $this->page - 1;
                        $page_str = <<<HTML
                        <span class="{$this->prev_class}"> <a href="{$this->url_prefix}{$page}"{$this->target}>{$this->prev_str}</a></span>
HTML;
                }
                foreach($page_nums as $p){
                        $page_str .= ($p == $this->page) ? <<<HTML
                        <span class="{$this->selected_class}">{$p}</span>
HTML
                        : <<<HTML
                        <span class="{$this->class}"><a href="{$this->url_prefix}{$p}"{$this->target}>{$p}</a></span>
HTML;
 
                }
                if($this->page == $this->total_page){
                        $page_str .= <<<HTML
                        <span class="{$this->de_next_class}"> {$this->next_str} </span>
HTML;
                }else{
                        $page      = $this->page + 1;
                        $page_str .= <<<HTML
                        <span class="{$this->next_class}"> <a href="{$this->url_prefix}{$page}"{$this->target}>{$this->next_str}</a></span>
HTML;
                }
                return $page_str;
        }
 
        public function tidy_str(){
                ;//void
        }
 
        public function __call($func_name, $arguments){
                if(isset($this->$func_name)){
                        return $this->$func_name;
                }
        }
 
        public function __destruct(){
                unset($this->page_str);
                unset($this);
        }
}
?>