<?php


class DB
{

   private $dbh;

   private $className = 'stdClass';

   private static $instance;

    private function __construct()
    {
        $this->dbh = new PDO('mysql:dbname=test;host=localhost', 'root',null);
    }

    public function setClassName($className)
    {
        $this->className = $className;
    }


    public function query($sql, $params=[])
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll(PDO::FETCH_CLASS, $this->className);
    }

    public function execute($sql, $params=[])
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params);

    }

    public function exist($sql)
    {

    }

    public function getConnect()
    {
        return $this->dbh;
    }


    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance()
    {

        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }





}