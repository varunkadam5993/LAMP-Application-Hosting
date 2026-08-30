```php id="91j3ka"
<?php

require_once "db.php";

// Retrieve student records from the database
$query = "
    SELECT id, name, email, phone, course, created_at
    FROM students
    ORDER BY id DESC
";

$studentResult = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AWS Student Portal</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-color: #f4f7fb;
            color: #222;
            font-family: Arial, sans-serif;
        }

        header {
            padding: 25px;
            text-align: center;
            background-color: #232f3e;
            color: #ffffff;
        }

        header h1 {
            margin: 0;
        }

        header p {
            margin: 8px 0 0;
            color: #dddddd;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 35px auto;
        }

        .top-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
        }

        .top-section h2 {
            margin: 0;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 6px;
            background-color: #ff9900;
            color: #ffffff;
            font-weight: bold;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #e68a00;
        }

        .card {
            padding: 25px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }

        th {
            background-color: #232f3e;
            color: #ffffff;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        }

        .empty {
            padding: 30px;
            text-align: center;
            color: #777777;
        }

        footer {
            margin-top: 40px;
            padding: 20px;
            text-align: center;
            color: #666666;
        }

        @media screen and (max-width: 700px) {

            .top-section {
                flex-direction: column;
                align-items: flex-start;
            }

            table {
                font-size: 14px;
            }

        }

    </style>

</head>

<body>

    <header>

        <h1>🎓 AWS Student Portal</h1>

        <p>LAMP Application hosted on AWS</p>

    </header>


    <main class="container">

        <section class="top-section">

            <h2>Student Records</h2>

            <a class="btn" href="add_student.php">
                ➕ Add Student
            </a>

        </section>


        <section class="card">

            <?php if ($studentResult && $studentResult->num_rows > 0): ?>

                <table>

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Course</th>
                            <th>Created At</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($record = $studentResult->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($record["id"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($record["name"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($record["email"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($record["phone"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($record["course"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($record["created_at"]) ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            <?php else: ?>

                <div class="empty">

                    <h3>No students found</h3>

                    <p>
                        Add your first student using the button above.
                    </p>

                </div>

            <?php endif; ?>

        </section>

    </main>


    <footer>

        <p>☁️ AWS LAMP Student Portal</p>

        <p>PHP + Apache + Amazon RDS MySQL</p>

    </footer>

</body>

</html>

<?php

$conn->close();

?>
```
