<?php

    include("./drivers/pdo.php");

    $mypdo = myConnect(array(
        'host'  => '127.0.0.1',
        'user'  => 'root',
        'pass'  => '',
        'db'    => 'empdpt'
    ));



    if(isset($_POST['delete'])){
        $ids = $_POST['delete_ids'];
        myMultipleDelete($mypdo,$_POST['delete_ids']);
        /*foreach($ids as $i){
            myDelete($mysqli,$i);
        } */
    }
    
    if (isset($_POST['insert'])) {
        $data = array(
            'nom'   => $_POST['nom'],
            'dpt'   => $_POST['dpt'],
        );
        myInsert($mypdo, $data);
        header('Location: ex2pdo.php');
    }
    
    $emps = myGetData($mypdo);


    $dpts = myGetDpt($mypdo);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EX DE PDO</title>
</head>
    <body>

        <h1>Lista de EMPLEATS</h1>

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
