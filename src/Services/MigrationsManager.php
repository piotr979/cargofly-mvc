<?php

namespace App\Services;

use App\Models\Database\PDOClient;

/**
 * This is simple migration 
 */
class MigrationsManager
{
    private string $sql;
    private $db;

    public function __construct()
    {
        $this->setSql();
        $this->migrate();
    }
    private function setSql()
    {
        $this->notInUse =
        "
        CREATE TABLE country
        (
            id INT NOT NULL AUTO_INCREMENT,
            code VARCHAR(2) NOT NULL,
            country VARCHAR(100) NOT NULL,
            PRIMARY KEY(id)
        );

        CREATE TABLE city
        (
            id INT AUTO_INCREMENT PRIMARY KEY ,
            code 
            city VARCHAR(100)NOT NULL,
            country_id INT,
            location POINT NOT NULL,
            FOREIGN KEY (country_id) REFERENCES country(id)
        );
        ";

        $this->sql = 
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

            CREATE TABLE plane
            (
                id INT NOT NULL AUTO_INCREMENT,
                plane_name VARCHAR(100) NOT NULL,
                capacity INT NOT NULL,
                photo JSON NOT NULL,
                hours_done INT NOT NULL,
                in_use BOOLEAN NOT NULL DEFAULT FALSE,
                airport_base INT NOT NULL,
                PRIMARY KEY(id),
                FOREIGN KEY (airport_base) REFERENCES airport(id)
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

            CREATE TABLE plane_cargos
            (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                plane_id INT NOT NULL,
                cargo_id INT NOT NULL,
                FOREIGN KEY (cargo_id) REFERENCES cargo(id),
                FOREIGN KEY (plane_id) REFERENCES plane(id)
            );

            CREATE TABLE customer
            (
                id INT NOT NULL AUTO_INCREMENT,
                customer_name VARCHAR(100) NOT NULL,
                owner_fname VARCHAR(100) NOT NULL,
                owner_lname VARCHAR(100) NOT NULL,
                street1 VARCHAR(100) NOT NULL,
                street2 VARCHAR(100),
                city VARCHAR(100),
                zip_code VARCHAR(100),
                country VARCHAR(100),
                vat VARCHAR(100),
                logo JSON,
                cargos INT,
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
        ";

        $userSql = "CREATE TABLE user
        (
            id INT NOT NULL AUTO_INCREMENT PRIMARY_KEY,
            login VARCHAR(40) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(50) NOT NULL DEFAULT 'ROLE_USER'
        );"
        ;
    }
    private function migrate()
    {
        $this->db = new PDOClient(DB_DRIVER, DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
        $this->db->connect();
        $conn = $this->db->getConnection();
        
        $stmt = $conn->prepare($this->sql);
        $stmt->execute();
    }
}