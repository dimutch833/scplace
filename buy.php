<?php 
session_start(); 


$user_id = $_SESSION['userid'];
$music_id = $_GET['song?id'];
$db = mysqli_connect('localhost', 'root', 'root', 'scdb'); 

$music_name_query = mysqli_query($db,"SELECT * FROM music WHERE id='$music_id' ");
$music_name = mysqli_fetch_assoc($music_name_query);
$q = "SELECT * FROM users WHERE id='$user_id' ";
$results = mysqli_query($db, $q);
$rt = mysqli_fetch_assoc($results);


echo "Your ID ";
echo "<br>";
echo $user_id;
echo "<br>";
echo "You want to buy ";
echo "<br>";
echo $music_name['name'];
echo '<br>';
echo "That costs ";
echo $music_name['cost'];
echo "<br>";
echo "<br>";
echo "Your balance: ";
echo $rt['balance'];

echo "
<form method='post'>
 
<input type='submit' name='buy' value='Buy' />
";

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['buy']))
    {
        $fromuser       =  $_SESSION['userid'];
        $touser         = 2;
        $amount         = $music_name['cost']; ;
        $check_query = mysqli_query($db,"SELECT * FROM users WHERE id='$fromuser' ");
        $ckbal = mysqli_fetch_assoc($check_query);
        if($ckbal['balance'] >= $amount & $amount >= 0){
        $result1    = mysqli_query($db,"UPDATE `users` SET `balance`= `balance` + '$amount' WHERE id = '$touser'");
        $result2    = mysqli_query($db,"UPDATE `users` SET `balance`= `balance` - '$amount' WHERE id = '$fromuser'");
        echo "<p>Transfer complete</p>";
        $get_havings = $ckbal['havings'];
        $get_havings = json_decode($get_havings, TRUE); 
        $get_havings[] = ['id' => $music_id];
        $json = json_encode($get_havings);
      $add_query = mysqli_query($db,"UPDATE `users` SET `havings`= '$json' WHERE id = '$fromuser '  ");
        sleep(0.5);
        header('Location: index.php');
        
        }else{
            echo "<p>You dont have enough money</p>";
        }
    }

?>