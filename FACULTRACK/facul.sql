CREATE DATABASE facultrack;

USE facultrack;

CREATE TABLE faculty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    facultyID VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
