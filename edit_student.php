
<?php

require_once "auth.php";
require_admin();
require_once "db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid student ID.");
}

$stmt = $conn->prepare(
    "SELECT * FROM students WHERE student_id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    die("Student not found.");
}

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
        $message = "Enter valid student details.";
    } else {

        $update = $conn->prepare(
            "UPDATE students
             SET firstname=?, lastname=?, email=?, phone=?, gender=?
             WHERE student_id=?"
        );

        $update->bind_param(
            "sssssi",
            $firstname,
            $lastname,
            $email,
            $phone,
            $gender,
            $id
        );

        if ($update->execute()) {
            header("Location: view_students.php");
            exit();
        } else {
            $message = "Unable to update student.";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="main">

    <h1>Edit Student Details</h1>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST">

        <input type="hidden" name="csrf_token"
               value="<?php echo htmlspecialchars($_SESSION["csrf_token"]); ?>">

        <input type="text" name="firstname"
               value="<?php echo htmlspecialchars($student["firstname"]); ?>"
               required>

        <input type="text" name="lastname"
               value="<?php echo htmlspecialchars($student["lastname"]); ?>"
               required>

        <input type="email" name="email"
               value="<?php echo htmlspecialchars($student["email"]); ?>"
               required>

        <input type="text" name="phone"
               value="<?php echo htmlspecialchars($student["phone"]); ?>">

        <select name="gender" required>
            <option value="Male"
                <?php if ($student["gender"] === "Male") echo "selected"; ?>>
                Male
            </option>

            <option value="Female"
                <?php if ($student["gender"] === "Female") echo "selected"; ?>>
                Female
            </option>

            <option value="Other"
                <?php if ($student["gender"] === "Other") echo "selected"; ?>>
                Other
            </option>
        </select>

        <button type="submit">Update Student</button>

    </form>

    <a href="view_students.php">Back to Students</a>

</div>

</body>
</html>
