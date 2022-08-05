<?php

namespace App;

class Connection
{
    private \PDO $dbh;
    
    public function __construct()
    {
        $dbName = getenv('MYSQL_DATABASE') ?: 'mydb';
        $userName = getenv('MYSQL_USER') ?: 'admin';
        $pass = getenv('MYSQL_PASSWORD') ?: 'secret';
        $this->dbh = new \PDO("mysql:host=mysql;dbname=$dbName", $userName, $pass);
    }
    
    public function query(string $sql, array $params = [], $class = \stdClass::class): array
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
    }
}
