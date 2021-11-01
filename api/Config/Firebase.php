<?php

use Kreait\Firebase\Factory;

class Firebase {

    protected $database;
    protected $dbname;

    public function __construct($data) {
        $this->dbname = $data;

        $factory = (new Factory())->withServiceAccount(__DIR__ . '/firebase.json');
        $this->database = $factory->createDatabase();
    }

    public function get(string $tableID = null) {
        if (empty($tableID) || !isset($tableID)) {
            return false;
        }
        if ($this->database->getReference($this->dbname)->getSnapshot()->hasChild($tableID)) {
            return $this->database->getReference($this->dbname)->getChild($tableID)->getValue();
        } else {
            return false;
        }
    }

    public function update(string $tableID = null, string $data = null) {
        if ((empty($tableID) || !isset($tableID)) &&
                (empty($data) || !isset($data))) {
            return false;
        }
        $this->database->getReference($this->dbname)->getChild($tableID)->set($data);
    }

    public function delete(int $tableID) {
        if (empty($tableID) || !isset($tableID)) {
            return false;
        }

        if ($this->database->getReference($this->dbname)->getSnapshot()->hasChild($tableID)) {
            $this->database->getReference($this->dbname)->getChild($tableID)->remove();
            return true;
        } else {
            return false;
        }
    }

}

// $firebase = new Firebase('services');

// for($i=2; $i < 30; $i++ ){
//     print($firebase->update($i));
// }
