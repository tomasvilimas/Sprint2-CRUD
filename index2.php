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
<a href="/php_mysql/index2.php"><button>Darbuotojai</button></a><br>
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


$sql = "SELECT darbuotojai.id,
        darbuotojai.name,
        projektai.projektas
        
		
 FROM darbuotojai
inner JOIN projektai ON darbuotojai.id = projektai.darbuotojo_id ORDER BY id ASC";

// $sql = "SELECT id, name, darbuotojo_id FROM projektai";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "Zmogaus id: " . $row["id"]. " - vardas: " . $row["name"]. " - projektas: " . $row["projektas"]. "<br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>



</body>
</html>