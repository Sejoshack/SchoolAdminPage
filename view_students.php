
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "auth.php";
require_admin();
require_once "db.php";

$result = $conn->query(
    "SELECT * FROM students ORDER BY student_id ASC"
);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="main">

    <h1>Registered Students</h1>

    <a class="btn" href="add_student.php">Add New Student</a>

    <table>

        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>

        <tr>

            <td><?php echo htmlspecialchars($row["student_id"]); ?></td>

            <td><?php echo htmlspecialchars($row["firstname"]); ?></td>

            <td><?php echo htmlspecialchars($row["lastname"]); ?></td>

            <td><?php echo htmlspecialchars($row["email"]); ?></td>

            <td><?php echo htmlspecialchars($row["phone"]); ?></td>

            <td><?php echo htmlspecialchars($row["gender"]); ?></td>

            <td>
                <a href="edit_student.php?id=<?php echo (int)$row["student_id"]; ?>">
                    Edit
                </a>

                <form action="delete_student.php" method="POST"
                      onsubmit="return confirm('Delete this student?');"
                      style="display:inline;">

                    <input type="hidden" name="csrf_token"
                           value="<?php echo htmlspecialchars($_SESSION["csrf_token"]); ?>">

                    <input type="hidden" name="id"
                           value="<?php echo (int)$row["student_id"]; ?>">

                    <button type="submit">Delete</button>

                </form>
            </td>

        </tr>

        <?php endwhile; ?>

    </table>

    <a href="dashboard.php">Back to Dashboard</a>

</div>

</body>
</html>
