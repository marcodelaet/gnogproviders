<?php 
class Schema {
    public $sql = '';

    public function create($tablename){
        $this->sql = `CREATE TABLE $tablename IF NOT EXIST (`;
    }

    private function add($field){
        if($this->sql != ''){
            $this->sql .= $field;
        }
    }

    public function text($fieldname,$size,$optNotNull){
        if($size){
            $size=`($size)`;
        }
        if(!$optNotNull){
            $optNotNull='NOT NULL';
        }
        $this->add(` $fieldname VARCHAR$size $optNotNull`);

    }
}
