<?php
class Model{
    protected static $instances = array();

    public $table;

    protected function __construct($table) {
        $this->table = $table;
    }

    public static function getInstance($table) {
        if(! static::$instances[$table]){
            if (file_exists('models/' . $table . '.php')) {
                require_once('models/' . $table . '.php');
                $className = ucfirst($table);
            } else {
                $className = "Model";
            }

            static::$instances[$table] = new $className($table);
        }

        return static::$instances[$table];
    }

    public function add($data) {
        $db = db::getInstance();

        $insertid = $db->insert($this->table, $data);
        if(!$insertid) {
            $errors = $db->error();
            return array('error' => $errors[1], 'message' => $errors[2]);
        }
        // Return inserted user
        return $this->getItem(array($this->table . '.id' => $insertid));
    }

    public function update($data, $where = null) {
        $db = db::getInstance();

        if($where == null) {
            $where = array($this->table . '.id' => $data['id']);
        }

        if(!$db->update($this->table, $data, $where)) {
            $errors = $db->error();
            return array('error' => $errors[1], 'message' => $errors[2]);
        }

        return $this->get($where);
    }

    public function get($where = null) {
        $db = db::getInstance();
        return $db->select($this->table, '*', $where);
    }

    public function delete($where) {
        $db = db::getInstance();
        return $db->delete($this->table, $where);
    }
}
