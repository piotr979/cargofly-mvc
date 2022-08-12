<?php

namespace App\Models\Entities;

abstract class AbstractEntity
{
    protected ?int $id = null;
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getById($id)
    {
      //  $item = $this->conn->getById($id);

    }
}