<?php

include 'bd/BD.php';

header('Access-Control-Allow-Origin: *');

$statusOk = "HTTP/1.1 200 OK";
$badRequest = "HTTP/1.1 400 Bad Request";
$table = "frameworks";

if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['id'])){
        $query="select * from $table where id=".$_GET['id'];
        $result=getMethod($query);
        echo json_encode($result->fetch(PDO::FETCH_ASSOC));
    }else{
        $query="select * from $table";
        $result=getMethod($query);
        echo json_encode($result->fetchAll()); 
    }
    header($statusOk);
    exit();
}

if($_POST['METHOD']=='POST'){
    unset($_POST['METHOD']);
    $nombre=$_POST['nombre'];
    $lanzamiento=$_POST['lanzamiento'];
    $desarrollador=$_POST['desarrollador'];
    $query="insert into $table(nombre, lanzamiento, desarrollador) values ('$nombre', '$lanzamiento', '$desarrollador')";
    $queryAutoIncrement="select MAX(id) as id from $table";
    $result=putMethod($query, $queryAutoIncrement);
    echo json_encode($result);
    header($statusOk);
    exit();
}

if($_POST['METHOD']=='PUT'){
    unset($_POST['METHOD']);
    $id=$_GET['id'];
    $nombre=$_POST['nombre'];
    $lanzamiento=$_POST['lanzamiento'];
    $desarrollador=$_POST['desarrollador'];
    $query="UPDATE $table SET nombre='$nombre', lanzamiento='$lanzamiento', desarrollador='$desarrollador' WHERE id='$id'";
    $result=putMethod($query);
    echo json_encode($result);
    header($statusOk);
    exit();
}

if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);
    $id=$_GET['id'];
    $query="DELETE FROM $table WHERE id='$id'";
    $result=deleteMethod($query);
    echo json_encode($result);
    header($statusOk);
    exit();
}

header($badRequest);


?>