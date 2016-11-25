<?php
    require_once('AppController.php');
    class Paginator {
        private $obj;
        private $_limit;
        private $_page;
        private $_total;
        
        public function __construct($table){
            $this->obj = new AppController();
            $this->_total = count($this->obj->custom("SELECT * FROM $table"));
        }
        
        public function getData($table,$order,$limit = 10, $page = 1){
            $this->_limit = $limit;
            $this->_page = $page;
            
            if($this->_limit=='all'){
                $rs=$this->obj->find_by($table,$row,$val);
            } else{
                $count = (($this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
                $rs=$this->obj->custom("SELECT * FROM $table ORDER BY ".$order." LIMIT $count");
            }
            
            $result = new stdClass();
            $result->page = $this->_page;
            $result->limit = $this->_limit;
            $result->total = $this->_total;
            $result->data = $rs;
            return $result;
        }
        
        public function createLinks($links, $list_class,$URI,$l=''){
            if($this->_limit=='all')
                return '';
            $last = ceil($this->_total / $this->_limit);
            $start = (($this->_page - $links)>0) ? $this->_page - $links : 1;
            $end = (($this->_page + $links) < $last) ? $this->_page + $links : $last;
            
            $html = '<ul class="'.$list_class.'">';
            
            $class = ($this->_page==1) ? "disabled" : "";
            $html .= '<li class="'.$class.'"><a href="'.$URI.'/'.($this->_page-1).''.$l.'" rel="prev"><span aria-hidden="true">&laquo;</span></a></li>';
            
            if($start > 1){
                $html .='<li><a href="'.$URI.'/1'.$l.'">1</a></li>';
                $html .= '<li class="disabled"><span>...</span></li>';
            }
            
            for($i=$start;$i<=$end;$i++){
                $class=($this->_page==$i) ? "active" : "";
                $html .= '<li class="'.$class.'"><a href="'.$URI.'/'.$i.''.$l.'">'.$i.'</a></li>';
            }
            
            if($end < $last){
                $html .= '<li class="disabled"><span>...</span</li>';
                $html .= '<li><a href="'.$URI.'/'.$last.''.$l.'">'.$last.'</a></li>';
            }
            $class = ($this->_page == $last) ? "disabled" : "";
            $html .= '<li class="'.$class.'"><a href="'.$URI.'/'.($this->_page + 1).''.$l.'" rel="next"><span aria-hidden="true">&raquo;</span></a></li>';
            $html .= '</ul>';
            
            return $html;
        }
    }
?>