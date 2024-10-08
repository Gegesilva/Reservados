<?php
header('Content-type: text/html; charset=ISO-8895-1');
include_once "../DB/conexaoSQL.php";
include_once "../DB/filtros.php";
include_once "../DB/func.php";
include_once "../Config.php";

validaUsuario($conn);

$tipo = $_POST['tipo'];
$estado = $_POST['estado'];
$pessoa = $_POST['pessoa'];
$consumo = $_POST['consumo'];
$condicao = $_POST['condicao'];
$tabelaCust = $_POST['tabela'];
$cliente = $pessoa . ':' . $estado;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produtos = explode(',', $_POST['selecionado']); // Converte a string em array
    /* print_r($series); */ // Exibe o array
}

/* Pega o codigo da condição pelo nome passado pelo input da lista */
$sql = "SELECT TB01014_CODIGO Cod FROM TB01014
        WHERE TB01014_NOME = '$condicao'";

$stmt = sqlsrv_query($conn, $sql);

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $codCond = $row['Cod'];
}

/* Pega o codigo da tabela pelo nome passado pelo input da lista */
$sql = "SELECT TB01020_CODIGO Cod FROM TB01020
        WHERE TB01020_NOME = '$tabelaCust'
        AND TB01020_SITUACAO = 'A'";

$stmt = sqlsrv_query($conn, $sql);

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $tabelaCustCod = $row['Cod'];
}

/* Da o nome correto para a variavel consumo */
if ($consumo == 'N') {
    $nomeConsumo = 'Revenda';
} else {
    $nomeConsumo = 'Consumo';
}

/* Da o nome correto para a variavel tipo */
if ($tipo == '00') {
    $nomeTipo = 'Equipamento';
} else {
    $nomeTipo = 'Suprimento';
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATABIT</title>
    <link rel="stylesheet" href="../CSS/styleResult.css">
    <link rel="stylesheet" href="../CSS/styleBtn.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="cabecalho-result">
        <img class="logo" src="../img/logo.jpg" alt="logo">
        <div class="info-bloco">
            <div>
                <span><b>Estado:</b> <?= $estado; ?></span>
                <span><b>Pessoa</b>: <?= $cliente; ?></span>
            </div>
            <div>
                <span><b>Tipo Consumo:</b> <?= $nomeConsumo; ?></span>
                <span><b>Condição:</b> <?= $condicao; ?></span>
            </div>
            <div>
                <span><b>Tipo:</b> <?= $nomeTipo; ?></span>
            </div>
        </div>
    </div>

    <h6 class="msg-os"></h6>
    <div class="form-group">
        <div class="form-input">
            <table class="table">
                <thead>
                    <tr>
                        <th>PRODUTO</th>
                        <th>REFERENCIA</th>
                        <th class="currency">VALOR PRODUTO</th>
                        <th class="currency">VALOR IPI</th>
                        <th class="currency">ST</th>
                        <th class="currency">DIFAL ST</th>
                        <th class="currency">VALOR FINAL</th>
                    </tr>
                </thead>
                <?php
                // Verifica se alguma célula foi selecionada
                if (isset($produtos) && is_array($produtos)) {
                    // Recupera os valores das células selecionadas
                    $selecionados = $produtos;

                    foreach ($selecionados as $item) {
                        $produto = htmlspecialchars($item);
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
                                SELECT @TABELA = '$tabelaCustCod';
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
                        ?>
                        <tbody>
                            <?php
                            $tabela = "";
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $tabela .= "<tr>";
                                $tabela .= "<td>" . $row['CODPRODUTO'] . "</td>";
                                $tabela .= "<td>" . $row['REFERENCIA'] . "</td>";
                                $tabela .= "<td class='currency'>" . $row['VALORPROTUTO'] . "</td>";
                                $tabela .= "<td class='currency'>" . $row['VALORIPI'] . "</td>";
                                $tabela .= "<td class='currency'>" . $row['ST'] . "</td>";
                                $tabela .= "<td class='currency'>" . $row['DIFALST'] . "</td>";
                                $tabela .= "<td class='currency'>" . $row['VALORFINAL'] . "</td>";
                                $tabela .= "</tr>";
                            }
                            /* $tabela .= "</table>"; */

                            print ($tabela);
                    }
                }
                /* } */

                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total</th>
                        <th id="totalProduto" class="currency">R$ 0,00</th>
                        <th id="totalIPI" class="currency">R$ 0,00</th>
                        <th id="totalST2" class="currency">R$ 0,00</th>
                        <th id="totalDifalST2" class="currency">R$ 0,00</th>
                        <th id="totalValorFinal2" class="currency">R$ 0,00</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="btn-index">
        <input type="hidden" name="trava" id="trava" value="1">
        <button onClick="voltar();" type="submit" class="voltar-btn-form">Voltar</button>
    </div>
    <input type="hidden" id="urlOS" value="<?= $url ?>/save.php">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../JS/script.js" charset="utf-8"></script>
    <script src="../JS/totalizadores2.js" charset="utf-8"></script>
</body>

</html>