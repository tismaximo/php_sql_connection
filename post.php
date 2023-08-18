<?php
$conex = mysqli_connect("localhost", "root", "", $_POST['db']);
if ($conex) {
    $selected = $_POST["sel_table"];
    $query = "INSERT INTO $selected(";
    $getTableAndColsQuery = mysqli_query($conex, "SELECT * FROM $selected;");
    if ($getTableAndColsQuery) {
        while ($col = $getTableAndColsQuery->fetch_field()) {
            if ($col->name != "id") {
                $query = $query . "$col->name,";
            }

        }
        $query = substr($query, 0, -1);
        $query = $query . ") VALUES (";
    $getTableAndColsQuery = mysqli_query($conex, "SELECT * FROM $selected");
    if ($getTableAndColsQuery) {
        while ($col = $getTableAndColsQuery->fetch_field()) {
            if ($col->name != "id") {
                $value = $_POST[$col->name];
                if ($col->type == 253 || $col->type == 252 || $col->type == 10) {
                    $value = "'" . $_POST[$col->name] . "'"; 
                }
                
                
                $query = $query . "$value,";
            }
        }
        $query = substr($query, 0, -1) . ");";
        try {
            $submit = mysqli_query($conex, $query);
            if ($submit) {
                echo "The values have been successfully entered!";
            }
            else {
                echo "There was an error while sending a request to the database. Try submitting the form again.";
            }
        }
        catch (Exception $e) {
            echo "Error when sending the request: $e";
        }
        


    }
    else {
        echo "There was an error while sending a request to the database. Try submitting the form again.";
    }
  }
  else {
    echo "There was an error while sending a request to the database. Try submitting the form again.";
}
}
else {
    echo "There was an error while connecting to the database. Try submitting the form again.";
}
