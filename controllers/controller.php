<?php

require_once 'models/model.php';

class Controller {

    protected $table;
    protected static $instances = array();

    public function Controller($table) {
        if ($table) {
            $this->table = $table;
        }

        $this->model = Model::getInstance($table);
    }
    
    public static function create($table) {
        if (!static::$instances[$table]) {
            if (file_exists('controllers/' . $table . '-controller.php')) {
                $className = ucfirst($table) . 'Controller';
                require_once 'controllers/' . $className . '.php';
            } else {
                $className = 'Controller';
            }

            static::$instances[$table] = new $className($table);
        }

        return static::$instances[$table];
    }

    public function getFilterConditions($filters) {
        $where = array();

        if ($filters) {
            $tableName = $this->model->table;

            foreach ($filters as $key => $value) {
                $columnName = $tableName . '.' . $key;
                $where[$columnName] = $filters[$key];
            }
        }

        return $where;
    }

    public function get() {
        $where = self::getFilterConditions($_GET['filter']);

        return $this->model->get($where);
    }

    public function update() {
        $postData = file_get_contents('php://input');
        if ($postData) {
            $POST = json_decode($postData, true);
        }

        $where = self::getFilterConditions($POST['filter']);

        return $this->model->update($POST['data'], $where);
    }

    public function delete() {
        $postData = file_get_contents('php://input');
        if ($postData) {
            $POST = json_decode($postData, true);
        }

        // This means be carefull when using the DELETE method...
        $where = self::getFilterConditions($POST['filter']);

        return $this->model->delete($where) ? "success" : "record does'nt exists";
    }

    public function validate($data) {
        return true;
    }

    public function post() {
        $postData = file_get_contents('php://input');
        if ($postData) {
            $_POST = json_decode($postData, true);
        }

        $data = $_POST['data'];

        return $this->model->add($data);
    }

}
