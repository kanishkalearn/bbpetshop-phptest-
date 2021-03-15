<?php
include_once('dbcon.php');

$error = false;

if(isset($_POST['uname'])){

    $uname = $_POST['uname'];
    $username = strip_tags($uname);
    $username = htmlspecialchars($username);

    $email = $_POST['email'];
    $email1 = strip_tags($email);
    $email1 = htmlspecialchars($email1);

    $password = $_POST['password'];
    $password1 = strip_tags($password);
    $password1 = htmlspecialchars($password1);

    $verify_password = $_POST['verify-password'];
    $verify_password1 = strip_tags($verify_password);
    $verify_password1 = htmlspecialchars($verify_password1);

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $add1 = $_POST['add1'];
    
    $add2 = $_POST['add2'];
    if(isset($_POST['add3'])){
    $add3 = $_POST['add3'];
    }
    $city = $_POST['city'];
    $contact = $_POST['contact'];
    if(!preg_match("/^[0-9]{10}$/", $contact)) {
          $errorContact='Please Enter a Valid Contact Number';
          $error=true;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $errorEmail = 'Please a valid input email';
    }
            
    

    if(empty($password1)){
        $error = alse;
        $errorPassword = 'Please enter the password';
    }elseif(strlen($password1) < 6){
        $error = true;
        $errorPassword = 'Password must at least 6 characters';
    }
    if(empty($verify_password1)){
        $error = true;
        $errorverifyPassword = 'Please enter the password again';
        }else{
    if($password1!==$verify_password1){
        $error = true;
        $errorverifyPassword = 'Passwords Doesn\'t match, lease try again';
        $errorPassword = 'Passwords Doesn\'t match, lease try again';
        }
    }
    if(isset($username)){
        $sql = "select * from seller_customer where username='$username' ";
        $count=mysqli_num_rows(mysqli_query($conn,$sql));
        
        if($count>0){
                $errorUsername="The Username already Taken, please try another";
                $error=true;
        }
    }
    if(isset($email1)){
        $sql = "select * from seller_customer where email='$email1' ";
        if(mysqli_num_rows(mysqli_query($conn,$sql))>0){
                $errorEmail="You can't have two account to same E-mail Account";
                $error=true;
        }
    }


     
   if(!$error){
   
    $username = $_POST['uname'];
    $username = strip_tags($username);
    $username = htmlspecialchars($username);

    $email = $_POST['email'];
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $password = $_POST['password'];
    $password = strip_tags($password);
    $password = htmlspecialchars($password);

    $verify_password = $_POST['verify-password'];
    $verify_password = strip_tags($verify_password);
    $verify_password = htmlspecialchars($verify_password);
    
       
        $sql1 = "insert into seller_customer(personfname, personlname ,address_no,adress_line1,address_line2,address_city,contact_no,status,username, email ,password)
                values('$fname', '$lname', '$add1', '$add2', '$add3', '$city', '$contact','0','$username', '$email', '$password')";
        
        if(mysqli_query($conn, $sql1)){
            $successMsg = 'Register successfully. Kindly wait for Administrator\'s Approval.';
       }else{
            echo 'Error '.mysqli_error($conn);
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
        <div style="width: 80%; margin: 50px auto;display:flex;flex-wrap:wrap;">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" style="display:flex;flex-wrap:wrap;justify-content:space-evenly;"" >
                <div style="width:100%;">
                <center><h2>Register</h2></center>
                <hr/>
                <?php
                    if(isset($successMsg)){
                 ?>
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php echo $successMsg; ?>
                        </div>
                <?php
                    }
                ?>
                
                </div>
                <div style="width:100%;display:flex;justify-content:space-evenly;">
                 <div style="float:left;">
                 <center><h4>Personal Information</h4></center>
                  <hr/>
                 <div style="display:flex;">
                <div class="form-group" style="margin-right:1%;">
                    <label for="fname" class="control-label">First Name</label>
                    <input type="text" name="fname" class="form-control" required value=<?php if(isset($fname)){echo $fname;}?>>
                    
                </div>
                <div class="form-group">
                    <label for="lname" class="control-label">Last Name</label>
                    <input type="text" name="lname" class="form-control" required value=<?php if(isset($lname)){echo $lname;}?>>
                </div>   
                
                </div>
                
                <div class="form-group">
                    <label for="add1" class="control-label">Address Line 1</label>
                    <input type="text" name="add1" class="form-control" required value=<?php if(isset($add1)){echo $add1;}?>>
                </div>   
                <div class="form-group">
                    <label for="add2" class="control-label">Address Line 2</label>
                    <input type="text" name="add2" class="form-control" required value=<?php if(isset($add2)){echo $add2;}?>>
                </div>   
                <div class="form-group">
                    <label for="add3" class="control-label">Address Line 3</label>
                    <input type="text" name="add3" class="form-control" value=<?php if(isset($add3)){echo $add3;}?>>
                </div>
                <div class="form-group">
                    <label for="city" class="control-label">City</label>
                    <input type="text" name="city" class="form-control" required value=<?php if(isset($city)){echo $city;}?>>
                </div> 
                <div class="form-group">
                    <label for="contact" class="control-label">Contact No</label>
                    <input type="text" name="contact" class="form-control" required value=<?php if(isset($contact)){echo $contact;}?>>
                    <span class="text-danger"><?php if(isset($errorContact)) echo $errorContact; ?></span>
                </div> 
                </div>
                <div style="float:right;">
                <center><h4>Login Information</h4></center>
                 <hr/>
                <div class="form-group">
                    <label for="uname" class="control-label">Username</label>
                    <input type="text" name="uname" class="form-control" id="username" required value=<?php if(isset($uname)){echo $uname;}?>>
                    <span class="text-danger"><?php if(isset($errorUsername)) echo $errorUsername; ?></span>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" autocomplete="off" required value=<?php if(isset($email)) echo $email;?>>
                    <span class="text-danger"><?php if(isset($errorEmail)) echo $errorEmail; ?></span>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" autocomplete="off" required value=<?php if(isset($password))echo $password;?>>
                    <span class="text-danger"><?php if(isset($errorPassword)) echo $errorPassword; ?></span>
                </div>
                <div class="form-group">
                    <label for="verify-password" class="control-label">Verify Password</label>
                    <input type="password" name="verify-password" class="form-control" id="verify-password" autocomplete="off" required value=<?php if(isset($verify_password))echo $verify_password;?>>
                    <span class="text-danger"><?php if(isset($errorverifyPassword)) echo $errorverifyPassword; ?></span>
                </div>
                
                </div >
                </div>
                </div>
                <div>
                <div class="form-group">
                    <center><input type="submit" name="btn-register" value="Register" class="btn btn-primary"></center>
                    <hr/>
                
                <a href="login.php" style="margin-left:30%;">Login</a>
                </div>
                </div>
               
            </form>
        </div>
    </div>
</body>
</html>