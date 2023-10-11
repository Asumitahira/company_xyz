<?php
    function connection() {
        $server_name = "localhost";
        $username = "root";
        $password = "root";
        $db_name = "company_xyz";

        $conn = new mysqli($server_name, $username, $password, $db_name);

        if ($conn->connect_error) {
            die("connection to the databasse failed. " . $conn->connect_error);
        }else {
            return $conn;
        }
    }
