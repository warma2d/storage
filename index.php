<?php

//warma2d

require_once 'StorageClass.php';

class TxtStorage extends Storage
{

    const STORAGE_FILE = 'serializedStorage.txt';

    public function save($serializedStorage)
    {
        file_put_contents(self::STORAGE_FILE, $serializedStorage);
    }

    public function load()
    {
        if (!file_exists(self::STORAGE_FILE)) {
            file_put_contents(self::STORAGE_FILE, '');
        }
        return file_get_contents(self::STORAGE_FILE);
    }
}

$storage = new TxtStorage();
$storage->set('city\coord\x', '10');
$storage->set('city\coord\y', '5');

var_dump($storage->get('city'));//array(1) {["coord"]=>array(2){["x"]=>string(2) "10" ["y"]=>string(1) "5"}}
var_dump($storage->get('city\coord'));//array(2) {["x"]=>string(2) "10" ["y"]=>string(1) "5"}
var_dump($storage->get('city\coord\y'));//string(1) "5"
