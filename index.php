<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <form class="boton" method="get" action="">
        <input type="text" name="db">
        <button name="connect" value="connect">Connect</button>
        <?php
        $conectado = false;
        error_reporting(E_ERROR | E_PARSE);
        if ($_GET["connect"]) {
            $conectado = true;
            try{ 
                $conex = mysqli_connect("localhost", "root", "", $_GET['db']);
                echo "Connected successfully! <br>";
            }
            catch (Exception $e) {
                echo "The database does not exist. Try again or check for spelling errors.";
            }
            
        }
        else {
            echo "Press the connect button to connect to to the database.";
        }
        ?>
    </form>
    <div>
    
        <form class="form" method="post" action="">
            <p>Select Table</p>
	        <select id="Table" name="table">
                <?php
                if ($conectado) {
                    $query = "SHOW TABLES;";
                    $resultado = mysqli_query($conex, $query);
                    while ($tabla = $resultado->fetch_array(MYSQLI_NUM)) {
                        echo "<option value = '$tabla[0]'>$tabla[0]</option>";
                    }
                }
                
                ?>
            </select>
            </br>
            <input type="submit" name="select_table" value="Select">
            <?php
            if ($_POST["select_table"]) {
                $selected = $_POST["table"];
            }
            ?>
        </form>
        <form class="form" method="post" action="post.php">
        <input type="hidden" name="sel_table" value="<?php echo $selected;?>">
        <input type="hidden" name="db" value="<?php echo echo htmlspecialchars($_GET['db']);?>">
            <p>Values to insert</p>
            <?php 
            if ($conectado && $selected) {
                $query = "SELECT * FROM $selected;";
                $resultado = mysqli_query($conex, $query);
                while ($col = $resultado->fetch_field()) {
                    $nombre = $col->name;
                    if ($nombre != "id") {
                        echo "$nombre: <input type='box' name='$nombre' value=> Max length = $col->length, Datatype = $col->type <br>";
                    }
                }
            }
            ?>
            <br>
            <input type="submit" name="submit" value="submit">
        </form>
    </div>
</body>
</html>