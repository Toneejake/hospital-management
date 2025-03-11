<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../index.php");
        }
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gradient-to-r from-blue-500 to-white-500 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-20 flex flex-col md:flex-row items-center md:space-x-8">
            <div class="w-full max-w-xs">
                <h2 class="text-3xl font-bold mb-6 text-center">Login</h2>
                    <form class="space-y-4" method="POST">
                        <div class="relative">
                            <input class="w-full px-6 py-3 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" type="email" name="email" placeholder="Email" required/>
                        </div>
                        <div class="relative">
                            <input class="w-full px-6 py-3 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" type="password" name="password" placeholder="Password" required/>
                        </div>
                        <button class="w-full py-3 rounded-lg bg-green-500 text-white font-bold hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500" type="submit">LOGIN</button>
                    </form>
                    <div class="text-center mt-4">
                        <a class="text-gray-500 hover:text-gray-700" href="register.php">Create your Account →</a>
                    </div>
            </div>
        </div>
    </div>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
