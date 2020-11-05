<?php 
  session_start(); 

  $db = mysqli_connect('localhost', 'root', 'root', 'scdb');
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="header">
	<h2>Home Page</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <?
        $user_id = $_SESSION['userid'];
        $q = "SELECT * FROM users WHERE id='$user_id' ";
        $results = mysqli_query($db, $q);
        $rt = mysqli_fetch_assoc($results);

        $json_havngs = $rt['havings'];
        $havngs = json_decode($json_havngs,true);

        
        
        ?>
        <p>Your id: <strong><?php echo $user_id ?></strong></p>
        <p>Your balance: <strong><?php echo $rt['balance']; ?></strong></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
        <p><a href="transfer.php">Transfer</a></p>
        <p><a href="store.php">Store</a></p>
        <br>
        
        <?

        

        foreach($havngs as $item) {
        $song_query = mysqli_query($db,"SELECT * FROM music WHERE id = ".$item['id']." ");
        $song_info = mysqli_fetch_assoc($song_query);
            echo $song_info['name'];
            echo "<br>"; 
            echo "<audio
            controls
            src=".$song_info['path'].">
                Your browser does not support the
                <code>audio</code> element.
               </audio>";
            echo "<br>";
        }
        ?>
        

    <?php endif ?>
</div>
		
</body>
</html>