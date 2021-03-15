<?php
session_start();
include('dbcon.php');
$error = false;

function loadtable(){
include('dbcon.php');
        $sql="SELECT * FROM pettype p INNER JOIN breed b ON p.pettypeid=b.pettypeid where b.status=1";

        $result=mysqli_query($conn,$sql);
        return $result;
mysqli_close($conn);
}

if(isset($_POST['btn-addpettype'])){

    $typen = $_POST['pettype'];
    $breed = $_POST['breed'];
    $descr = $_POST['breeddescription'];

if ( !preg_match ("/^[a-zA-Z\s]+$/",$typen)) {
   $error=true;
}
if ( !preg_match ("/^[a-zA-Z\s]+$/",$descr)) {
   $error=true;
}
if ( !preg_match ("/^[a-zA-Z\s]+$/",$breed)) {
   $error=true;
}

$petid=0;
 if(true){
         $q="select * from breed where breed='$breed'";
         $r=mysqli_num_rows(mysqli_query($conn,$q));
         if($r>0){
                 $error=true;
                 $errormsg="The Breed you entered already exists";
         }
         $q1="select * from pettype where type='$typen'";
         $res=mysqli_query($conn,$q1);
         if($r1=mysqli_fetch_assoc($res)){
                         $petid=$r1['pettypeid'];
         }
 }   
echo $petid;

   if(!$error){

        $sql1 = "insert into breed (pettypeid,breed, bdescription ,status)
                values('$petid','$breed', '$descr',1)";

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
        <title>PBB Pet Shop - Breed</title>
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
            <div style="width: 100%; margin: 50px auto;display:flex;flex-wrap:wrap;">

                <div style="width:95%;">
                    <center>
                        <h2>Breed</h2></center>
                    <hr/>
                </div>

                <div style="width:60%;">
                    <div style="display:table;width:60%;">
                        <div style="display:flex;justice-align:space-evenly;width:100%;">
                        <table style="width:100%;"><tr style="width:100%;">

                           <td style="display:none;"> <span style="display:none;">#</span> </td>
                           <td style="display:none;"> <span style="display:none;">#</span></td>
                           <td style="width:30%;"> <span style="dispaly:table-cell;" class="box-input">Pet Type</span></td>
                           <td style="width:30%;"> <span style="dispaly:table-cell;" class="box-input">Breed</span></td>
                           <td style="width:30%;"> <span style="dispaly:table-cell;" class="box-input">Desciption</span></td>
                        </tr></table>
                        </div>
                        <table style="width:100%;"><tr style="width:100%;">

                           <hr/>
                        </tr></table>
                        <?php

                                          $result1=loadtable();
                                          $rownum=1;
                                          while($row=mysqli_fetch_assoc($result1)){
                                          ?>

                            <div style="display:table-row;width:90%;">
                                <div style="display:flex;justice-align:space-evenly;width:100%; margin-bottom:0px;">
                                    <form action="breededit.php" method="POST" style="width:90%;margin-bottom:0px;">
                                        <table><tr>
                                              <td>  <span name="number" style="display:none;outline:non;"><?php echo $rownum ?></span> </td>
                                              <td>  <span name="rw" style="display:none;outline:non;"><?php echo $row['breedid'] ?></span></td>
                                
                                               <td> <input class="box-input" readonly type="text"  name="pettype" value=<?php echo '"'. $row['type'].'"' ?>></td>
                                               <td> <input class="box-input" readonly type="text"  name="breed" value=<?php echo '"'. $row['breed'].'"'  ?>></td>
                                               <td> <input class="box-input" readonly type="text"  name="description" value=<?php echo '"'. $row['bdescription'] .'"' ?>></td>
                                               <td> <input class="box-input" type="submit" name="bt_submitrow"  value="Edit" <?php if(empty($_SESSION['username'])){?>disabled<?php }?>></td>
                                        </tr></table>
                                    </form>
                                </div>
                                <br/>
                                <?php
                                    $rownum++;
                                    }

                                    ?>
                            
                    </div>
                <hr/>
                <div style="width:35%;">
                    <center>
                        <h4>Add Breed</h4></center>

                    <?php
                    if(isset($successMsg)){

                 ?>
                        </hr>
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php echo $successMsg; ?>
                        </div>
                        <?php
                    }
                ?>
                            <hr/>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">
                                <div class="form-group" style="width:90%" class="panel panel-default">
                                    <label for="pettype" class="control-label">Pet Type</label>
                                    <select name="pettype" style="width:90%;">
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
                                <div class="form-group" style="width:90%">
                                    <label for="breed" class="control-label">Breed</label>
                                    <input style="width:90%" type="text" name="breed" class="form-control" id="breed" required>
                                    <span class="text-danger"><?php if(isset($errormsg)) echo $errormsg; ?></span>
                                </div>
                                <div class="form-group" style="width:90%">
                                    <label for="breeddescription" class="control-label">Breed Description</label>
                                    <textarea style="width:90%" name="breeddescription" class="form-control" id="breeddescription" autocomplete="off" required></textarea>
                                    <span class="text-danger"><?php if(isset($errorbreeddescription)) echo $errorbreeddescription; ?></span>
                                </div>
                                <div class="form-group" style="width:60%;">
                                    <?php if(!isset($_SESSION['username'])){?><span class="text-danger">You must be logged into add a Breed <a href="login.php"> Click Here</a> to login.</span>
                                        <?php }?>
                                            <center>
                                                <input type="submit" name="btn-addpettype" value="Add" class="btn btn-primary" <?php if(empty($_SESSION[ 'username'])){?>disabled
                                                <?php }?>></center>

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