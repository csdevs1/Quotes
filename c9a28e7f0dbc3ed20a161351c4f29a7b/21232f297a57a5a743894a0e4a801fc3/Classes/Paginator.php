<?php
    require_once('AppController.php');
    class Paginator {
        private $obj;
        private $_limit;
        private $_page;
        private $_total;
        
        public function __construct($table){
            $this->obj = new AppController();
            //$this->_total = count($this->obj->all($table));
            $this->_total = $this->obj->custom("SELECT COUNT(*) as c FROM $table");
        }
        
        public function getData($table,$order_by,$limit = 10, $page = 1){
            $this->_limit = $limit;
            $this->_page = $page;
            
            if($this->_limit=='all'){
                $rs=$this->obj->find_by($table,$row,$val);
            } else{
                $count = (($this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
                $rs=$this->obj->custom("SELECT * FROM $table ORDER BY $order_by LIMIT $count");
            }
            
            $result = new stdClass();
            $result->page = $this->_page;
            $result->limit = $this->_limit;
            $result->total = $this->_total;
            $result->data = $rs;
            $result->countw = $count;
            return $result;
        }
        
        public function createLinks($links,$list_class,$type=''){
            if($this->_limit=='all')
                return '';
            $last = ceil($this->_total[0]['c'] / $this->_limit);
            $start = (($this->_page - $links)>0) ? $this->_page - $links : 1;
            $end = (($this->_page + $links) < $last) ? $this->_page + $links : $last;

            $html = '<ul class="'.$list_class.'">';
            if($type=='quotes'){
                $class = ($this->_page==1) ? "disabled" : "";
                $html .= '<li class="'.$class.'"><a onclick="english(document.getElementById(\'eng\'),'.($this->_page-1).')">&laquo;</a></li>';

                if($start > 1){
                    $html .='<li><a onclick="english(document.getElementById(\'eng\'),1)">1</a></li>';
                    $html .= '<li class="disabled"><span>...</span></li>';
                }

                for($i=$start;$i<=$end;$i++){
                    $class=($this->_page==$i) ? "active" : "";
                    $html .= '<li class="'.$class.'"><a onclick="english(document.getElementById(\'eng\'),'.$i.')">'.$i.'</a></li>';
                }

                if($end < $last){
                    $html .= '<li class="disabled"><span>...</span</li>';
                    $html .= '<li><a onclick="english(document.getElementById(\'eng\'),'.$last.')">'.$last.'</a></li>';
                }
                $class = ($this->_page == $last) ? "disabled" : "";
                $html .= '<li class="'.$class.'"><a onclick="english(document.getElementById(\'eng\'),'.($this->_page + 1).')">&raquo;</a></li>';
                $html .= '</ul>';
            }elseif($type=='authors'){
                $class = ($this->_page==1) ? "disabled" : "";
                $html .= '<li class="'.$class.'"><a onclick="authors(document.getElementById(\'authors-eng\'),'.($this->_page-1).')">&laquo;</a></li>';

                if($start > 1){
                    $html .='<li><a onclick="authors(document.getElementById(\'authors-eng\'),1)">1</a></li>';
                    $html .= '<li class="disabled"><span>...</span></li>';
                }

                for($i=$start;$i<=$end;$i++){
                    $class=($this->_page==$i) ? "active" : "";
                    $html .= '<li class="'.$class.'"><a onclick="authors(document.getElementById(\'authors-eng\'),'.$i.')">'.$i.'</a></li>';
                }

                if($end < $last){
                    $html .= '<li class="disabled"><span>...</span</li>';
                    $html .= '<li><a onclick="authors(document.getElementById(\'authors-eng\'),'.$last.')">'.$last.'</a></li>';
                }
                $class = ($this->_page == $last) ? "disabled" : "";
                $html .= '<li class="'.$class.'"><a onclick="authors(document.getElementById(\'authors-eng\'),'.($this->_page + 1).')">&raquo;</a></li>';
                $html .= '</ul>';
            }elseif($type=='myAuthors'){
                $class = ($this->_page==1) ? "disabled" : "";
                $html .= '<li class="'.$class.'"><a onclick="myAuthors(document.getElementById(\'my-authors\'),'.($this->_page-1).')">&laquo;</a></li>';

                if($start > 1){
                    $html .='<li><a onclick="myAuthors(document.getElementById(\'my-authors\'),1)">1</a></li>';
                    $html .= '<li class="disabled"><span>...</span></li>';
                }

                for($i=$start;$i<=$end;$i++){
                    $class=($this->_page==$i) ? "active" : "";
                    $html .= '<li class="'.$class.'"><a onclick="myAuthors(document.getElementById(\'my-authors\'),'.$i.')">'.$i.'</a></li>';
                }

                if($end < $last){
                    $html .= '<li class="disabled"><span>...</span</li>';
                    $html .= '<li><a onclick="myAuthors(document.getElementById(\'my-authors\'),'.$last.')">'.$last.'</a></li>';
                }
                $class = ($this->_page == $last) ? "disabled" : "";
                $html .= '<li class="'.$class.'"><a onclick="myAuthors(document.getElementById(\'my-authors\'),'.($this->_page + 1).')">&raquo;</a></li>';
                $html .= '</ul>';
            }else{
                $class = ($this->_page==1) ? "disabled" : "";
                $html .= '<li class="'.$class.'"><a onclick="myQuotes(document.getElementById(\'my-authors\'),'.($this->_page-1).')">&laquo;</a></li>';

                if($start > 1){
                    $html .='<li><a onclick="myQuotes(document.getElementById(\'my-authors\'),1)">1</a></li>';
                    $html .= '<li class="disabled"><span>...</span></li>';
                }

                for($i=$start;$i<=$end;$i++){
                    $class=($this->_page==$i) ? "active" : "";
                    $html .= '<li class="'.$class.'"><a onclick="myQuotes(document.getElementById(\'my-quotes\'),'.$i.')">'.$i.'</a></li>';
                }

                if($end < $last){
                    $html .= '<li class="disabled"><span>...</span</li>';
                    $html .= '<li><a onclick="myQuotes(document.getElementById(\'my-quotes\'),'.$last.')">'.$last.'</a></li>';
                }
                $class = ($this->_page == $last) ? "disabled" : "";
                $html .= '<li class="'.$class.'"><a onclick="myQuotes(document.getElementById(\'my-quotes\'),'.($this->_page + 1).')">&raquo;</a></li>';
                $html .= '</ul>';
            }
            
            return $html;
        }
    }
?>
