<?php

namespace App\Service;

use PDOException;

class ExternalDataService extends \PDO
{
    private $dsn;
    private $username;
    private $password;

    public function __construct()
    {
        global $credentials;
        require 'config.php';


        $this->dsn = $credentials['dsn'];
        $this->username = $credentials['username'];
        $this->password = $credentials['password'];

        if (!str_contains($this->dsn, ':')) {
            $dsn = get_cfg_var('pdo.dsn.' . $this->dsn);
            if (!$this->dsn) {
                throw new PDOException('Argument #1 ($dsn) must be a valid data source name');
            }
        }

        parent::__construct($this->dsn, $this->username, $this->password, [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ]);
    }

    public function getExternalGroups(): array
    {
        $sql = "SELECT `nom`, `description`, `commentaire`, `createur`, `modificateur`, `date_modification`, `date_creation` FROM `groupe`";
        $stmt = $this->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getExternalDatas($sqlQuery): array
    {
        $stmt = $this->prepare($sqlQuery);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}