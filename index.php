<?php

include 'bd/BD.php';

header('Acces-Control-Allow-Origin: *'); //esto nos permitira recibir peticiones de cualquier url

if ($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['id'])){ //preguntamos si en la url viene un id
        $query="select * from frameworks where id=".$_GET['id'];
        $resultado=metodoGet($query); //aqui usamos el metodo get y guardamos el resultado en una variable
        echo json_encode($resultado->fetch(PDO::FETCH_ASSOC));
    }else{
        $query="select * from frameworks";
        $resultado=metodoGet($query); //aqui usamos el metodo get y guardamos el resultado en una variable
        echo json_encode($resultado->fetchAll()); //fetchall devuelve un array con todas las filas de los datos
    }
    header("HTTP/1.1 200 OK");
    exit();
}

if ($_POST['METHOD']=='POST'){
    unset($_POST['METHOD']);
    $nombre=$_POST['nombre'];
    $lanzamiento=$_POST['lanzamiento'];
    $desarrollador=$_POST['desarrollador'];
    $query="insert into frameworks(nombre, lanzamiento, desarrollador) values ('$nombre', '$lanzamiento', '$desarrollador')";
    $queryAutoIncrement="select MAX(id) as id from frameworks";
    $resultado=metodoPost($query, $queryAutoIncrement);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='PUT'){
    unset($_POST['METHOD']);
    $id=$_GET['id'];
    $nombre=$_POST['nombre'];
    $lanzamiento=$_POST['lanzamiento'];
    $desarrollador=$_POST['desarrollador'];
    $query="UPDATE frameworks SET nombre='$nombre', lanzamiento='$lanzamiento', desarrollador='$desarrollador' WHERE id='$id'";
    $resultado=metodoPut($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);
    $id=$_GET['id'];
    $query="DELETE FROM frameworks WHERE id='$id'";
    $resultado=metodoDelete($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

header("HTTP/1.1 400 Bad Request");