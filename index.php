-- Opprett database (hopp over hvis du allerede har en)
CREATE DATABASE IF NOT EXISTS skole
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE skole;

-- Dropp hvis finnes (kun for testing)
DROP TABLE IF EXISTS student;
DROP TABLE IF EXISTS klasse;

-- Tabeller (som i oppgaven)
CREATE TABLE klasse (
  klassekode CHAR(5) NOT NULL,
  klassenavn VARCHAR(50) NOT NULL,
  studiumkode VARCHAR(50) NOT NULL,
  PRIMARY KEY (klassekode)
);

CREATE TABLE student (
  brukernavn CHAR(7) NOT NULL,
  fornavn VARCHAR(50) NOT NULL,
  etternavn VARCHAR(50) NOT NULL,
  klassekode CHAR(5) NOT NULL,
  PRIMARY KEY (brukernavn),
  FOREIGN KEY (klassekode) REFERENCES klasse (klassekode)
);

-- Eksempeldata fra oppgaveteksten
INSERT INTO klasse (klassekode, klassenavn, studiumkode) VALUES
('IT1',  'IT og ledelse 1. år', 'ITLED'),
('IT2',  'IT og ledelse 2. år', 'ITLED'),
('IT3',  'IT og ledelse 3. år', 'ITLED');

INSERT INTO student (brukernavn, fornavn, etternavn, klassekode) VALUES
('gb',  'Geir',  'Bjarvin',     'IT1'),
('mrj', 'Marius','R. Johannessen','IT1'),
('tb',  'Tove',  'Bøe',         'IT2');
