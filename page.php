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


$sql = "SELECT  darbuotojai.id,
        darbuotojai.name,
        projektai.projektas
        
		
 FROM darbuotojai
left JOIN projektai ON darbuotojai.id = projektai.darbuotojo_id 
ORDER BY id ASC";

// $sql = "SELECT id, name, darbuotojo_id FROM projektai";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "Zmogaus id: " . $row["id"]. " - vardas: " . $row["name"]. " - projektas: " . $row["projektas"]. "<br>";
    }
} else {
    echo "0 results";
}

if(isset($_POST['create2'])){
    $stmt = $conn->prepare("INSERT INTO darbuotojai (id, name) VALUES (?, ?)");
    $stmt->bind_param("is", $id, $name);
    $id = $_POST['fname'];
    // if(empty($id)){
    //     $id = MYSQLI_AUTO_INCREMENT_FLAG;}
    $name = $_POST['lname'];
    
    
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
            <input type="TEXT" id="lname" name="lname" value="" placeholder="darbuotojo vardas" ><br>
            <input type="submit" name="create2" value="Pridėti darbuotoja">
            
        </form>



</body>
</html>