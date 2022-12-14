<?php

namespace App\Models\Entities;

abstract class AbstractEntity 
{
    protected ?int $id = null;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
}