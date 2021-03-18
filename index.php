<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projektai</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <header>
        <div class="topnav" id="myTopnav">
            <a href="/php_mysql/index.php" class="active">Projektai</a>
            <a href="/php_mysql/page.php">Darbuotojai</a>
            <div class=crud>
                <h1>CRUD</h1>
            </div>
    </header>


    </a>
    </div>


    <?php
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "sp2";


    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = 'SELECT projektai.id, projektai.projektas, GROUP_CONCAT(CONCAT_WS("  " , darbuotojai.name) SEPARATOR ", ") AS name
    FROM projektai
    LEFT JOIN darbuotojai ON projektai.id = darbuotojai.projekto_id group by id';

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $counter = 1;
        print('<table id=table1>');
        print('<thead>');
        print('<tr><th>ID</th><th>Projektas</th><th>Darbuotojai</th><th>Actions</th>');

        print('</thead>');
        while ($row = mysqli_fetch_assoc($result)) {
            print('<tr><td>' . $counter++ . '</td><td> ' . $row['projektas'] . '</td><td> ' . $row['name'] . '</td>
            <td><form class="actions" action="" method="POST">
            <input type="hidden" name="id" value="' . $row['id'] . '">
            <button type="submit" name="delete" value="' . $row['id'] . '">Delete</button>
            <button type="submit" name="update" value="">Update</button>
            </form></td></tr>');
        }
        print('<table>');
    } else {
        echo "0 results";
    }



    if (isset($_POST['create'])) {
        $stmt = $conn->prepare("INSERT INTO projektai (id, projektas) VALUES (?, ?)");
        $stmt->bind_param("is", $id, $projektas);
        $id = $_POST['fname'];
        // if(empty($id)){
        //     $id = MYSQLI_AUTO_INCREMENT_FLAG;}
        $projektas = $_POST['lname'];
        // $darbuotojo_id = $_POST['darbuotojo_id'];
        // if (empty($darbuotojo_id)) {
        //     $darbuotojo_id =  null;
        // }
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
        <input class=button type="submit" name="create" value="Pridėti projektą">

    </form>







</body>

</html>