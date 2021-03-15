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


    




$sql = "SELECT projektai.id,
        projektai.projektas,
        darbuotojai.name
		
 FROM projektai
left JOIN darbuotojai ON projektai.darbuotojo_id = darbuotojai.id";

// $sql = "SELECT id, name, darbuotojo_id FROM projektai";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "proj id: " . $row["id"]. " - projektas: " . $row["projektas"]. " - vardas: " . $row["name"]. "<br>";
    }
} else {
    echo "0 results";
}



mysqli_close($conn);
?>



</body>
</html>