CREATE DATABASE fac;

USE fac;

CREATE TABLE faculty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    facultyID VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    birthdate DATE NOT NULL,                 -- Admin's birthdate (used for verification)
    fav_color VARCHAR(50) NOT NULL 
);
