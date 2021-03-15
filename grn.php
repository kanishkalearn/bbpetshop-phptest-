<?php
session_start();
include('dbcon.php');
?>
<html>
<head>
<title>
        Pet Recieve Note
</title>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/mycss.css">
</head>
<body>
<?php
$grn=$_SESSION['grnid'];
$sql="select * from grn g 
inner join pet p on p.petid=g.petid 
inner join breed b on b.breedid=p.breed_breedid 
inner join pettype t on t.pettypeid=p.breed_pettypeid
inner join seller_customer s on s.personrid=g.seller_customer_personrid
where grnid='$grn'";

if($res=mysqli_query($conn,$sql)){
       if($r=mysqli_fetch_assoc($res)){
       
       ?>
       
       



<div style="align-content:center;width:80%;border:dotted;">
<p>Date<?php echo " - ".$r['date']; ?></p>
<p>PRN ID<?php echo " : ".$r['grnid']; ?></p>
<center>
<h1>Pet Recieve Note</h1>

<br/>
<hr/>
<br/>

<table class="table-bordered" style="width:75%;">

<tr>
        <td>
                Seller ID
        </td>
        <td>
                <?php echo $r['personrid']; ?>
        </td>
        <td style="border:none;">
               &nbsp
        </td>
        <td>
                Seller Name
        </td>
        <td>
                <?php echo $r['personfname']." ".$r['personlname']; ?>
        </td>
</tr>
<tr style="border:none;">
    <td style="border:none;"><br/></td>
</tr>
<tr>
        <td>
                Pet Name
        </td>
        <td>
                <?php echo $r['petname']; ?>
        </td>
        <td style="border:none;">
               &nbsp
        </td>
        <td>
                Pet ID
        </td>
        <td>
                <?php echo $r['petid']; ?>
        </td>
</tr>

<tr>
        <td>
                Pet Type
        </td>
        <td>
                <?php echo $r['type']; ?>
        </td>
        <td style="border:none;">
               &nbsp
        </td>
        <td>
                Pet Breed
        </td>
        <td>
               <?php echo $r['breed']; ?>
        </td>
</tr>
<tr style="border:none;">
    <td style="border:none;"><br/></td>
</tr>
<tr>
        <td style="border:none;">
               &nbsp
        </td>
        <td style="border:none;">
               &nbsp
        </td>
        <td style="border:none;">
               &nbsp
        </td>
        <td>
                Price
        </td>
        <td>
                <strong><?php echo "RS: ".$r['totalvalue']."/="; ?></strong>
        </td>
</tr>
</table>

<br/>
<hr/>
<br/>

<input id="bttn" value="Print" type="button" onclick="window.print();">
<br/>
<hr/>
<br/>
</center>
</div>


       <?php 
       }else{
        echo 'Error 2 '.mysqli_error($conn);
}
}else{
        echo 'Error 1 '.mysqli_error($conn);
}


mysqli_close($conn);
?>
</body>
</html>