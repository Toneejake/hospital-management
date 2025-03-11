<?php
include '../includes/auth.php';
include '../includes/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    header("Location: manage_users.php");
    exit();
}

$result = $conn->query("SELECT id, name, email, role FROM users");
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Manage Users</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo ucfirst($user['role']); ?></td>
            <td><a href="?delete=<?php echo $user['id']; ?>">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
