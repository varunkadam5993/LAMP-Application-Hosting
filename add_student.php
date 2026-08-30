```php
<?php

require_once "db.php";

$statusMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentName  = trim($_POST["name"] ?? "");
    $studentEmail = trim($_POST["email"] ?? "");
    $studentPhone = trim($_POST["phone"] ?? "");
    $studentCourse = trim($_POST["course"] ?? "");

    // Validate form data
    if (empty($studentName) || empty($studentEmail) || empty($studentCourse)) {

        $statusMessage = "Please complete all required fields.";

    } elseif (!filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {

        $statusMessage = "Enter a valid email address.";

    } else {

        $sql = "INSERT INTO students (name, email, phone, course)
                VALUES (?, ?, ?, ?)";

        $query = $conn->prepare($sql);

        if ($query) {

            $query->bind_param(
                "ssss",
                $studentName,
                $studentEmail,
                $studentPhone,
                $studentCourse
            );

            if ($query->execute()) {
                $statusMessage = "Student added successfully!";
            } else {
                $statusMessage = "Unable to add student: " . $query->error;
            }

            $query->close();

        } else {
            $statusMessage = "Unable to prepare database query.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Student - AWS Student Portal</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f7fb;
        }

        .header {
            padding: 25px;
            text-align: center;
            color: #ffffff;
            background-color: #232f3e;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            margin-bottom: 0;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input:focus {
            outline: none;
            border-color: #1976d2;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 13px;
            border: none;
            border-radius: 6px;
            background-color: #ff9900;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #e68900;
        }

        .message {
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 6px;
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .back {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #1976d2;
            text-decoration: none;
        }

        .back:hover {
            text-decoration: underline;
        }

    </style>

</head>

<body>

    <header class="header">
        <h1>🎓 AWS Student Portal</h1>
        <p>Add Student</p>
    </header>

    <main class="container">

        <h2>👨‍🎓 Student Registration</h2>

        <?php if (!empty($statusMessage)) : ?>

            <div class="message">
                <?= htmlspecialchars($statusMessage) ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <label for="name">Student Name *</label>

            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter student name"
                required
            >

            <label for="email">Email *</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter email address"
                required
            >

            <label for="phone">Phone</label>

            <input
                type="text"
                id="phone"
                name="phone"
                placeholder="Enter phone number"
            >

            <label for="course">Course *</label>

            <input
                type="text"
                id="course"
                name="course"
                placeholder="Enter course"
                required
            >

            <button type="submit">
                ➕ Add Student
            </button>

        </form>

        <a href="index.php" class="back">
            ← Back to Student Portal
        </a>

    </main>

</body>

</html>
```
