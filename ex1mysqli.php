<?php

    include("../drivers/mysqli.php");

    $mysqli = myConnect(array(
        'host'  => '127.0.0.1',
        'user'  => 'root',
        'pass'  => '',
        'db'    => 'empdpt'
    ));



    if(isset($_POST['delete'])){
        $ids = $_POST['delete_ids'];
        myMultipleDelete($mysqli,$_POST['delete_ids']);
/*         foreach($ids as $i){
            myDelete($mysqli,$i);
        } */
    }
    
    if (isset($_POST['insert'])) {
        $data = array(
            'nom'   => $_POST['nom'],
            'dpt'   => $_POST['dpt'],
        );
        myInsert($mysqli, $data);
        header('Location: index.php');
    }
    
    $emps = myGetData($mysqli);


    $dpts = myGetDpt($mysqli);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EX de MYSQLI</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #1a1a1a;
            color: #fff;
        }

        h1 {
            color: #ff4081;
        }

        .employee-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            border: 1px solid #263238;
            background-color: #263238;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .employee-info {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            margin-left: 10px;
        }

        p {
            margin: 0;
            padding: 5px;
        }

        select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #263238;
            background-color: #263238;
            color: #fff;
        }

        /* Estilos para el formulario de inserción y eliminación */
        form {
            margin-top: 20px;
            background-color: #4a148c;
            padding: 20px;
            border-radius: 8px;
        }

        label {
            color: #fff;
            margin-right: 10px;
        }

        input[type="text"],
        input[type="number"] {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ff4081;
            border-radius: 4px;
            background-color: #1a1a1a;
            color: #fff;
        }

        input[type="submit"],
        input[type="checkbox"] {
            background-color: #ff4081;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        input[type="checkbox"]:hover {
            background-color: #d81b60;
        }
    </style>
</head>
<body>

<h1>Lista de Empleados</h1>

<form name="deleteForm" action="" method="post">
    <?php if (isset($emps) && is_array($emps)): ?>
        <?php foreach ($emps as $e): ?>
            <div class="employee-container">
                <input type="checkbox" name="delete_ids[]" value="<?= $e['id'] ?>">
                <div class="employee-info">
                    <p>ID: <?= $e['id'] ?></p>
                    <p>NOM: <?= $e['nom'] ?></p>
                    <p>DPT: <?= $e['dpt'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        <input type="submit" value="Eliminar seleccionados" name="delete">
    <?php else: ?>
        <p>No se encontraron datos de empleados.</p>
    <?php endif; ?>
</form>


<!-- Formulario de Inserción -->
<form name="f1" action="" method="post">
    <label for="nom">NOM:</label>
    <input type="text" name="nom" required>
    <br/>
    <label for="dpt">DPT:</label>
    <input type="number" name="dpt" required>
    <br/>
    <input type="submit" value="Insertar" name="insert">
</form>

</body>
</html>
