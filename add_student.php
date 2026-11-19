
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "auth.php";
require_admin();
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    verify_csrf();

    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $gender = $_POST["gender"];

    if (
        $firstname === "" ||
        $lastname === "" ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        $message = "Enter valid student details and email.";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO students
             (firstname, lastname, email, phone, gender)
             VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssss",
            $firstname,
            $lastname,
            $email,
            $phone,
            $gender
        );

        if ($stmt->execute()) {
            $message = "Student registered successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="main">

    <h1>Register New Student</h1>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST">

        <input type="hidden" name="csrf_token"
               value="<?php echo htmlspecialchars($_SESSION["csrf_token"]); ?>">

        <input type="text" name="firstname"
               placeholder="First Name" required>

        <input type="text" name="lastname"
               placeholder="Last Name" required>

        <input type="email" name="email"
               placeholder="Email Address" required>

        <input type="text" name="phone"
               placeholder="Phone Number">

        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <button type="submit">Save Student</button>

    </form>

    <a href="dashboard.php">Back to Dashboard</a>

</div>

</body>
</html>
