<?php
session_start();
include('dbcon.php');

$error = false;

function loadtable(){
include('dbcon.php');
        $sql="select * from grn g
        inner join pet p on p.petid=g.petid
        inner join seller_customer s on s.personrid=g.seller_customer_personrid
        inner join breed b on b.breedid=p.breed_breedid
        inner join pettype t on t.pettypeid=b.pettypeid
        where gstatus=1";
        if($result=mysqli_query($conn,$sql)){
        return $result;
        }else{
        echo 'Error '.mysqli_error($conn);
        }
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
                <center><h2>Buying History</h2></center>
                <hr/>
                
                </div>
                <div style="width:85%;">
                        <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <th style="display:none;" method="post">#</th>
                                      <th >#</th>
                                      <th >GRN No</th>
                                      <th >Seller</th>
                                      <th >GRN Date</th>
                                      <th >Value</th>
                                      <th >Pet Name</th>
                                      <th >Pet Type</th>
                                      <th >Breed</th>
                                    </tr>
                                  </thead>
                                  
                                  
                                  <tbody>
                                          <?php
                                          
                                          $result1=loadtable();
                                          $rownum=1;
                                          while($row=mysqli_fetch_assoc($result1)){
                                          ?>
                                    <tr>
                                      <th name="number"><?php echo $rownum ?></th>
                                      <td name="grnno" align="center"><?php echo $row['grnid'] ?></td>
                                      <td name="name"><?php echo $row['personfname'].' '.$row['personlname'] ?></th>
                                      <td name="date"><?php echo $row['date'] ?></td>
                                      <td name="value" align="right"><?php echo sprintf("%.2f", $row['totalvalue']) ?></td>
                                      <td name="pname"><?php echo $row['petname'] ?></td>
                                      <td name="breed"><?php echo $row['breed'] ?></td>
                                      <td name="type"><?php echo $row['type'] ?></td>
                                    </tr>
                                    <?php
                                    $rownum++;
                                    }
                                    
                                    ?>
                        </table>
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