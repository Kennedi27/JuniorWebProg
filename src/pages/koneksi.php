<?php
    error_reporting(0);
    define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD", "");
    define("DATABASE", "jwp_kennedi");

    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

    if ($conn -> connect_errno) {
        echo "Failed to Connect Database: " . $conn -> connect_error;
        exit();
    }