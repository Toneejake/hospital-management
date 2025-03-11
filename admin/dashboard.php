<?php
include '../includes/auth.php';
include '../includes/db.php';

// Ensure only admins can access
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$result = $conn->query("SELECT id, name, email, role FROM users");
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Admin Dashboard</h2>
    <a href="../auth/logout.php">Logout</a>
    <a href="manage_users.php">manage users</a>

    <h3>Manage Users</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo ucfirst($user['role']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
