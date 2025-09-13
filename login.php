<?php

include_once 'inc/database.php';
    $error = '';

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $passMd5 = md5($password);
    $sql = 'SELECT * FROM user  WHERE email = :email && pass =:pass LIMIT 1';
        
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email,'pass' => $passMd5]);
    $row = $stmt->fetch();
    if ($row) {

        if ($row -> verifiedStatus == 1) {

            session_start(); 
            $_SESSION['id'] = $row -> id;

         header('location: index');  
        } else {
            $error = $row -> email.' is not verified, go to your email inbox and click the activation link.'; 
        }   

                 
    }

        else {
        $error = 'Invalid credentials';
        }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login | E-Learning</title>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 to-indigo-200">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Welcome Back</h2>

        <form action="" method="POST" class="space-y-4">
            <p class="text-red-500 text-sm">
                <?php echo $error; ?>
            </p>
            <div>
                <label class="block text-gray-600 mb-1">Email</label>
                <input type="email" placeholder="you@example.com" name="email"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none" />
            </div>

            <div>
                <label class="block text-gray-600 mb-1">Password</label>
                <input type="password" placeholder="********" name="password"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none" />
            </div>

            <button type="submit" name="submit"
                class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md transition">Login</button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Don’t have an account?
            <a href="register" class="text-indigo-600 hover:underline">Register</a>
        </p>
    </div>
</body>

</html>