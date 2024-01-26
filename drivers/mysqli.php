<?php
    function myConnect($data)
    {
        $mysqli = new mysqli($data['host'], $data['user'], $data['pass'], $data['db']);

        if ($mysqli->connect_error)
        {
            return null;
        }

        return $mysqli;
    }


    function myGetData($mysqli){
        $sql = "select * from emp";
        $result = $mysqli->query($sql);
        
        if(!$result)
            return null;
        $data = array();
        while($row = $result->fetch_row()){
            $data[] = array(
                'id'    => $row[0],
                'nom'   => $row[1],
                'dpt'   => $row[2],
            );
        }
        $result->close();
        return $data;
    }

    function myGetDpt($mysqli){
        $sql = "select * from dpt";
        $result = $mysqli->query($sql);
        
        if(!$result)
            return null;
        $data = array();
        while($row = $result->fetch_row()){
            $data[] = array(
                'id'    => $row[0],
                'nom'   => $row[1],
            );
        }
        $result->close();
        return $data;
    }

    function myInsert($mysqli, $data)
    {
        if ($stmt = $mysqli->prepare("insert into emp (nom,dpt) values (?, ?)"))
        {
            /* $a = array ($data['nom'], $data['dpt']); */
            $stmt->bind_param("si", $data['nom'], $data['dpt']);
            $stmt->execute();
            return true;
        }
        return false;
    }

    function myDelete($mysqli, $where) {
        $stmt = $mysqli->prepare("DELETE FROM emp WHERE id = ?");
        $stmt->bind_param("i", $where);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
    
    function myMultipleDelete($mysqli, $where){
        if($stmt = $mysqli->prepare('delete from emp where id=?')){
            foreach($where as $id){
                $stmt->bind_param("i", $id);
                $stmt->execute();
            }
            $mysqli->commit();
            
            return true;
        }
        $mysqli->rollback();
        return false;
    }

?>