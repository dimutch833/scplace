<?php 
  session_start(); 

  $db = mysqli_connect('localhost', 'root', 'root', 'scdb'); 


?>
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="style.css">
<div class="header">
  	<h2>Transfer</h2>
  </div>
  <form method="post" action="transfer.php">
  
      <div class="input-group">
  		<label>ID of recipient </label>
  		<input type="text" name="recid"  required >
  	</div>
      <div class="input-group">
  		<label>Amount </label>
  		<input type="text" name="amount" required  >
  	</div>
      <div class="input-group">
      <button type="submit" class="btn" name='submit'>Transfer</button>
  	</div>
  </form>
<?php 
if (isset($_SESSION['userid'])){
    echo $_SESSION['userid'];
    if (isset($_POST['submit'])) {
        
        $fromuser       =  $_SESSION['userid'];
        $touser         = $_POST['recid'];
        $amount         =  $_POST['amount'];
        $check_query = mysqli_query($db,"SELECT * FROM users WHERE id='$fromuser' ");
        $ckbal = mysqli_fetch_assoc($check_query);
        if($ckbal['balance'] >= $amount & $amount >= 0){
        $result1    = mysqli_query($db,"UPDATE `users` SET `balance`= `balance` + '$amount' WHERE id = '$touser'");
        $result2    = mysqli_query($db,"UPDATE `users` SET `balance`= `balance` - '$amount' WHERE id = '$fromuser'");
        echo "<p>Transfer complete</p>";
        sleep(0.5);
        header('Location: index.php');
        }else{
            echo "<p>You dont have enough money</p>";
        }
        
    } 
}else{
    echo 'Cant find User id';
}
?>