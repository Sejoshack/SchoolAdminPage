
<?php

require_once "auth.php";
require_admin();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: view_students.php");
    exit();
}

verify_csrf();

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid student ID.");
}

$stmt = $conn->prepare(
    "DELETE FROM students WHERE studentid = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: view_students.php");
exit();

?>
