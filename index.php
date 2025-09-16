<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple CRUD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
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