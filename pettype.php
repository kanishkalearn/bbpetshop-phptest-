<?php
session_start();
include('dbcon.php');

$error = false;

function loadtable(){
include('dbcon.php');
        $sql="select * from pettype where status=1";
        
        $result=mysqli_query($conn,$sql);
        return $result;
mysqli_close($conn);
}

if(isset($_POST['btn-addpettype'])){

    $typen = $_POST['pettype'];

    $descr = $_POST['typedescription'];
    
if ( !preg_match ("/^[a-zA-Z\s]+$/",$typen)) {
   $error=true;
}
if ( !preg_match ("/^[a-zA-Z\s]+$/",$descr)) {
   $error=true;
}
    

 if(true){
         $q="select * from pettype where type='$typen'";
         $r=mysqli_num_rows(mysqli_query($conn,$q));
         if($r>0){
                 $error=true;
                 $errormsg="The Pet Type already exists";
         }
 }   

     
   if(!$error){
   
    
       
        $sql1 = "insert into pettype(type, description ,status)
                values('$typen', '$descr',1)";
        
        if(mysqli_query($conn, $sql1)){
            $successMsg = 'Added successfully. ';
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
        <div style="width: 90%; margin: 50px auto;display:flex;flex-wrap:wrap;">
           
                <div style="width:80%;">
                <center><h2>Pet Type</h2></center>
                <hr/>
                
                </div>
                <div style="width:60%;">
                        <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <th style="display:none;" method="post">#</th>
                                      <th >#</th>
                                      <th >Pet type</th>
                                      <th >Description</th>
                                      <th >.</th>
                                    </tr>
                                  </thead>
                                  
                                  
                                  <tbody>
                                          <?php
                                          
                                          $result1=loadtable();
                                          $rownum=1;
                                          while($row=mysqli_fetch_assoc($result1)){
                                          ?>
                                    <tr>
                                      <td name="number"><?php echo $rownum ?></th>
                                      <th style="display:none;"><?php echo $row['pettypeid'] ?></th>
                                      <td name="name"><?php echo $row['type'] ?></th>
                                      <td name="description"><?php echo $row['description'] ?></td>
                                      <td><input type="submit" onclick="location.href='pettypeedit.php'" value="Edit"></td>
                                      
                                    </tr>
                                    <?php
                                    $rownum++;
                                    }
                                    
                                    ?>
                        </table>
                </div>
                
                <div style="width:35%;">
                <center><h4>Add Pet Type</h4></center>
                
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
                  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" style="display:flex;flex-wrap:wrap;justify-content:space-evenly;" >
                <div class="form-group">
                    <label for="pettype" class="control-label">Pet Type</label>
                    <input type="text" name="pettype" class="form-control" id="pettype" required>
                    <span class="text-danger"><?php if(isset($errormsg)) echo $errormsg; ?></span>
                </div>
                <div class="form-group">
                    <label for="typedescription" class="control-label">Pet Type Description</label>
                    <textarea name="typedescription" class="form-control" id="typedescription" autocomplete="off" required></textarea>
                    <span class="text-danger"><?php if(isset($errortypedescription)) echo $errortypedescription; ?></span>
                </div>
                <div class="form-group" style="width:60%;">
                    <center><input type="submit" name="btn-addpettype" value="Add" class="btn btn-primary"></center>
                    
                </div>
                
               </form>
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