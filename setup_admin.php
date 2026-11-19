
<?php
require_once "db.php";
session_start();

$message = "";

$count = $conn->query("SELECT COUNT(*) AS total FROM admins");
$total = $count->fetch_assoc()["total"];

if ($total > 0) {
    die("An admin account already exists. Delete this setup file.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if ($username === "" || strlen($password) < 8) {
        $message = "Enter a username and a password of at least 8 characters.";
    } else {

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $stmt = $conn->prepare(
            "INSERT INTO admins (username, password) VALUES (?, ?)"
        );

        $stmt->bind_param("ss", $username, $hashedPassword);

        if ($stmt->execute()) {
            $message = "Admin account created! Delete setup_admin.php now.";
        } else {
            $message = "Could not create account. Check the username.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-box">
    <h2>Create Administrator</h2>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST">
        <input type="text" name="username"
               placeholder="Admin username" required>

        <input type="password" name="password"
               placeholder="Create password (8+ characters)" required>

        <button type="submit">Create Admin Account</button>
    </form>
</div>

</body>
</html>
