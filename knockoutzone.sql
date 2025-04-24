CREATE DATABASE Knockoutzone;
USE Knockoutzone;

CREATE TABLE Users (
	id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL, -- Username
    email VARCHAR(75) UNIQUE NOT NULL,
    password VARCHAR(90) UNIQUE NOT NULL -- User Password

    ALTER TABLE users ADD COLUMN profile_img VARCHAR(255);

);