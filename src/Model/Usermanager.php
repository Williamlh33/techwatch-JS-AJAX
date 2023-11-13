<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'users';

    public function selectOneByIdentifiant($identifiant): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE email=:identifiant OR username=:identifiant");
        $statement->bindValue(':identifiant', $identifiant, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}