<?php

// EXEMPLE FUNCIONAMENT PDO ----------------------


    function myConnect($data){

        $dsn = 'mysql:dbname=empdpt;host=127.0.0.1';
        $user = 'root';
        $password = '';

        try {
            $db = new PDO($dsn, $user, $password);
            echo "Connexio satisfactoria<br />";
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            print_r($db->errorInfo());
        }
        return $db;
    }


    function myGetData($db){
        $sql = "select * from emp";
        $result = $db->query($sql);
        
        if(!$result)
            return null;
        $data = array();
        while($row = $result->fetch()){
            $data[] = array(
                'id'    => $row[0],
                'nom'   => $row[1],
                'dpt'   => $row[2],
            );
        }
        $result->closeCursor();
        return $data;
    }

    function myGetDpt($db){
        $sql = "select * from dpt";
        $result = $db->query($sql);
        
        if(!$result)
            return null;

        $data = array();
        while($row = $result->fetch()){
            $data[] = array(
                'id'    => $row[0],
                'nom'   => $row[1],
            );
        }
        $result->closeCursor();
        return $data;
    }

    
    function myInsert($db, $data){
    
        if ($stmt = $db->prepare("insert into emp (nom,dpt) values (:nom, :dpt)"))
        {
            $stmt->bindParam(":nom", $data['nom'], PDO::PARAM_STR, 64);
            $stmt->bindParam(":dpt", $data['dpt'], PDO::PARAM_INT);
            $stmt->execute();
            return true;
        }
        return false;
    }

    function myDelete($db, $where) {
        $stmt = $db->prepare("DELETE FROM emp WHERE id = :id");
        $stmt->bindParam(":id", $where, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            $stmt->closeCursor();
            return true;
        } else {
            $stmt->closeCursor();
            return false;
        }
    }
    
    function myMultipleDelete($db, $where){
        $db->beginTransaction();

        if($stmt = $db->prepare("DELETE from emp where id = :id")){
            foreach($where as $id){
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            $db->commit();
            
            return true;
        }
        $db->rollBack();
        return false;
    }