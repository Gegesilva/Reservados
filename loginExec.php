<?php
session_start();
include_once "DB/conexaoSQL.php";

$login = $_POST['username'];
$senha = $_POST['password'];

$_SESSION["username"]=$login;
$_SESSION["password"]=$senha;

    $sql="SELECT 
            TB01066_USUARIO Usuario,
            TB01066_SENHA Senha,
            TB01066_TIPO Tipo

        FROM 
            TB01066
        WHERE 
        TB01066_USUARIO = '$login'
        AND TB01066_SENHA = '$senha'";
    
    $stmt = sqlsrv_query($conn, $sql);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
             {
                $usuario = $row['Usuario'];
                $senha = $row['Senha'];
                $tipo = $row['Tipo'];
             }
    
    if($usuario != NULL){
        
        echo "<script>location.href='vw2/index.php'</script>";

    } else{
        echo"<script>window.alert('Usuario e/ou senha invalidos!')</script>";
        echo "<script>location.href='Login.php'</script>";

    }

    
