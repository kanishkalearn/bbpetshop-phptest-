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
<hr/>
<?php if(!empty($_SESSION['username'])){ ?>
<div style="width:90%" ><input type="button" class="btn btn-primary btn-lg" value="My Pets"   onclick= "window.location.href='mypets.php'"    ></div>
<?php } ?> 
<div style="width:90%"><button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='addpet.php'">Add a Pet</button></div>
<div class="container-fluid" style="align-content:center;">
    <div class="container-fluid" style="align-content:center;">
        <div class="container">



            <div class="container-fluid" style="display:flex;flex-wrap:wrap;width:100%;justify-content:center;align:content:space-evenly;">
                <?php include( 'dbcon.php'); $usern=$_SESSION[ 'username']; $petsql="select * from pet p inner join breed b on b.breedid=p.breed_breedid
                           INNER join pettype t on t.pettypeid=p.breed_pettypeid 
                           inner join ownership o on o.pet_petid=p.petid
                           inner join seller_customer s on s.personrid=o.seller_customer_personrid
                           " ; $petresult=mysqli_query($conn,$petsql); while($petrow=mysqli_fetch_assoc($petresult)){ ?>
                <div class="post-box">
                    <center>
                        <form method="POST" action="buy.php">
                            <div>
                                  <div style="display:flex;width:100%;justify-align:space-evenly;flex-wrap:wrap;flex-direction:rows;" >
                                  <center>
                                    <img style="width:90%;height:auto;margin:2%;" src=<?php if(file_exists($petrow['img_url'])){ echo '"'.$petrow['img_url'].'"';} ?>>
                                  </center>
                                  </div>
                                <div style="display:flex;width:96%;justify-align:space-evenly;flex-wrap:wrap;flex-direction:rows;" for="petid">
                                    <div style="width:44%;margin-left:4%;display:flex" for="petid">
                                        <input readonly class="boxinput" type="text" style="width:30%" value="ID:">
                                        <input readonly style="width:70%" type="text" class="boxinput" name="petid" value=<?php echo '"'.$petrow[ 'petid']. '"'; ?>></div>
                                    <div style="width:50%;display:flex;">
                                        <input readonly class="boxinput" type="text" style="width:50%" value="Name:">
                                        <input readonly style="width:50%" type="text" class="boxinput" name="petname" value=<?php echo '"'.$petrow[ 'petname']. '"'; ?>></div>
                                </div>
                                <div style="display:flex;width:96%;justify-align:space-evenly;flex-wrap:wrap;flex-direction:rows;">
                                    <div style="width:55%;margin-left:4%;">
                                        <input readonly style="width:100%" type="text" class="boxinput" value=<?php echo '"Breed:'.$petrow[ 'breed']. '"'; ?>></div>
                                    <div style="width:41%">
                                        <input readonly style="width:100%" type="text" class="boxinput" value=<?php echo '"Type:'.$petrow[ 'type']. '"'; ?>></div>
                                </div>
                                <div style="display:flex;width:96%;justify-align:space-evenly;flex-wrap:wrap;flex-direction:rows;">
                                    <div style="width:90%;margin-left:4%;display:flex">
                                        <input readonly class="boxinput" type="text" style="width:30%" value="RS:">
                                        <input readonly style="width:70%" type="text" class="boxinput" name="petprice" value=<?php echo '"'.$petrow[ 'price']. '"'; ?>>
                                     </div>
                                </div>
                                
                                <div style="display:flex;width:96%;justify-align:space-evenly;flex-wrap:wrap;flex-direction:rows;">
                                    <div style="width:90%;margin-left:4%;display:flex">
                                        <input readonly class="boxinput" type="text" style="width:40%" value="Owner:">
                                        <input readonly style="width:60%" type="text" class="boxinput" name="username" value=<?php echo '"'.$petrow[ 'username']. '"'; ?>>
                                     </div>
                                </div>

                                <div style="width:90%;justify-align:space-evenly;flex-wrap:wrap;display:flex;flex-direction:row;">
                                    <?php if(!empty($_SESSION['username'])){ if($petrow[ 'sellingstatus']==3){ if($petrow['username']!=$_SESSION['username']){ ?>
                                    <input type="submit" name="bt-buypet" class="btn btn-Primary btn-sm" value="Buy">
                                    <label style="width:50%;">On Sale</label>
                                    <?php } }else if($petrow[ 'sellingstatus']==2){ if($petrow['username']!=$_SESSION['username']){ ?>

                                    
                                    <?php } ?>
                                    
                                    <?php }else if($petrow[ 'sellingstatus']==4){ ?>
                                    <label style="width:50%;">Buying</label>
                                    <?php }
                                    
                                    }?>
                                    <input type="submit" name="bt-view" class="btn btn-Primary btn-sm" value="View Info">
                                </div>
                                

                            </div>
                            </form>
                    </center>
                </div>
                <?php  } mysqli_close($conn); ?>

            </div>
        </div>
    </div>
    <footer class="page-footer font-small unique-color-dark pt-4">

  <div class="footer-copyright text-center py-3">?? 2020 Copyright:
    <a href="#"> Kanishka Viraj</a>
  </div>
</footer>
</body>
</html>