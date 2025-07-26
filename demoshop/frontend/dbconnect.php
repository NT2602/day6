<?php
const DBHOST = "localhost";
const DBUSER = "root";
const PWD = '';
const DBNAME = "myshop";

function connectDb() {
    $conn = new mysqli(DBHOST, DBUSER, PWD, DBNAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}