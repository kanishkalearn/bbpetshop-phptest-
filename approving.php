<?php
session_start();
include('dbcon.php');


$error = false;

if(true){
if(isset($_POST['btn-delete'])){
$pid = $_POST['postid'];
$im = $_POST['image'];

 
        if(!$error){
   
    if (file_exists($im)) {
       if(unlink($im)){
       
         $sql1 = "delete from post  where postid='$pid'";
        if(mysqli_query($conn, $sql1)){
            
            
            
            
                    
                    header('location:home.php');
               
                    
           }else{
            echo 'Error '.mysqli_error($conn);
          }
            
            
            
       }else{
            echo 'Error '.mysqli_error($conn);
       }
}}}
if(isset($_POST['bt-rejectpet'])){
$petid = $_POST['petid'];
        if(!$error){
   
    
       
        $sql1 = "delete from ownership  where pet_petid='$petid'";
        
        if(mysqli_query($conn, $sql1)){
            
            $sql1 = "delete from pet  where petid='$petid'";
        
        if(mysqli_query($conn, $sql1)){
            
            
                    
                    header('location:petapprove.php');
           }else{
            echo 'Error '.mysqli_error($conn);
          }
                    
                    
           }else{
            echo 'Error '.mysqli_error($conn);
          }
            
            
            
       }else{
            echo 'Error '.mysqli_error($conn);
       }
}
if(isset($_POST['bt-approvepet'])){
$petid = $_POST['petid'];
        if(!$error){
   
    
       
        $sql1 = "update pet set sellingstatus=1 where petid='$petid'";
        
        if(mysqli_query($conn, $sql1)){
            
            
                    
                    header('location:petapprove.php');
           }else{
            echo 'Error '.mysqli_error($conn);
          }
            
            
            
       }else{
            echo 'Error '.mysqli_error($conn);
       }
}
if(isset($_POST['bt-pupdate'])){
$pid = $_POST['personrid'];
if(isset($_POST['pstatus'])){
        $pstatus=1;
}else{
$pstatus=0;
}
$pttype=$_POST['ptype'];
        if(!$error){
   
    
       
        $sql1 = "update seller_customer set status=$pstatus,ptype='$pttype' where personrid='$pid'";
        
        if(mysqli_query($conn, $sql1)){
            
            
                    
                    header('location:usermanage.php');
           }else{
            echo 'Error '.mysqli_error($conn);
          }
            
            
            
       }else{
            echo 'Error '.mysqli_error($conn);
       }
}


if(isset($_POST['bt-approvesell'])){
$petid = $_POST['petid'];
$grn = $_POST['grn'];
$pprice = floatval($_POST['petprice']);
$ptprice=($pprice*1.1);
$_SESSION['grnid']=$_POST['grn'];

if(true){
        if(!$error){
   
    
       
        $sql1 = "update pet set sellingstatus=3,price='$ptprice' where petid='$petid'";
        
        if(mysqli_query($conn, $sql1)){
            
            $sql1 = "update grn set gstatus=1 where grnid='$grn'";
        
        if(mysqli_query($conn, $sql1)){
            
                    ?>
                <script>window.open("http://www.bbpetshop.dx.am/grn.php", '_blank');
                window.location.href = "http://www.bbpetshop.dx.am/sellapprove.php";
                </script>
                <?php
                    
                   
           }else{
            echo 'Error '.mysqli_error($conn);
          }
                    
                    
           }else{
            echo 'Error '.mysqli_error($conn);
          }
            
            
            
       }else{
            echo 'Error '.mysqli_error($conn);
       }}
}
if(isset($_POST['bt-approvebuy'])){
$petid = $_POST['petid'];
$invoice = $_POST['invoice'];
$personid=$_POST['buyerid'];
$_SESSION['inid']=$_POST['invoice'];

     if(true){               
        if(!$error){
   
    
       
        $sql1 = "update pet set sellingstatus=1,price=0 where petid='$petid'";
        
        if(mysqli_query($conn, $sql1)){
            
            $sql1 = "update invoice_buyer set istatus=1 where invoiceid='$invoice'";
        
        if(mysqli_query($conn, $sql1)){
            
            
                    $sql1 = "update ownership set seller_customer_personrid='$personid' where pet_petid='$petid'";
        
             if(mysqli_query($conn, $sql1)){
            
            
                    ?>
                <script>window.open("http://www.bbpetshop.dx.am/invoice.php", '_blank');
                window.location.href = "http://www.bbpetshop.dx.am/buyapprove.php";</script>
<?php
                    
           }else{
            echo 'Error '.mysqli_error($conn);
          }
                
                    
           }else{
            echo 'Error '.mysqli_error($conn);
          }
                    
                    
           }else{
            echo 'Error '.mysqli_error($conn);
          }
            
            
            
       }else{
            echo 'Error '.mysqli_error($conn);
       }
       }
}
if(isset($_POST['bt-cancelbuyapprove'])){
$petid = $_POST['petid'];
$invoice = $_POST['invoice'];
$personid=$_POST['buyerid'];

        if(!$error){
   
    
       
        $sql1 = "update pet set sellingstatus=3 where petid='$petid'";
        
        if(mysqli_query($conn, $sql1)){
            
            $sql1 = "delete from invoice_buyer where invoiceid='$invoice'";
        
        if(mysqli_query($conn, $sql1)){
            
            
          
                
           header('location:buyapprove.php');         
           }else{
            echo 'Error '.mysqli_error($conn);
          }
                    
                    
           }else{
            echo 'Error '.mysqli_error($conn);
          }
            
            
            
       }else{
            echo 'Error '.mysqli_error($conn);
       }
}
if(isset($_POST['bt-cancelsellapprove'])){
$petid = $_POST['petid'];
$grn = $_POST['grn'];
$personid=$_POST['sellerid'];

        if(!$error){
   
    
       
        $sql1 = "update pet set sellingstatus=1,price=0 where petid='$petid'";
        
        if(mysqli_query($conn, $sql1)){
            
            $sql1 = "delete from grn where grnid='$grn'";
        
        if(mysqli_query($conn, $sql1)){
            
            
          
                
           header('location:buyapprove.php');         
           }else{
            echo 'Error '.mysqli_error($conn);
          }
                    
                    
           }else{
            echo 'Error '.mysqli_error($conn);
          }
            
            
            
       }else{
            echo 'Error '.mysqli_error($conn);
       }
}

}
if(isset($_POST['btn-sellpet'])){

    $petid = $_POST['petid'];

    




        $price= floatval($_POST['petprice']);  

   if(!$error){
   
    
       
        $sql1 = "update pet set price=".$price." , sellingstatus=2 where petid='$petid'";
        
        if(mysqli_query($conn, $sql1)){
            
            
                    $successMsg = 'Added selling list successfully. ';
                    header('location:mypets.php');
           }else{
            echo 'Error '.mysqli_error($conn);
          }
            
            
            
       }else{
            echo 'Error '.mysqli_error($conn);
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
                                    <a href="#">Registration approvals</a>
                                    <a href="#">Pet Approvals</a>
                                    <a href="#">Buying Approvals</a>
                                    <a href="#">Selling Approvals</a>
    
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
                <center><h2>Add Sell</h2></center>
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
                 
                   <div >
                  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" style="display:flex;flex-direction:column;justify-content:space-evenly;">
                                
                 <div class="form-group">
                    <label for="petid" class="control-label">Pet ID</label>
                    <input type="text" name="petid" readonly class="form-control" id="petid" autocomplete="off" required value=<?php if(isset($_POST['petid'])){echo'"', $_POST['petid'].'"'; } ?>>
                    <span class="text-danger"><?php if(isset($errorpetid)){ echo $errorpetid; }?></span>
                </div> 
                
                <div class="form-group">
                    <label for="petname" class="control-label">Pet Name</label>
                    <input type="text" name="petname" readonly class="form-control" id="petname" autocomplete="off" required value=<?php if(isset($_POST['petname'])){echo $_POST['petname']; } ?>>
                    <span class="text-danger"><?php if(isset($errorpetname)){ echo $errorpetname; }?></span>
                </div> 
                <div class="form-group">
                    <label for="petprice" class="control-label">Price</label>
                    <input type="number" min="0.00" max="100000.00" step="0.01" class="form-control" name="petprice" required>
                    <span class="text-danger"><?php if(isset($errorprice)){ echo $errorprice; }?></span>
                </div> 
                
                <div class="form-group" style="width:60%;">
                    <center><input type="submit" name="btn-sellpet" value="Add" class="btn btn-primary" <?php if(!isset($_SESSION[ 'username'])){?>disabled
                                                <?php }?>></center>
                    
                </div>
                
               </form>
               </div>
                </div>
                </div>
                </div>
               
            
        
</body>
</html>