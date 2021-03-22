<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darbuotojai</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<body>

    <header>
        <div class="topnav" id="myTopnav">
            <a href="/php_mysql/index.php" class="active">Projektai</a>
            <a href="/php_mysql/page.php">Darbuotojai</a>
            <div class=crud>
                <h1>CRUD</h1>
            </div>
    </header><?php
                $servername = "localhost";
                $username = "root";
                $password = "mysql";
                $dbname = "sp2";


                $conn = mysqli_connect($servername, $username, $password, $dbname);
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT  darbuotojai.id, darbuotojai.name, projektai.projektas 
        FROM darbuotojai
        left JOIN projektai ON darbuotojai.projekto_id = projektai.id
        ORDER BY id ASC";

                $result = mysqli_query($conn, $sql);



                if (mysqli_num_rows($result) > 0) {
                    $counter = 1;
                    print('<table id=table1>');
                    print('<thead>');
                    print('<tr><th>ID</th><th>Vardas</th><th>Projektas</th><th>Actions</th>');

                    print('</thead>');
                    while ($row = mysqli_fetch_assoc($result)) {
                        print('<tr><td>' . $counter++ . '</td><td> ' . $row['name'] . '</td><td> ' . $row['projektas'] . '</td>
            <td><form class="actions" action="" method="POST">
            <input type="hidden" name="id" value="' . $row['id'] . '">
            <button type="submit" name="delete" value="' . $row['id'] . '">Delete</button>
            <button type="submit" name="update" value="">Update</button>
            </form></td></tr>');
                    }
                    print('<table>');
                } else {
                    echo "Nėra duomenų";
                }

                if (isset($_POST['create2'])) {
                    $stmt = $conn->prepare("INSERT INTO darbuotojai (id, name) VALUES (?, ?)");
                    $stmt->bind_param("is", $id, $name);
                    $id = $_POST['fname'];
                    $name = $_POST['lname'];

                    if (!empty($id) || !empty($name)) {
                        $stmt->execute();
                        $stmt->close();
                        header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
                        die;
                    }
                }

                if (isset($_POST['delete'])) {
                    $delete = $conn->prepare("DELETE FROM darbuotojai WHERE id = ?");
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
        <input class=input type="TEXT" id="lname" name="lname" value="" placeholder="Darbuotojo vardas" Required><br>
        <input class=button type="submit" name="create2" value="Pridėti darbuotoją">

    </form>

    <footer>
        <div id="footer-content">
            <p> NO Copyright 2021 @ Tomas - NO Rights Reserved </p>
        </div>
    </footer>



</body>

</html>