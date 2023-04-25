<?php

namespace objects;

class User
{
    private int $id;
    private string $login;
    private string $password;
    private bool $premium;
    public function __construct(int $id, string $login, string $password, bool $premium = false)
    {
        $this->setId($id);
        $this->setLogin($login);
        $this->setPassword($password);
        $this->setPremium($premium);
    }


    public function getId(): int {
        return $this->id;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getPremium(): bool {
        return $this->premium;
    }

    public function setId(int $id): void  {
        $this->id = $id;
    }

    public function setLogin(string $login): void {
        if(!empty($login)) {
            $this->login = $login;
        }
    }

    public function setPassword(string $password): void {
        if(!empty($password)) {
            $this->password = $password;
        }
    }

    public function setPremium(bool $premium): void {
        $this->premium = $premium;
    }
}