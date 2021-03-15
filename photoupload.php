<?php
session_start();
if(!isset($_SESSION['username'])){
   
}
include( 'dbcon.php');
if(isset($_POST['bt-upload'])){
        $file=$_FILES['photo'];
        $fileName=$_FILES['photo']['name'];
        $fileTmpname=$_FILES['photo']['tmp_name'];
        $fileSize=$_FILES['photo']['size'];
        $fileError=$_FILES['photo']['error'];
        $fileType=$_FILES['photo']['type'];
        $fileExt=strtolower(end(explode('.',$fileName)));
        
       $allowed=array('jpg','jpeg','png');
       if(in_array($fileExt,$allowed)){
       
               if($fileError===0){
               
                       if($fileSize<2000000){
                       
                              $newName=uniqid('',true).".".$fileExt;
                              $Dest='images/'.$newName;
                              move_uploaded_file($fileTmpname,$Dest);
                              $pet=$_POST['petid'];
                              $sql1 = "insert into post (image,pet_petid) values ('$Dest','$pet')";
        
                                if(mysqli_query($conn, $sql1)){
                                    $successMsg = 'Uploaded Succesfully';
                                    header('location:petprofile.php');
                               }else{
                                    echo 'Error '.mysqli_error($conn);
                               }
                              
                              
                       }else{
                               $errMsg="Selected File is Too large, select a file less than 5 Mb.";
                       }
               }else{
                       $errMsg="There was a error uploading the file.";
               }
       }else{
               $errMsg="Selected File Type is Not Compatible, select JPG,JPEG or PNG file.";
       }
}
mysqli_close($conn);


?>

<html>
<head>
<title>BB Pet Shop - Home</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/mycss.css">
</head>
<body>

<div class="navbar sticky-top navbar-dark bg-dark">

<li >
        <a href="home.php" class="nav-link">Home</a>
</li>
<li class="dropdown">
  <div class="nav-link">Pets</div>
  <div class="dropdown-content">
    <a href="petlist.php">Pet List</a>
    <a href="mypets.php">My Pets</a>
    <a href="buypets.php">Buy Pets</a>
    <a href="breed.php">Breed List</a>
    <?php
        if(isset($_SESSION['ptype'])){
                if($_SESSION['ptype']=='admin'){?>
                                    <a href="pettype.php">Pet Type List</a>
                        <?php
                }
        }
?>
  </div>
</li>
<?php
        if(isset($_SESSION['ptype'])){
                if($_SESSION['ptype']=='admin'){?>
                        <li class="dropdown">
                          <div class="nav-link">Admin Panel</div>
                                  <div class="dropdown-content">
                                    <a href="usermanage.php">Manage Users</a>
                                    <a href="petapprove.php">Pet Approvals</a>
                                    <a href="buyapprove.php">Buying Approvals</a>
                                    <a href="sellapprove.php">Selling Approvals</a>
                                    <a href="sellhistory.php">Selling History</a>
                                    <a href="buyhistory.php">Buying History</a>
                                  </div>
                           
                        </li>
                        <?php
                }
        }
?>

<?php
        if(isset($_SESSION['username']) && isset($_SESSION['ptype'])){
                echo '<li class="nav-item ml-auto" ><a class="nav-link"  href="logout.php">Logout</a></li> ';
        }else{
       
              echo '  <li class=" ml-auto" style="margin-right:opx;"><a class="nav-link" href="login.php">LogIn</a></li> ';
               echo ' <li class="" style="margin-right:0px;" ><a class="nav-link" href="register.php">Register</a></li> ';
        
        }
?>
</div>
<div style="width:100%;display:flex;flex-direction:row-reverse;">

        <label style=""><?php 
        if(isset($_SESSION['username']) && isset($_SESSION['ptype'])){
        ?>
        <p>You are logged in as <?php echo $_SESSION['username']; ?> </p>
        <?php
        }else{
        ?>
        <p>You are not logged in.</p>
        <?php
        }        
        ?>
        </label>
</div>
<div class="container-fluid" style="align-content:center;">
    <form action="photoupload.php" method="POST" enctype="multipart/form-data">
           <div class="container-fluid" style="display:flex;flex-wrap:wrap;background-color:red;width:95%;justify-content:center;align:content:space-evenly;">
                   <input type="text" name="petid" class="form-control" style="display:none;" value=<?php echo '"'.$_POST['petid'].'"' ?>>
                   <input type="file" name="photo" class="form-control">
                   <span class="text-danger"><?php if(isset($errMsg)) echo $errMsg; ?></span>
                   <input type="submit" name="bt-upload" value="Upload">
           </div>
    </form> 
    </div>
    <footer class="page-footer font-small unique-color-dark pt-4">

  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="#"> Kanishka Viraj</a>
  </div>
</footer>
</body>
</html>