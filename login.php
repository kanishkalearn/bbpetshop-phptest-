<?php
session_start();
include_once('dbcon.php');

$error = false;
if(isset($_POST['btn-login'])){
    $email = trim($_POST['email']);
    $email = htmlspecialchars(strip_tags($email));

    $password = trim($_POST['password']);
    $password = htmlspecialchars(strip_tags($password));

    if(empty($email)){
        $error = true;
        $errorEmail = 'Please input email';
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $errorEmail = 'Please enter a valid email address';
    }

    if(empty($password)){
        $error = true;
        $errorPassword = 'Please enter password';
    }elseif(strlen($password)< 6){
        $error = true;
        $errorPassword = 'Password at least 6 character';
    }

    if(!$error){
        
        $sql = "select * from seller_customer where email='$email' ";
        $result = mysqli_query($conn, $sql);
        if($result){
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
       
        if($count==1 && $row['password'] == $password){
            if($row['status']=='1'){
            $_SESSION['username'] = $row['username'];
            $_SESSION['ptype'] = $row['ptype'];
            $_SESSION['personid'] = $row['personrid'];
           header('location: home.php');
            }else{
                $errorMsg = 'Your account approval is still pending.';
            }
        }else{
            $errorMsg = 'Invalid Username or Password';
        }
    }
    }
}

?>

<html>
<head>
<title>PHP Login & Register</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
    <hr/>
    <div class="form-group">
                    <a href="home.php" style="margin-left:30%;">Home</a>
                </div>
                    <hr/>
        <div style="width: 500px; margin: 50px auto;">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                <center><h2>Login</h2></center>
                <hr/>
                <?php
                    if(isset($errorMsg)){
                        ?>
                        <div class="alert alert-danger">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php echo $errorMsg; ?>
                        </div>
                        <?php
                    }
                ?>
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" name="email" class="form-control" autocomplete="off">
                    <span class="text-danger"><?php if(isset($errorEmail)) echo $errorEmail; ?></span>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" name="password" class="form-control" autocomplete="off">
                    <span class="text-danger"><?php if(isset($errorPassword)) echo $errorPassword; ?></span>
                </div>
                <div class="form-group">
                    <center><input type="submit" name="btn-login" value="Login" class="btn btn-primary"></center>
                </div>
                <hr/>
                <a href="register.php">Register</a>
            </form>
        </div>
    </div>
</body>
</html>