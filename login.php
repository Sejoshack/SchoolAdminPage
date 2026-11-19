
<?php
session_start();

if (isset($_SESSION["admin_id"])) {
    header("Location: dashboard.php");
    exit();
}

$error = $_SESSION["login_error"] ?? "";
unset($_SESSION["login_error"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="login-box">

    <h1>School Management</h1>
    <h3>Administrator Login</h3>

    <?php if ($error): ?>
        <p class="error">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form action="authenticate.php" method="POST">

        <input type="text"
               name="username"
               placeholder="Enter username"
               required>

        <input type="password"
               name="password"
               placeholder="Enter password"
               required>

        <button type="submit">Login</button>

    </form>

</div>
</body>
</html>
