<?php
header('Content-type: text/html; charset=ISO-8895-1');
include_once "../DB/conexaoSQL.php";
include_once "../DB/filtros.php";
include_once "../Config.php";


$tipo = $_POST['tipo'];
$estado = $_POST['estado'];
$pessoa = $_POST['pessoa'];
$consumo = $_POST['consumo'];
$condicao = $_POST['condicao'];
$produto = $_POST['produto'];
$cliente = $pessoa . ':' . $estado;

/* Pega o codigo da cindição pelo nome passado pelo input da lista */
$sql = "SELECT TB01014_CODIGO Cod FROM TB01014
        WHERE TB01014_NOME = '$condicao'";

$stmt = sqlsrv_query($conn, $sql);

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $codCond = $row['Cod'];
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATABIT</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/styleBtn.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!--  <form method="POST" class="form-geral" action="<?= $url ?>/save.php"> -->
    <div class="div-save" id="div-save"></div>
    <div class="div-form">
        <div class="divResult">
            <img src="../img/logo.jpg" alt="logo">
            <div class="btn-solic-btn">
            </div>
            <h1 class="titulos"></h1>
            <div class="buttons-forms">

            </div>
            <h6 class="msg-os"></h6>
            <div class="form-group">
                <div class="form-input">
                    <?php
                    $sql = "-- Parametros de Entrada
                    DECLARE @EMPRESA VARCHAR(2); -- Código da Empresa
                    DECLARE @PRODUTO VARCHAR(5); -- Código do Produto
                    DECLARE @OPERACAO VARCHAR(2); -- Código Operação de Venda
                    DECLARE @CONDICAO VARCHAR(3); -- Código Condição de Pagamento
                    DECLARE @CLIENTE VARCHAR(8); -- Código do cliente (ZZZZZZZZ, para um cliente genérico)(F:SP, F:RJ, F:UF - PARA PESSOA FISICA)(J:SP, J:RJ, J:UF - PARA PESSOA JURIDICA)
                    DECLARE @VENDACONS VARCHAR(1); -- Venda para Consumo (S ou N)
                    DECLARE @TABELA VARCHAR(2); -- Código da Tabela de Preços
                    DECLARE @VALORINICIAL NUMERIC(11,2) -- Valor Inicial (preencher com zero)
                    
                    -- Sintaxe 
                    SELECT @EMPRESA = '00';
                    SELECT @PRODUTO = '$produto';
                    SELECT @OPERACAO = '$tipo';
                    SELECT @CONDICAO = '$codCond';
                    SELECT @CLIENTE = '$cliente'; --00000780
                    SELECT @VENDACONS = '$consumo';
                    SELECT @TABELA = '00';
                    SELECT @VALORINICIAL = 0;
                    
                    select 
                    
                    @PRODUTO AS CODPRODUTO,
                    TB01010_REFERENCIA AS REFERENCIA,
                    TB01010_NOME AS NOME,
                    FORMAT(VALOR, 'C', 'pt-br') AS VALORPROTUTO,
                    FORMAT(VALORIPI, 'C','pt-br') AS VALORIPI,
                    FORMAT(VALORST, 'C','pt-br') AS ST,
                    FORMAT(DIFALIQ, 'C','pt-br') AS DIFALST,
                    FORMAT(VALORFINAL, 'C','pt-br') AS VALORFINAL
                    
                    
                    from FT02002(@EMPRESA,@PRODUTO,@OPERACAO,@CONDICAO,@CLIENTE,@VENDACONS,@TABELA,@VALORINICIAL)
                    LEFT JOIN TB01010 ON TB01010_CODIGO = @PRODUTO
                  ";
                    $stmt = sqlsrv_query($conn, $sql);

                    if ($stmt === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    ?>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>PRODUTO</th>
                                <th>REFERENCIA</th>
                                <th>DESCRIÇÃO</th>
                                <th>VALOR PRODUTO</th>
                                <th>VALOR IPI</th>
                                <th>ST</th>
                                <th>DIFAL ST</th>
                                <th>VALOR FINAL</th>
                            </tr>
                        </thead>

                        <?php
                        $tabela = "";
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $tabela .= "<tr>";
                            $tabela .= "<td>" . $row['CODPRODUTO'] . "</td>";
                            $tabela .= "<td>" . $row['REFERENCIA'] . "</td>";
                            $tabela .= "<td>" . $row['NOME'] . "</td>";
                            $tabela .= "<td>" . $row['VALORPROTUTO'] . "</td>";
                            $tabela .= "<td>" . $row['VALORIPI'] . "</td>";
                            $tabela .= "<td>" . $row['ST'] . "</td>";
                            $tabela .= "<td>" . $row['DIFALST'] . "</td>";
                            $tabela .= "<td>" . $row['VALORFINAL'] . "</td>";
                            $tabela .= "</tr>";
                        }
                        $tabela .= "</table>";

                        print ($tabela);


                       /*  echo $condicao.' '.$codCond; */
                        ?>
                </div>
            </div>
            <div class="btn-index">
                <input type="hidden" name="trava" id="trava" value="1">
                <button onClick="voltar();" type="submit" class="voltar-btn-form">Voltar</button>
            </div>
            <input type="hidden" id="urlOS" value="<?= $url ?>/save.php">
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../JS/script.js" charset="utf-8"></script>
</body>

</html>