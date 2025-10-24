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

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $age = $_POST['age'];
                $sex = $_POST['sex'];

                $sql = "INSERT INTO users (name, email, age, sex) VALUES ('$name', '$email', '$age', '$sex')";

                if ($conn->query($sql) === TRUE) {
                    echo "<div class='notification success'><i class='fas fa-check-circle'></i> Record created successfully.</div>";
                } else {
                    echo "<div class='notification error'><i class='fas fa-exclamation-circle'></i> Error: " . $sql . "<br>" . $conn->error . "</div>";
                }
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['view_all'])) {
                $sql = "SELECT id, name, email, age, sex FROM users";
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
                $id = $_POST['id'];
                $age = $_POST['age'];
                $sex = $_POST['sex'];

                if ($id) {
                    $sql = "SELECT id, name, email, age, sex FROM users WHERE id = $id";
                } elseif ($age) {
                    $sql = "SELECT id, name, email, age, sex FROM users WHERE age = $age";
                } elseif ($sex) {
                    $sql = "SELECT id, name, email, age, sex FROM users WHERE sex = '$sex'";
                } else {
                    $sql = "SELECT id, name, email, age, sex FROM users";
                }
            } else {
                $sql = "SELECT id, name, email, age, sex FROM users";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2><i class='fas fa-users'></i> Current Users</h2>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Age</th><th>Sex</th><th>Actions</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["age"] . "</td>";
                    echo "<td>" . $row["sex"] . "</td>";
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
            <h2><i class="fas fa-eye"></i> View and Search Data</h2>
            <form method="post" action="index.php" class="search-form">
                <div class="form-group">
                    <label for="id">Search by ID:</label>
                    <input type="number" id="id" name="id">
                </div>

                <div class="form-group">
                    <label for="age">Search by Age:</label>
                    <input type="number" id="age" name="age">
                </div>

                <div class="form-group">
                    <label for="sex">Search by Sex:</label>
                    <select id="sex" name="sex">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <button type="submit" name="search" class="submit-btn">
                    <i class="fas fa-search"></i> Search
                </button>
                <hr>
                <button type="submit" name="view_all" class="submit-btn">
                    <i class="fas fa-list"></i> View All Records
                </button>
            </form>
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

                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required>
                </div>

                <div class="form-group">
                    <label for="sex">Sex:</label>
                    <select id="sex" name="sex" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <button type="submit" name="create" class="submit-btn">
                    <i class="fas fa-plus"></i> Add User
                </button>
            </form>
        </div>
    </div>
</body>

</html>
