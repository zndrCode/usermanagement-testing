<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple CRUD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .notification {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-weight: 500;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .actions a {
            text-decoration: none;
            margin-right: 15px;
            padding: 8px 12px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .edit-btn {
            color: #3498db;
            border: 1px solid #3498db;
        }

        .edit-btn:hover {
            background-color: #3498db;
            color: white;
        }

        .delete-btn {
            color: #e74c3c;
            border: 1px solid #e74c3c;
        }

        .delete-btn:hover {
            background-color: #e74c3c;
            color: white;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .submit-btn {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        hr {
            border: none;
            height: 1px;
            background: linear-gradient(to right, transparent, #ddd, transparent);
            margin: 40px 0;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 60px;
            margin-bottom: 20px;
            color: #bdc3c7;
        }

        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
            }

            .card {
                padding: 15px;
            }

            th,
            td {
                padding: 10px;
            }

            .actions a {
                display: inline-block;
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-database"></i> Simple CRUD Application</h1>
            <p>Create, Read, Update and Delete Users</p>
        </header>

        <div class="card">
            <?php
            include 'db_connect.php';

            // Create Operation
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];

                $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";

                if ($conn->query($sql) === TRUE) {
                    echo "<div class='notification success'><i class='fas fa-check-circle'></i> Record created successfully.</div>";
                } else {
                    echo "<div class='notification error'><i class='fas fa-exclamation-circle'></i> Error: " . $sql . "<br>" . $conn->error . "</div>";
                }
            }

            // Read Operation
            $sql = "SELECT id, name, email FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2><i class='fas fa-users'></i> Current Users</h2>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td class='actions'>";
                    echo "<a class='edit-btn' href='update.php?id=" . $row["id"] . "'><i class='fas fa-edit'></i> Edit</a>";
                    echo "<a class='delete-btn' href='delete.php?id=" . $row["id"] . "'><i class='fas fa-trash'></i> Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<div class='empty-state'>";
                echo "<i class='fas fa-user-slash'></i>";
                echo "<h3>No users found</h3>";
                echo "<p>Add your first user using the form below</p>";
                echo "</div>";
            }
            ?>
        </div>

        <hr>

        <div class="card">
            <h2><i class="fas fa-user-plus"></i> Add New User</h2>
            <form method="post" action="index.php">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <button type="submit" name="create" class="submit-btn">
                    <i class="fas fa-plus"></i> Add User
                </button>
            </form>
        </div>
    </div>
</body>

</html>