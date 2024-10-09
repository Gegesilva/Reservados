<?php
function validaUsuario($conn)
{
    session_start();

    $login = $_SESSION["login"];
    $senha = $_SESSION["password"];

    $sql = "SELECT 
           TB01066_USUARIO Usuario,
           TB01066_SENHA Senha
       FROM 
           TB01066
       WHERE 
           TB01066_USUARIO = '$login'
           AND TB01066_SENHA = '$senha'";
    $stmt = sqlsrv_query($conn, $sql);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $usuario = $row['Usuario'];
        $senha = $row['Senha'];
    }
    if ($usuario != NULL) {

    } else {
       return print "<script>window.alert('É necessário fazer login!')</script>
                        <script>location.href='../login.php'</script>";
    }

}