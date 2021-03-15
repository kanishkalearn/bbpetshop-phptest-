<?php session_start(); if(!isset($_SESSION[ 'username'])){ } 
$error=false;
include( 'dbcon.php'); 
if(isset($_POST['btn-delete'])){
$pid = $_POST['postid'];
$im = $_POST['image'];


        if(!$error){
    
    if (file_exists($im)) {
   
       if(unlink($im)){
      
       $sql1 = "delete from post  where postid='$pid'";
         
        if(mysqli_query($conn, $sql1)){
            
            
            
            
                    
                    header('location:petprofile.php');
               
                    
           }else{
            echo 'Error '.mysqli_error($conn);
          }
            
            
            
       }else{
            echo 'Error '.mysqli_error($conn);
       }
}}}

if(isset($_POST['bt-setpp'])){

                $pet=$_SESSION['petid'];
                $im=$_POST['image'];
                $petsql="update pet set img_url='$im' where petid='$pet'" ;
                if(mysqli_query($conn,$petsql)){
                        header('location:petprofile.php');
                }else{
                        echo 'Error '.mysqli_error($conn);
                }
                
                mysqli_close($conn);
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
        <div class="container">



            <div class="container-fluid" style="display:flex;flex-wrap:wrap;width:95%;justify-content:space-evenly;">
                <?php
                
                include( 'dbcon.php'); 
                $pet=$_SESSION['petid'];
                $petsql="select * from pet p 
                inner join ownership o on p.petid=o.pet_petid
                inner join seller_customer s on s.personrid=o.seller_customer_personrid
                inner join breed b on b.breedid=p.breed_breedid
                inner join pettype t on t.pettypeid=breed_pettypeid
                where petid='$pet'" ;
                $petresult=mysqli_query($conn,$petsql); 
                while($petrow=mysqli_fetch_assoc($petresult)){ ?>

                <div class="post-box" style="width:60%">
                    <center>
                        <form method="POST" action="photoupload.php">
                            <div>
                                <div style="display:flex;width:96%;flex-wrap:wrap;flex-direction:rows;" for="petid">
                                    <div style="width:60%;margin-left:4%;display:flex" for="petid">
                                        <input readonly class="boxinput" type="text" style="width:50%" value="ID:">
                                        <input readonly style="width:50%" type="text" class="boxinput" name="petid" value=<?php echo '"'.$petrow[ 'petid']. '"' ; $pet=$petrow[ 'petid']; ?>></div>
                                </div>
                                <div style="display:flex;width:96%;flex-wrap:wrap;flex-direction:rows;" for="petname">
                                    <div style="width:60%;margin-left:4%;display:flex;">
                                        <input readonly class="boxinput" type="text" style="width:50%" value="Pet Name:">
                                        <input readonly style="width:50%" type="text" class="boxinput" name="petname" value=<?php echo '"'.$petrow[ 'petname']. '"'; ?>></div>
                                </div>
                                <div style="display:flex;width:96%;flex-wrap:wrap;flex-direction:rows;" for="gender">
                                    <div style="width:60%;margin-left:4%;display:flex;">
                                        <input readonly class="boxinput" type="text" style="width:50%" value="Gender:">
                                        <input readonly style="width:50%" type="text" class="boxinput" name="gender" value=<?php echo '"'.$petrow[ 'gender']. '"'; ?>></div>
                                </div>
                                <div style="display:flex;width:96%;flex-wrap:wrap;flex-direction:rows;" for="bday">
                                    <div style="width:60%;margin-left:4%;display:flex;">
                                        <input readonly class="boxinput" type="text" style="width:50%" value="Birth Day:">
                                        <input readonly style="width:50%" type="text" class="boxinput" name="bday" value=<?php echo '"'.$petrow[ 'bday']. '"'; ?>></div>
                                </div>
                                <div style="display:flex;width:96%;flex-wrap:wrap;flex-direction:rows;" for="breed">
                                    <div style="width:60%;margin-left:4%;display:flex;">
                                        <input readonly class="boxinput" type="text" style="width:50%" value="Breed:">
                                        <input readonly style="width:50%" type="text" class="boxinput" name="breed" value=<?php echo '"'.$petrow[ 'breed']. '"'; ?>></div>
                                </div>
                                <div style="display:flex;width:96%;flex-wrap:wrap;flex-direction:rows;" for="pettype">
                                    <div style="width:60%;margin-left:4%;display:flex;">
                                        <input readonly class="boxinput" type="text" style="width:50%" value="Type:">
                                        <input readonly style="width:50%" type="text" class="boxinput" name="pettype" value=<?php echo '"'.$petrow[ 'type']. '"'; ?>></div>
                                </div>
                                <div style="display:flex;width:96%;flex-wrap:wrap;flex-direction:rows;" for="owner">
                                    <div style="width:60%;margin-left:4%;display:flex;">
                                        <input readonly class="boxinput" type="text" style="width:50%" value="Owner:">
                                        <input readonly style="width:50%" type="text" class="boxinput" name="owner" value=<?php echo '"'.$petrow[ 'username']. '"';$own=$petrow[ 'username']; ?>></div>
                                </div>
                                
                                <?php if($petrow[ 'username']==$_SESSION['username']){ ?>
                                <div style="width:90%;justify-align:space-evenly;flex-wrap:wrap;display:flex;flex-direction:row;" for="pupdate">
                                    
                                    <input style="margin-left:2%;" type="submit" name="bt-addp" class="btn btn-Primary btn-sm" value="Upload photo">
                                </div>
                                <?php } ?>
                            </div>
                        </form>
                    </center>
                </div>
                <div class="post-box" style="width:35%;height:auto;" >
                        <img src=<?php echo'"'.$petrow['img_url'].'"' ?> style="width:90%;height:auto;margin:6%;">
                </div>
                <?php }     
                
                mysqli_close($conn); ?>

            </div>
        </div>
        <hr/>
        <div class="container-fluid" style="display:flex;flex-wrap:wrap;width:95%;justify-content:center;align:content:space-evenly;">
                   <?php
                   include( 'dbcon.php'); 
                   $sql1 = "select * from post po inner join pet p on p.petid=po.pet_petid where pet_petid='$pet'";
                       $result=mysqli_query($conn, $sql1);
                        while($r=mysqli_fetch_assoc($result)){
                               
                   ?>
                   
                   <div class="post-box">
                        <center>   
                        <form action="petprofile.php" method="post">
                           <input type="text" style="text-align:center;" name="postid" value=<?php echo'"'.$r['postid'].'"'; ?>>
                           <input name="image" style="display:none;" type="text" value=<?php echo'"'.$r['image'].'"'; ?>>
                           
                           <img name="iimage" style="width:90%;height:auto;margin-bottom:2%;" src=<?php echo '"'.$r['image'].'"' ?>>
                           
                           <?php
                                   if($own == $_SESSION['username'] && $r['image'] != $r['img_url']){
                           ?>
                           <input class="btn btn-danger btn-sm" type="submit" name="btn-delete" value="Delete">
                           <?php
                                   }
                           ?>
                           <input class="btn btn-primary btn-sm" type="submit" name="bt-setpp" value="Set as Pro. Pic"
                           <?php
                                   if($r['image'] == $r['img_url']){
                                           echo 'style="display:none;"';
                                   }else{
                                           if($own != $_SESSION['username']){
                                                   echo 'style="display:none;"';
                                           }
                                   }
                           ?>
                           >
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