<?php
/*
	// EXEMPLE FUNCIONS NATIVES ----------------------
	
	$con = mysql_connect ('127.0.0.1', 'root', '');
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if (!$con) {
		die ("Error  connect");
		exit;
	}
	mysql_select_db ('pruebas');
	
	$var = '1';
	$var = 3; delete from items;
	
	$sql = "select * from items where id_item=$var";
	
	$sql = "select * from users where user='" . $user . "' and pass='" . $pass . "'";
	$user=marc' or true --
	
	$res = mysql_query ($sql);
	while (($r = mysql_fetch_array($res))) {
		echo "$r[1]<br>";
	}
	
	mysql_free_result ($res);
*/


/*
	// EXEMPLE FUNCIONAMENT PDO ----------------------

	$dsn = 'mysql:dbname=pruebas;host=127.0.0.1';
	$user = 'root';
	$password = '';

	try {
		$db = new PDO($dsn, $user, $password);
		echo "Connexio satisfactoria<br />";
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
		print_r($db->errorInfo());
	}

*/


	// EXEMPLE INSERT PDO, REQUEREIX CONNEXIÓ PDO ----------------------
	// Inserció
	$count = $db->exec("INSERT INTO items VALUES (10, 'XQUERY')");
	echo "$count<br />";


	$sql 		= 'SELECT * FROM items WHERE id_item > :min AND id_item < :max';
	$statement 	= $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$statement->execute(array(':min' => 2, ':max' => 5));
	$res1 = $statement->fetchAll();
	for ($i=0; $i<count($res1); $i++) echo $res1[$i][1];
	echo "<br /><br />";
	
	$statement->execute(array(':min' => 3, ':max' => 3));
	$res2 = $statement->fetchAll();
	

// PDO::ATTR_CURSOR a PDO::CURSOR_SCROLL 
/*
	$sql2 = 'SELECT * FROM items WHERE id_item > ? AND id_item < ?';
	$statement = $db->prepare($sql2);
	$statement->execute(array(4, 6));
	$res1 = $statement->fetchAll();
	for ($i=0; $i<count($res1); $i++) echo $res1[$i][1];
	
	$sql3 = 'SELECT * FROM items';
	foreach ($conn->query($sql3) as $row) {
        print $row['calories'] . "<br />\n";
    }
*/
/*
	$_id = 15;
	$_nom = 'marc';
	
	$sql4 = "INSERT INTO items VALUES (:id, :nom)";
	$st = $db->prepare($sql4);
	$st->bindParam(':id', $_id, PDO::PARAM_INT); // bindValue
	$st->bindParam(':nom', $_nom, PDO::PARAM_STR); // 
	$st->execute();
*/


	// EXEMPLE TRANSACCIONS PDO, REQUEREIX CONNEXIÓ PDO ----------------------
	// Inicia transacció. Anulem  autocommit 
	$db->beginTransaction();

	$sth = $db->exec("UPDATE items SET times=3 where id_item=10");
	echo "Res = " . $sth;
	// $db->rollBack();
	$db->commit();


/*
	$db->beginTransaction();

	$sth = $db->exec("UPDATE items SET times=25 where id_item=10");
	$sth = $db->exec("DROP TABLE xx");
	$db->rollBack();
	
	$db->beginTransaction();
	$sth = $db->exec("UPDATE items SET times=30 where id_item=10");

	$db->rollBack();
*/





	if (isset ($_POST['snd'])) {
		$con = mysql_connect ('127.0.0.1', 'root', '');
		if (!$con) {
			die ("Error  connect");
			exit;
		}
		mysql_select_db ('pruebas');
	
		$id 	= $_POST["uid"];
		$pass 	= $_POST["pass"];
		
		// magic_quotes deprecated
		echo "<br />Argument=$id. Amb magic quotes=" . addslashes($id);
		echo "<br />";
		
		$sql = "select * from users where uid='" . $id . "' and pass='" . $pass . "'";
		echo "$sql";
		
		// Entrada primera: user=//' or true -- //
		// Entrada segona: //'admin' -- //
		// '; drop table t; -- 
		
		$res = mysql_query ($sql);
        
		while (($r = mysql_fetch_array($res)))
        {
			echo "$r[0]  $r[1]  <br>";
		}
		mysql_free_result ($res);
	}
	?>
	
	<form name='frm' method='post' action=''>
		User: <input type="text" name="uid" /><br>
		Pass: <input type="password" name="pass" /><br>
		<input name="snd" type="submit" value="Enviar" />
	</form>