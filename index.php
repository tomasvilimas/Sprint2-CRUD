<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sveiki</title>
</head>
<body>
<a href="/php_mysql/index.php"><button>Projektai</button></a>
<a href="/php_mysql/page.php"><button>Darbuotojai</button></a><br>
<?php
$servername = "localhost";
$username = "root"; 
$password = "mysql";
$dbname = "sp2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


    




$sql = "SELECT 
        
        projektai.id,
       
        projektai.projektas,
        
        darbuotojai.name
		
 FROM projektai
left JOIN darbuotojai ON projektai.darbuotojo_id = darbuotojai.id";

// $sql = "SELECT id, name, darbuotojo_id FROM projektai";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "proj id: " . $row["id"]. " - projektas: " . $row["projektas"]. " - vardas: " . $row["name"]. "";
        print("     <button>DELETE</button><br>");
    }
} else {
    echo "0 results";
}


if(isset($_POST['create'])){
    $stmt = $conn->prepare("INSERT INTO projektai (id, projektas, darbuotojo_id) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $id, $projektas, $darbuotojo_id);
    $id = $_POST['fname'];
    // if(empty($id)){
    //     $id = MYSQLI_AUTO_INCREMENT_FLAG;}
    $projektas = $_POST['lname'];
    $darbuotojo_id = $_POST['darbuotojo_id'];
    if(empty($darbuotojo_id)){
        $darbuotojo_id =  null;
    }
    $stmt->execute();
    $stmt->close();
    header('Location: ' . $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
    die;
}



mysqli_close($conn);
?>
<br>
<form action="" method="POST">
            <label for="lname"></label><br>
            <input type="TEXT" id="lname" name="lname" value="" placeholder="Projekto pavadinimas" ><br>
            <input type="submit" name="create" value="Pridėti projektą">
            
        </form>



</body>
</html>