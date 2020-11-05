<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music store</title>
</head>

<body>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
    <?php
      session_start(); 

      $db = mysqli_connect('localhost', 'root', 'root', 'scdb'); 

      $q = mysqli_query($db,"SELECT * FROM music");
      echo "<table class='table' border='1'>
      <thead class='thead-dark'>
        <tr>
        <th scope='col'>Name</th>
        <th scope='col'>Cost</th>
        <th scope='col'>Buy</th>
        </tr>
    </thead>";
      while($row = mysqli_fetch_array($q))
      {
          
      echo "<tr>";
      echo "<td>" . $row['name'] . "</td>";
      echo "<td>" . $row['cost'] . "</td>";
      echo "<td> <a href='buy.php?song?id=". $row['id'] ."'> Buy ". $row['name'] ."</a> </td>";
      echo "</tr>";
      }
      echo "</table>";
    ?>
</body>
</html>