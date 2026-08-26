<?php

abstract class AbstractEntityManager
{
    protected $db;

    public function __construct()
    {
        $this->db = new DBManager();
    }
}