<?php
/**
 * Created by PhpStorm.
 * User: horoshii
 * Date: 21.07.2015
 * Time: 16:26
 */

class SProductDB {
    protected $_db;
    const DB_NAME = 'product.db';
    function __construct() {
        if(is_file(self::DB_NAME)){
            $this->_db = new SQLite3(self::DB_NAME);
        }else{
            $this->_db = new SQLite3(self::DB_NAME);
            $sql = "CREATE TABLE products(id INTEGER PRIMARY KEY AUTOINCREMENT,type TEXT,firstname TEXT,
                                          mainname TEXT,
                                          title TEXT,
                                          price FLOAT,
                                          numpages int,
                                          playlength int,
                                          discount int
                                          )";
            $this->_db->exec($sql) or die($this->_db->lastErrorMsg());
        }
    function __destruct(){
         unset($this->_db);
        }

    }
}
$db = new SProductDB();