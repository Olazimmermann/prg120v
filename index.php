<?php
CREATE DATABASE IF NOT EXISTS skole
    CHARACTER SET utf8mb4_unicode_ci;
    USE skole;

CREATE TABLE klasse (
    klassekode CHAR(5) NOT NULL,
    klassenavn VARCHAR(50) NOT NULL,
    stadiumkode VARCHAR(50) NOT NULL,
    PRIMARY KEY(klassekode)
);
INSERT INTO klasse VALUES
('IT1', 'IT og ledelse 1. år', 'ITLED1'),
('IT2', 'IT og ledelse 2. år', 'ITLED2'),
('IT3', 'IT og ledelse 3. år', 'ITLED3');

?>
