<?php

namespace models;

class Category
{
    private int $id;
    private string $value;
    public function __construct($id, $value)
    {
        $this->setId($id);
        $this->setValue($value);
    }

    public function getId(): int {
        return $this->id;
    }
    public function getValue(): string {
        return $this->value;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setValue(string $value): void  {
        if(empty($value) || strlen($value) > 50) {
            return;
        }
        $this->value = $value;
    }

    public function __toString(): string {
        return $this->value;
    }

    public function equals($category) : bool {
        if($category === null) {
            return false;
        }

        if(!($category instanceof Category)) {
            return false;
        }

        return $this->id === $category->id && $this->value === $category->value;
    }
}