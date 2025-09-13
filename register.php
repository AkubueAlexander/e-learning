<?php
include_once 'inc/database.php';
include_once 'config.php';
include_once 'method.php';

//Load Composer's autoloader
require 'phpmailer/vendor/autoload.php';
 use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$error = '';
$id = '';
$fullName = '';
$email = '';
$password = '';
$confirmPassword = '';




if (isset($_POST['submit'])) {   
   
    $email = trim($_POST['email']);        
    $password = trim($_POST['password']);
    $passwordHash = md5($password);    
    $fullName = $_POST['fullName'];   
    $confirmPassword = trim($_POST['confirmPassword']);
    $otp = rand(10000, 99999);
    

        $query = 'SELECT COUNT(*) FROM user WHERE email = :email  LIMIT 1';
        $stmtCheck = $pdo->prepare($query);
        $stmtCheck->bindParam(':email',$email);
        $stmtCheck->execute();
        $row = $stmtCheck->fetchColumn();   
        
        if ($row > 0 ) {
            $error = 'Email already exist';
        }   
        elseif ($password != $confirmPassword) {
        $error = 'Password do not match';
        }
        elseif (empty($email)) {
        $error = 'Email field cannot be empty';
        }
        else{  
            
            $sql = 'INSERT INTO user (fullName, email,otp, pass) VALUES ( :fullName,:email,:otp,:pass)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['fullName' => $fullName,'email' => $email,'otp' => $otp,'pass' => $passwordHash]);
            $userId = $pdo->lastInsertId();

          $to1 = $email;
          $subject_1 = 'Registeration successful';
          $fullName_1 = $fullName;       
          $body_1= '<div style="background:#1e293b;color:white;padding:15px">'; 
          $body_1 .= '<p style="margin:10px 0"><img style="height:50px" src="https://starnetweb.com/assets/img/logo.png" alt=""></p>';
        
          $body_1 .= '<h2 style="margin:10px 0">Hi investor,'.' '.$fullName_1.'</h2>';
          $body_1 .= '<p style="margin:10px 0;line-height:2;">Thanks you for creating an account
          on our website. Click the activate link below to activate your account</p><br/>';
          $body_1 .= '<p style="margin:10px 0;">Thank you for choosing Learner Hub</p>';
          $body_1 .= '<div style="margin:30px 0">
          <a style="padding:15px 30px;border-radius:10px;background-color:#6366f1;border-color:#6366f1;color:white"
          href="'.SITE_NAME.'/verify.php?otp='.$otp.'&id='.$id.'">Activate Account</a></div>';
          
        
          $body_1 .= '</div>'; 
          send_email($to1,$subject_1,$fullName_1,$body_1,new PHPMailer());

        


                    session_start();                    
                    $_SESSION['userId'] = $userId;
                   





                    echo '<script>
                    setTimeout(function() {
                    window.location.href = "login";
                    }, 200);
                    </script>';

                


        
        }

     
    
    
    
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register | E-Learning</title>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-200">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Create Account</h2>

        <form action="" method="POST" class="space-y-4">
            <p class="text-red-500 text-sm">
                <?php echo $error; ?>
            </p>
            <div>
                <label class="block text-gray-600 mb-1">Full Name</label>
                <input type="text" placeholder="John Doe" name="fullName"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none" />
            </div>

            <div>
                <label class="block text-gray-600 mb-1">Email</label>
                <input type="email" placeholder="you@example.com" name="email"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none" />
            </div>

            <div>
                <label class="block text-gray-600 mb-1">Password</label>
                <input type="password" placeholder="********" name="password"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none" />
            </div>
            <div>
                <label class="block text-gray-600 mb-1">Comfirm Password</label>
                <input type="password" placeholder="********" name="confirmPassword"
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none" />
            </div>

            <button type="submit" name="submit"
                class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition">Register</button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Already have an account?
            <a href="login" class="text-blue-600 hover:underline">Login</a>
        </p>
    </div>
</body>

</html>