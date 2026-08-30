```php
<?php

// Database configuration
$dbServer   = "YOUR_RDS_ENDPOINT";
$dbUser     = "admin";
$dbPassword = "YOUR_RDS_PASSWORD";
$dbName     = "student_db";
$dbPort     = 3306;

// Establish database connection
$conn = new mysqli(
    $dbServer,
    $dbUser,
    $dbPassword,
    $dbName,
    $dbPort
);

// Stop execution if the connection cannot be established
if ($conn->connect_errno) {
    exit("Unable to connect to the database: " . $conn->connect_error);
}

// Use UTF-8 encoding for database communication
$conn->set_charset("utf8mb4");

?>
```
