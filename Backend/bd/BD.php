<?php

$pdo= null;
$host= "localhost";
$user= "root";
$password= "";
$bd= "crudreactphp";

function connect(){
    $errorMessege = "Error!: No se pudo conectar a la bd ";
    try{
        $GLOBALS['pdo']=new PDO("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['bd']."", $GLOBALS['user'], $GLOBALS['password']);
        $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e){
        print $errorMessege.$bd."<br/>";
        print "\nError!: ".$e."<br/>";
        die();
    }
}

function desconnect() {
    $GLOBALS['pdo']=null;
}

function getMethod($query){
    try{
        connect();
        $stmt=$GLOBALS['pdo']->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        desconnect();
        return $stmt;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}

function postMethod($query, $queryAutoIncrement){
    try{
        connect();
        $stmt=$GLOBALS['pdo']->prepare($query);
        $stmt->execute();
        $idAutoIncrement=getMethod($queryAutoIncrement)->fetch(PDO::FETCH_ASSOC);
        $result=array_merge($idAutoIncrement, $_POST);
        $stmt->closeCursor();
        desconnect();
        return $result;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}


function putMethod($query){
    try{
        connect();
        $stmt=$GLOBALS['pdo']->prepare($query);
        $stmt->execute();
        $result=array_merge($_GET, $_POST);
        $stmt->closeCursor();
        desconnect();
        return $result;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}

function deleteMethod($query){
    try{
        connect();
        $stmt=$GLOBALS['pdo']->prepare($query);
        $stmt->execute();
        $stmt->closeCursor();
        desconnect();
        return $_GET['id'];
    }catch(Exception $e){
        die("Error: ".$e);
    }
}

?>