<?php
    require_once('connection.php');
    class AppController extends DBManager {
        var $con;
        function AppController(){
            $this->con=new DBManager;
        }
        private function consulta_sql($sql) {
            $result=null;
            if($this->con->conectar()==true){
                $result=mysql_query($sql);
                return $result;
            }
        }
        private function save_record($sql){
            if($this->con->conectar()==true){
                return mysql_query($sql);
            }
        }
        
        public function all($table) {
            $sql="SELECT * FROM $table";
            $res=$this->consulta_sql($sql);
            $lista=array();
            while($row=mysql_fetch_assoc($res)) {
                $lista[]=$row;
            }
            return $lista;
        }
        public function custom($sql) {
            $res=$this->consulta_sql($sql);
            $lista=array();
            while($row=mysql_fetch_assoc($res)) {
                $lista[]=$row;
            }
            return $lista;
        }
        
        public function like($table,$pattern) {
            $sql="SELECT * FROM $table WHERE $pattern;";
            //return $sql;
            $res=$this->consulta_sql($sql);
            $lista=array();
            while($row=mysql_fetch_assoc($res)) {
                $lista[]=$row;
            }
            return $lista;
        }
        
        public function find($table,$id) {
            $sql="SELECT * FROM $table WHERE id='$id';";
            $res=$this->consulta_sql($sql);
            $lista=array();
            while($row=mysql_fetch_assoc($res)) {
                $lista[]=$row;
            }
            return $lista;
        }
        
        public function find_by($table,$row,$val) {
            $sql="SELECT * FROM $table WHERE $row='$val';";
            //return $sql;
            $res=$this->consulta_sql($sql);
            $lista=array();
            while($row=mysql_fetch_assoc($res)) {
                if(!empty($row) && isset($row) && !is_null($row) && $row!=" ")
                    $lista[]=$row;
            }
            return $lista;
        }
        
        public function limit($column,$table,$limit,$order) {
            $sql="SELECT $column FROM $table ORDER BY $order DESC LIMIT $limit;";
            //return $sql;
            $res=$this->consulta_sql($sql);
            $lista=array();
            while($row=mysql_fetch_assoc($res)) {
                if(!empty($row) && isset($row) && !is_null($row) && $row!=" ")
                    $lista[]=$row;
            }
            return $lista;
        }
        
        public function join($columns,$table,$tables,$join_on,$where_col,$id,$order_by="") {
            $sql= "SELECT $columns
            FROM $table";
            for($i=0;$i<count($tables);$i++){
                $sql .= " INNER JOIN $tables[$i] ON ";
                for($a=0;$a<1;$a++){
                   $sql .= $join_on[$i][$a]."=".$join_on[$i][$a+1]." ";
                }
            }
            
            $sql .= "WHERE $where_col=$id ";
            if(!empty($order_by)){
                $sql .= "ORDER BY $order_by";
            }
            //return $sql;
            $res=$this->consulta_sql($sql);
            $lista=array();
            while($row=mysql_fetch_assoc($res)) {
                $lista[]=$row;
            }
            return $lista;
        }
        
        public function save($table,$columns,$values){
            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
            //return $sql;
            $res = $this->save_record($sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }
        
        public function update($table,$values,$row,$id){
            $sql = "UPDATE $table SET $values WHERE $row=$id";
           // return $sql;
            $res = $this->save_record($sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }
        
        public function delete($table,$row,$val){
            $sql = "DELETE FROM $table WHERE $row=$val";
            //return $sql;
            $res = $this->save_record($sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }
        
    }
?>