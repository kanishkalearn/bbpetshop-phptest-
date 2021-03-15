<?php
session_start();
include('dbcon.php');

$error = false;


if(isset($_POST['btn-addpet'])){

    $petn = $_POST['apetname'];

    
if ( !preg_match ("/^[a-zA-Z\s]+$/",$petn)) {
   $error=true;
   $errorapetname="Enter a Valid pet name.!";
}

if(isset($_POST['apettype'])){
        $p=$_POST['apettype'];
        $q="select * from pettype where type='$p'";
        $result=mysqli_query($conn,$q);
        if($r=mysqli_fetch_assoc($result)){
                $pettid=$r['pettypeid'];
               
        }
} 
if(isset($_POST['abreed'])){
        $p=$_POST['abreed'];
        $q="select * from breed where breed='$p'";
        $result=mysqli_query($conn,$q);
        if($r=mysqli_fetch_assoc($result)){
                $petbid=$r['breedid'];
               
        }
} 

        $apetbday= $_POST['apetbday'];  
        
         $agender= $_POST['agender'];


   if(!$error){
   $prophoto="images/pro.jpg";
    
       
        $sql1 = "insert into pet(petname, gender ,bday,breed_breedid,breed_pettypeid,status,sellingstatus,img_url)
                values('$petn', '$agender','$apetbday','$petbid','$pettid',1,0,'$prophoto')";
        
        if(mysqli_query($conn, $sql1)){
            
            $q="select * from pet where petname='$petn' and bday='$apetbday' and gender='$agender'";
            $result=mysqli_query($conn,$q);
            if($r=mysqli_fetch_assoc($result)){
                    $petid=$r['petid'];
            }
            $user=$_SESSION['username'];
            $q="select * from seller_customer where username='$user'";
            $result=mysqli_query($conn,$q);
            if($r=mysqli_fetch_assoc($result)){
                    $userid=$r['personrid'];
            }
            $q="insert into ownership(pet_petid,seller_customer_personrid) values ('$petid','$userid')";
            if(mysqli_query($conn,$q)){
                    $successMsg = 'Added successfully. ';
           }else{
            echo 'Error '.mysqli_error($conn);
          }
            
            
            
       }else{
            echo 'Error '.mysqli_error($conn);
       }
    

   
   
}
mysqli_close($conn);
}



?>

<html>
<head>
<title>PHP Login & Register</title>
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
    <div class="container">
    
                <hr/>
        <div style="width: 90%; margin: 50px auto;display:flex;flex-wrap:wrap;justify-align:center;">
           
                <div style="width:90%;">
                <center><h2>Add Pet</h2></center>
                <hr/>
                
                </div>
                
                
                <div style="width:90%;">
                
                
                <?php
                    if(isset($successMsg)){
                    
                 ?></hr>
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php echo $successMsg; ?>
                        </div>
                <?php
                    }
                ?>
                 <hr/>
                 <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" <?php if(isset($_POST['btn-addpettype1']) || isset($_POST['btn-addpet'])){echo 'style="display:none;"';} ?>>
                 <div style="width:100%; display:flex; justify-align:space-evenly">
                                <div class="form-group" style="width:75%" class="panel panel-default">
                                    <label for="apettype" class="control-label">Pet Type</label>
                                    <select name="apettype" style="width:90%;">
                                        <?php 
                                    include_once('dbcon.php');
                                    $q2="select * from pettype";
                                    $res2=mysqli_query($conn,$q2);
                                    while($rr1=mysqli_fetch_assoc($res2)){

                                    ?>
                                            <option value=<?php echo $rr1[ 'type'] ;?>>
                                                <?php echo $rr1['type'] ;?>
                                            </option>
                                            <?php }
                                    ?>
                                    </select>
                                    <span class="text-danger"><?php if(isset($errormsg)) echo $errormsg; ?></span>
                                </div>
                                <div style="width:10%;">
                                <input type="submit" name="btn-addpettype1" value="Add" class="btn btn-primary" <?php if(empty($_SESSION['username'])){ ?> disabled <?php } ?>>
                                </div>
                    </div>
                   </form>
                   <div <?php if((!isset($_POST['btn-addpettype1'])) && (!isset($_POST['btn-addpet']))){echo 'style="display:none;"';} ?>>
                  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" style="display:flex;flex-direction:column;justify-content:space-evenly;">
                                
                 <div class="form-group">
                    <label for="apettype" class="control-label">Pet Type</label>
                    <input type="text" name="apettype" readonly class="form-control" id="apettype" autocomplete="off" required value=<?php if(isset($_POST['apettype'])){echo'"', $_POST['apettype'].'"'; } ?>>
                    <span class="text-danger"><?php if(isset($errorapettype)){ echo $errorapettype; }?></span>
                </div> 
                <div class="form-group" >
                                    <label for="abreed" class="control-label">Breed</label>
                                    <select name="abreed"  class="form-control">
                                    <?php echo "innnn";
                                    if(isset($_POST['apettype'])){
                                    include_once('dbcon.php');
                                    $tp=$_POST['apettype'];
                                    $q2="select * from breed b inner join pettype p on p.pettypeid=b.pettypeid where type='$tp'";
                                    
                                    $res2=mysqli_query($conn,$q2);
                                    while($rr1=mysqli_fetch_assoc($res2)){
                                        echo $rr1[ 'breed'] ;
                                    ?>
                                            <option value=<?php echo'"'.$rr1[ 'breed'].'"' ;?>>
                                                <?php echo $rr1['breed'] ;?>
                                            </option>
                                            <?php }}
                                    ?>
                                    </select>
                                    <span class="text-danger"><?php if(isset($errormsg)) echo $errormsg; ?></span>
                                </div>
                <div class="form-group">
                    <label for="apetname" class="control-label">Pet Name</label>
                    <input type="text" name="apetname" class="form-control" id="apetname" autocomplete="off" required value=<?php if(isset($_POST['apetname'])){echo $_POST['apetname']; } ?>>
                    <span class="text-danger"><?php if(isset($errorapetname)){ echo $errorapetname; }?></span>
                </div> 
                <div class="form-group">
                    <label for="apetbday" class="control-label">Birth Day</label>
                    <input type="date" class="form-control" name="apetbday" required>
                    <span class="text-danger"><?php if(isset($errorapetbday)){ echo $errorapetbday; }?></span>
                </div> 
                <div class="form-group">
                    <label for="agender" class="control-label">Gender</label>
                    <input type="radio" name="agender" id="agender" class="form-check-input" value="male" style="margin-left:10%" checked><label class="form-check-label" style="margin-left:15%" for="agender"><span style="margin-left:50%;">Male</span></label>
                    <input type="radio" name="agender" id="agender" class="form-check-input" value="female" style="margin-left:10%"><label class="form-check-label" style="margin-left:15%" for="agender"><span style="margin-left:50%;">Female</span></label>
                   
                </div>
                <div class="form-group" style="width:60%;">
                    <center><input type="submit" name="btn-addpet" value="Add" class="btn btn-primary" <?php if(!isset($_SESSION[ 'username'])){?>disabled
                                                <?php }?>></center>
                    
                </div>
                
               </form>
               </div>
                </div>
                </div>
                </div>
               
            <footer class="page-footer font-small unique-color-dark pt-4">

  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="#"> Kanishka Viraj</a>
  </div>
</footer>
        
</body>
</html>