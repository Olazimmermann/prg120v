<?php 
create table if not exists klasse (
  klassekode CHAR(5) NOT NULL,
  klassenavn VARCHAR(50) NOT NULL,
  stadiumkode VARCHAR(50) NOT NULL,
  PRIMARY KEY (klassekode)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

?>
