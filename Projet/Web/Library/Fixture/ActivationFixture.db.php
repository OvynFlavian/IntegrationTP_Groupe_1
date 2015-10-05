<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 5/10/2015
 * Time: 08:56
 */

class ActivationFixture {
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function initTable()
    {
        $query = $this
            ->db
            ->prepare("ALTER TABLE activation AUTO_INCREMENT = 1");
        $query->execute(array());
    }

    public function deleteAllFromTable()
    {
        $query = $this
            ->db
            ->prepare("DELETE FROM activation");

        $query->execute(array());
    }
}