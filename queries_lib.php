<?php 

// This variable contains an SQL query to select all users from a table
$getAllUsers = "SELECT * FROM `mytable` ";

// This variable contains an SQL query to insert a new user into a table
$insertUser = "INSERT INTO `mytable` (Name, email) VALUES (?, ?)";