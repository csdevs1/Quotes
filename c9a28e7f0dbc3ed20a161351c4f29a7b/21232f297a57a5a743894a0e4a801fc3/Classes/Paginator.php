<?php
    require_once('AppController.php');
    class Paginator {
        private $obj;
        private $_limit;
        private $_page;
        private $_total;
        
        public function __construct(){
            $this->obj = new AppController();
            $this->_total = count($this->obj->all('authors'));
        }
        
        public function getData($limit = 10, $page = 1){
            $this->_limit = $limit;
            $this->_page = $page;
            
            if($this->_limit=='all'){
                $rs=$this->obj->all('authors');
            } else{
                $count = (($this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
                $rs=$this->obj->limit('*','authors',$count,'authorID');
            }
            
            $result = new stdClass();
            $result->page = $this->_page;
            $result->limit = $this->_limit;
            $result->total = $this->_total;
            $result->data = $rs;
            return $result;
        }
        
        public function createLinks($links, $list_class){
            if($this->_limit=='all')
                return '';
            $last = ceil($this->_total / $this->_limit);
            $start = (($this->_page - $links)>0) ? $this->_page - $links : 1;
            $end = (($this->_page + $links) < $last) ? $this->_page + $links : $last;
            
            $html = '<ul class="'.$list_class.'">';
            
            $class = ($this->_page==1) ? "disabled" : "";
            $html .= '<li class="'.$class.'"><a href="/quotes/example/'.$this->_limit.'/'.($this->_page-1).'">&laquo;</a></li>';
            
            if($start > 1){
                $html .='<li><a href="/'.$this->_limit.'/1">1</a></li>';
                $html .= '<li class="disabled"><span>...</span></li>';
            }
            
            for($i=$start;$i<=$end;$i++){
                $class=($this->page==$i) ? "active" : "";
                $html .= '<li class="'.$class.'"><a href="/quotes/example/'.$this->_limit.'/'.$i.'">'.$i.'</a></li>';;
            }
            
            if($end < $last){
                $html .= '<li class="disabled"><span>...</span</li>';
                $html .= '<li><a href="/quotes/example/'.$this->_limit.'/'.$last.'">'.$last.'</a></li>';
            }
            $class = ($this->_page == $last) ? "disabled" : "";
            $html .= '<li class="'.$class.'"><a href="/quotes/example/'.$this->_limit.'/'.($this->_page + 1).'">&raquo;</a></li>';
            $html .= '</ul>';
            
            return $html;
        }
    }
?>