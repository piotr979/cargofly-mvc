<?php

namespace App\Services;

use App\Models\Database\PDOClient;

/**
 * This is simple migration 
 */
class MigrationsManager
{
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connect();

    }

    public function migrateDatabase()
    {
    
        $sql = 
        "
            CREATE TABLE airport 
            (
                id INT NOT NULL AUTO_INCREMENT ,
                code VARCHAR(3) NOT NULL,
                airport_name VARCHAR(100) NOT NULL,
                city VARCHAR(100) NOT NULL,
                country VARCHAR(100) NOT NULL,
                location POINT NOT NULL,
                elevation INT,
                PRIMARY KEY(id)
            );

            CREATE TABLE route
            (
                id INT NOT NULL AUTO_INCREMENT,
                airport_from INT NOT NULL,
                airport_to INT NOT NULL,
                flying_time TIME NOT NULL,
                PRIMARY KEY(id),
                FOREIGN KEY (airport_from) REFERENCES airport(id),
                FOREIGN KEY (airport_to) REFERENCES airport(id)
            );

            CREATE TABLE aircraft
            (
                id INT NOT NULL AUTO_INCREMENT,
                aircraft_name VARCHAR(100) NOT NULL,
                hours_done INT NOT NULL,
                in_use BOOLEAN NOT NULL DEFAULT FALSE,
                airport_base INT NOT NULL,
                aeroplane INT NOT NULL
                PRIMARY KEY(id),
                FOREIGN KEY (airport_base) REFERENCES airport(id),
                FOREIGN KEY (aeroplane) REFERENCES aeroplane(id)
            );

            CREATE TABLE aeroplane
            (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                vendor VARCHAR(40) NOT NULL,
                photo VARCHAR(200),
                model VARCHAR(40) NOT NULL,
                distance INT NOT NULL,
                payload INT NOT NULL
            );

            CREATE TABLE cargo 
            (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                value FLOAT NOT NULL,
                airport_from INT NOT NULL,
                airport_to INT NOT NULL,
                time_taken TIME NOT NULL,
                FOREIGN KEY (airport_from) REFERENCES airport(id),
                FOREIGN KEY (airport_to) REFERENCES airport(id)
            );

            CREATE TABLE aircraft_cargos
            (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                aircraft_id INT NOT NULL,
                cargo_id INT NOT NULL,
                FOREIGN KEY (cargo_id) REFERENCES cargo(id),
                FOREIGN KEY (aircraft_id) REFERENCES aircraft(id)
            );

            CREATE TABLE customer
            (
                id INT NOT NULL AUTO_INCREMENT,
                customer_name VARCHAR(100) NOT NULL,
                owner_fname VARCHAR(100) NOT NULL,
                owner_lname VARCHAR(100) NOT NULL,
                street1 VARCHAR(100) NOT NULL,
                street2 VARCHAR(100),
                city VARCHAR(100) NOT NULL,
                zip_code VARCHAR(100) NOT NULL,
                country VARCHAR(100) NOT NULL,
                vat VARCHAR(100) NOT NULL,
                logo VARCHAR(255),
                PRIMARY KEY(id)
            );

            CREATE TABLE customer_cargos
            (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                cargo_id INT NOT NULL,
                FOREIGN KEY (customer_id) REFERENCES customer(id),
                FOREIGN KEY (cargo_id) REFERENCES cargo(id) 
            );

            CREATE TABLE user
        (
            id INT NOT NULL AUTO_INCREMENT PRIMARY_KEY,
            login VARCHAR(40) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(50) NOT NULL DEFAULT 'ROLE_USER'
        );
        ";

      $this->executeSql($sql);
    }

    public function dropAllTables()
    {
        /**
         * Script taken from
         * https://stackoverflow.com/a/12403746/1496972
         */
        $deleteTablesSql = "
        SET FOREIGN_KEY_CHECKS = 0;
        SET @tables = null;
        SELECT GROUP_CONCAT('`',  table_schema, '`.`', table_name, '`') INTO @tables
            FROM information_schema.tables WHERE table_schema = 'cargo_mvc';
        SET @tables = CONCAT('DROP TABLE ', @tables);
        PREPARE stmt FROM @tables;
        EXECUTE stmt;
        DEAALOCATE PREPARE stmt;
        SET FOREIGN_KEY_CHECKS = 1;
        ";

        $this->executeSql($deleteTablesSql);
    }
    private function connect()
    {
        $this->db = new PDOClient(DB_DRIVER, DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
        $this->db->connect();

        return $this->db->getConnection();
    }
    private function executeSql(string $sql)
    {
        $this->conn = $this->connect();
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    }
}