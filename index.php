<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projektai</title>
</head>

<body>


    <a href="/php_mysql/index.php"><button>Projektai</button></a>
    <a href="/php_mysql/page.php"><button>Darbuotojai</button></a><br>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "sp2";

    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = 'SELECT projektai.id, projektai.projektas  , darbuotojai.name 
FROM projektai
LEFT JOIN darbuotojai ON projektai.darbuotojo_id = darbuotojai.id';



    // $sql = 'SELECT projektai.id, projektai.projektas, GROUP_CONCAT(CONCAT_WS("  " , darbuotojai.name) SEPARATOR ", ") AS name 
    // FROM projektai 
    // LEFT JOIN darbuotojai ON projektai.darbuotojo_id = darbuotojai.id';



    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "proj id: " . $counter++ . " - projektas: " . $row["projektas"] . " - vardas: " . $row["name"] . "<br>";
            print(' <br> <form class="actions" action="" method="POST">
        <input type="hidden" name="id" value="' . $row['id'] . '">
        <button type="submit" name="delete" value="' . $row['id'] . '">Delete</button>
        <button type="submit" name="update" value="">Update</button>
    </form>');
        }
    } else {
        echo "0 results";
    }



    if (isset($_POST['create'])) {
        $stmt = $conn->prepare("INSERT INTO projektai (id, projektas, darbuotojo_id) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $id, $projektas, $darbuotojo_id);
        $id = $_POST['fname'];
        // if(empty($id)){
        //     $id = MYSQLI_AUTO_INCREMENT_FLAG;}
        $projektas = $_POST['lname'];
        $darbuotojo_id = $_POST['darbuotojo_id'];
        if (empty($darbuotojo_id)) {
            $darbuotojo_id =  null;
        }
        $stmt->execute();
        $stmt->close();
        header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
        die;
    }

    if (isset($_POST['delete'])) {
        $delete = $conn->prepare("DELETE FROM projektai WHERE id = ?");
        $delete->bind_param("i", $delete_id);
        $delete_id = $_POST['id'];
        $delete->execute();
        $delete->close();
        header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
        die;
    }



    mysqli_close($conn);
    ?>
    <br>
    <form action="" method="POST">
        <label for="lname"></label><br>
        <input type="TEXT" id="lname" name="lname" value="" placeholder="Projekto pavadinimas"><br>
        <input type="submit" name="create" value="Pridėti projektą">

    </form>







</body>

</html>