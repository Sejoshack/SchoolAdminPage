
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "auth.php";
require_admin();
require_once "db.php";

$studentResult = $conn->query(
    "SELECT COUNT(*) AS total FROM students"
);

$totalStudents = $studentResult->fetch_assoc()["total"];

$lecturerResult = $conn->query(
    "SELECT COUNT(*) AS total FROM lecturers"
);

$totalLecturers = $lecturerResult->fetch_assoc()["total"];

$courseResult = $conn->query(
    "SELECT COUNT(*) AS total FROM courses"
);

$totalCourses = $courseResult->fetch_assoc()["total"];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="sidebar">

    <h2>School Admin</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="add_student.php">Add Student</a>
    <a href="view_students.php">View Students</a>
    <a href="logout.php">Logout</a>

</div>

<div class="main">

    <h1>Administrator Dashboard</h1>

    <p>
        Welcome,
        <?php echo htmlspecialchars($_SESSION["admin_username"]); ?>
    </p>

    <div class="cards">

        <div class="card">
            <h3>Total Students</h3>
            <h1><?php echo $totalStudents; ?></h1>
        </div>

        <div class="card">
            <h3>Total Lecturers</h3>
            <h1><?php echo $totalLecturers; ?></h1>
        </div>

        <div class="card">
            <h3>Total Courses</h3>
            <h1><?php echo $totalCourses; ?></h1>
        </div>

    </div>

    <h2>Student Management</h2>

    <a class="btn" href="add_student.php">Register Student</a>

    <a class="btn" href="view_students.php">Manage Students</a>

</div>

</body>
</html>
