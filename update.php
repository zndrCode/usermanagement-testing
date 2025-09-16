<?php
include 'db_connect.php';

$id = "";
$name = "";
$email = "";

// Get user data for the form
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT name, email FROM users WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
    }
}

// Update user data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirect after successful update
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Update User</title>
</head>

<body>
    <h2>Update User</h2>
    <form method="post" action="update.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        Name: <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br><br>
        Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>
        <input type="submit" name="update" value="Update User">
    </form>
</body>

</html>