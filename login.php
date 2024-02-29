<?php
    @ob_start();
    session_start();
    if(isset($_POST['proses'])){
        require 'config.php';
            
        $user = strip_tags($_POST['user']);
        $pass = strip_tags($_POST['pass']);

        $sql = 'select member.*, login.user, login.pass
                from member inner join login on member.id_member = login.id_member
                where user =? and pass = md5(?)';
        $row = $config->prepare($sql);
        $row -> execute(array($user,$pass));
        $jum = $row -> rowCount();
        if($jum > 0){
            $hasil = $row -> fetch();
            $_SESSION['admin'] = $hasil;
            if(isset($_POST['remember'])) {
                // Set cookies for username and password
                setcookie('username', $user, time() + (86400 * 30), "/"); // 30 days
                setcookie('password', $pass, time() + (86400 * 30), "/"); // 30 days
                echo "Cookies set successfully!";
            } else {
                echo "Remember Me not checked!";
            }
            echo '<script>alert("Login Sukses");window.location="index.php"</script>';
        }else{
            echo '<script>alert("Login Gagal");history.go(-1);</script>';
        }
    } else {
        // Check for existing cookies and auto-fill the form
        if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            $user = $_COOKIE['username'];
            $pass = $_COOKIE['password'];
            // You might want to add additional validation here before auto-logging in
            // For example, checking if the credentials are valid in your database.
            // For simplicity, I'll leave it as is.
            echo "<script>
                    document.getElementById('user').value = '$user';
                    document.getElementById('pass').value = '$pass';
                  </script>";
        } else {
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login - POS Levapos</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="sb-admin/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-md-5 mt-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="h4 text-gray-900 mb-4"><b>Login POS Levapos</b></h4>
                            </div>
                            <form class="form-login" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="user" name="user"
                                        placeholder="User ID" autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="pass" name="pass"
                                        placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="remember"> Remember me
                                </div>
                                <button class="btn btn-primary btn-block" name="proses" type="submit"><i
                                        class="fa fa-lock"></i>
                                    SIGN IN</button>
                            </form>
                            <!-- <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="register.html">Create an Account!</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the remember me checkbox
        var rememberCheckbox = document.querySelector('input[name="remember"]');
        
        // Get the form inputs
        var userField = document.getElementById('user');
        var passField = document.getElementById('pass');

        // Check if the remember me checkbox is clicked
        rememberCheckbox.addEventListener('change', function() {
            if(this.checked) {
                // If checked, store the username and password in cookies
                var username = userField.value.trim();
                var password = passField.value.trim();

                // Set cookies for username and password
                document.cookie = "username=" + username + "; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
                document.cookie = "password=" + password + "; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
            } else {
                // If unchecked, remove the username and password cookies
                document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
                document.cookie = "password=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
            }
        });

        // Check for existing cookies and auto-fill the form
        var cookies = document.cookie.split(';');
        cookies.forEach(function(cookie) {
            var parts = cookie.split('=');
            var name = parts[0].trim();
            var value = parts[1].trim();

            if (name === 'username') {
                userField.value = value;
            } else if (name === 'password') {
                passField.value = value;
            }
        });
    });
</script>

    <!-- Bootstrap core JavaScript-->
    <script src="sb-admin/vendor/jquery/jquery.min.js"></script>
    <script src="sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="sb-admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="sb-admin/js/sb-admin-2.min.js"></script>
</body>
</html>
