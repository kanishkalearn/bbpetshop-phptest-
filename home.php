<?php
session_start();
if(!isset($_SESSION['username'])){
   
}
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
        <a href="home.php"  class="nav-link active">Home</a>
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
    <div class="container">
        <a href="play.php" target="_blank"><input class="btn btn-primary" type="button" value="play"></a>
        
           </div>
           <div class="container-fluid" style="display:flex;flex-wrap:wrap;width:95%;justify-content:center;align:content:space-evenly;">
                   <?php
                   include( 'dbcon.php'); 
                   $sql1 = "select * from post po
                           inner join pet p on p.petid=po.pet_petid
                           inner join ownership o on o.pet_petid=p.petid
                           inner join seller_customer s on s.personrid=o.seller_customer_personrid 
                           order by po.postid desc";
                       $result=mysqli_query($conn, $sql1);
                        while($r=mysqli_fetch_assoc($result)){
                               
                   ?>
                   
                   <div class="post-box">
                        <center>   
                        <form action="approving.php" method="POST">
                           <input readonly type="text" style="text-align:center;display:none;" name="postid" value=<?php echo'"'.$r['postid'].'"'; ?>>
                           <input readonly type="text" style="text-align:center;display:none;" name="image" value=<?php echo'"'.$r['image'].'"'; ?>>
                           <img style="width:90%;height:auto;margin:2%;" src=<?php if(file_exists($r['image'])){ echo '"'.$r['image'].'"';} ?>>
                           <a href=<?php echo '"'.$r['image'].'"' ?> target='_blank'>
                                <input class="btn btn-info sm" type="button" value="View">
                            </a>
                           <table>
                                   <tr>
                                           <td>Owner :</td><td><?php echo $r['username'] ?></td>
                                   </tr>
                                   <tr>
                                           <td>Pet Name  :</td><td><?php echo $r['petname'] ?></td>
                                   </tr>
                                   <?php  
                                           if($_SESSION['ptype']=='admin'){
                                   ?>
                                   <tr>
                                          <td colspan="2"><center><input name="btn-delete" type="submit" class="btn btn-danger btn-sm" value="Delete"><center></td>
                                   </tr>
                                   <?php  
                                   }
                                   ?>
                           </table>
                           </form>
                           </center>
                   </div>
                  
                   <?php }mysqli_close($conn); ?>
           </div>
        
    </div>
    <footer class="page-footer font-small unique-color-dark pt-4">

  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="#"> Kanishka Viraj</a>
  </div>
</footer>
</body>
</html>