# hair_salon

#MySQL commands used:
CREATE DATABASE hair_salon;
USE hair_salon;
CREATE TABLE stylists (name VARCHAR (255), id serial PRIMARY KEY);
CREATE TABLE clients (name VARCHAR (255), stylist_id INT, id serial PRIMARY KEY);
(copy to hair_salon_test using phpmyadmin)
