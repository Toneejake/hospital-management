<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'patient'; // Default role

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    
    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Error creating account.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gradient-to-r from-blue-500 to-white-500 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-20 flex flex-col md:flex-row items-center md:space-x-8">
        <div class="w-full max-w-xs">
            <h2 class="text-3xl font-bold mb-6 text-center">Register</h2>
            <form class="space-y-4" method="POST">
                <div class="relative">
                    <input class="w-full px-6 py-3 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="name" placeholder="Full Name" required/>
                </div>
                <div class="relative">
                    <input class="w-full px-6 py-3 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" type="email" name="email" placeholder="Email" required/>
                </div>
                <div class="relative">
                    <input class="w-full px-6 py-3 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" type="password" name="password" placeholder="Password" required/>
                </div>
                <button class="w-full py-3 rounded-lg bg-green-500 text-white font-bold hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500" type="submit">REGISTER</button>
            </form>
            <div class="text-center mt-4">
                <p class="text-gray-500">Already have an account? <a class="text-blue-500 hover:text-blue-700" href="login.php">Login</a></p>
            </div>
        </div>
    </div>
    <?php if (isset($error)) echo "<p class='text-red-500 text-center mt-4'>$error</p>"; ?>
</body>
</html>