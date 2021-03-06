<?php

include_once 'includes/dbh.inc.php';
session_start();

$moduleCount = [];

$stuID = $_SESSION['stid'];


for ($i=1; $i<6; $i++) {

  $sql = "SELECT count(*) as total, module.name as module_name FROM attendence, module WHERE module.moduleid=attendence.moduleid AND attendence.moduleid='$i'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $sql2 = "SELECT count(*) as std_att FROM student st, attendence att, attendence_students adata WHERE st.sid=adata.student_id AND att.attendenceid=adata.attendenceid AND st.sid='$stuID' AND att.moduleid='$i';";
  $result2 = mysqli_query($conn, $sql2);
  $row2 = mysqli_fetch_assoc($result2);

  
  array_push($moduleCount,array("Total"=>$row['total'],"Module"=>$row['module_name'],"Std_attend"=>$row2['std_att']));
  // array_push($moduleCount,$row);
  
}

// print_r($moduleCount);
// exit();

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" type="text/css" href="./style.css">
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   
</head>
<body>
<div class="container">
  <div class="jumbotron">
   
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb b1">
    <li class="breadcrumb-item active new" aria-current="page">Hello, <?php 
      if (isset($_SESSION['sname'])) {
        echo $_SESSION['sname'];
      }
    ?></li>
  </ol>
  </nav>

    <p class="lead">This is your exam eligibility results for this semester modules <span class="deg-span">(<?php 
      if (isset($_SESSION['dname'])) {
        echo $_SESSION['dname'];
      }
    ?>)</span></p>
    <hr class="my-4">
    <div class="div-span">
      <span class="congrad">Congradulations!</span>
    </div>
  </div>

  
  <table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Module Code</th>
      <th scope="col">Module</th>
      <th scope="col">Percentage</th>
      <th scope="col">Eligibility</th>
    </tr>
  </thead>
  <tbody>
      <?php
      $x=1;
        foreach($moduleCount as $mc){

          if ($mc['Total'] == 0) {
            break;

          }
         //$percentage = ($mc['Std_attend']/$mc['Total'])*100;
          $percentage = bcmul(bcdiv($mc['Std_attend'], $mc['Total'],2),100,2);
          //bcdiv($mc['Std_attend'], $mc['Total'],2);
          $eligibility;
          if ($percentage > 50) {
            $eligibility = "Eligible";
          } else {
            $eligibility = "Not Eligible";
          }
         echo   '<tr>
      <th scope="row">'.$x.'</th>
      <td>BC2003</td>
      <td>'.$mc['Module'].'</td>
      <td>'. floor($percentage).'%</td>
      <td>'. $eligibility.'</td> 
    </tr>';
    $x++;
        }
      ?>
  </tbody>
</table>

  </div>
   


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>