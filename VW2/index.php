<?php
header('Content-type: text/html; charset=ISO-8895-1');
include_once "../DB/conexaoSQL.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATABIT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleTab.css">
    <link rel="stylesheet" href="../CSS/colunasfix.css">
    <link rel="stylesheet" href="../CSS/style2.css">
</head>

<body>
    <div class="div-geral">
        <div class="d-flex justify-content-between">
            <h2>EQUIP EM ESTOQUE</h2>
            <button class="btn-reset" id="resetBtn">Reset</button>
        </div>
        <form action="../vw/index.php" method="post">
            <div class="form-group mb-3">
                <input type="text" class="form-control" id="globalFilter" placeholder="Filtro Geral">
                <button type="submit" class="btn-selecionados">COTAÇÃO</button>
            </div>
            <div class="table-container">
                <?php
                $sql =
                    "SELECT 
                        FORMAT(DATACHEGADA, 'dd/MM/yyyy') DATACHEGADA,
                        FORMAT(VALORBASE, 'C', 'pt-br') VALORBASE,
                        FORMAT(CUSTOSERIAL, 'C','pt-br') CUSTOSERIAL,
                        FORMAT(ALMEJADO, 'C','pt-br') ALMEJADO,
                        FORMAT(MINIMO, 'C', 'pt-br') MINIMO,
                        FORMAT(BASICO, 'C', 'pt-br') BASICO,
                        FORMAT(PALLET, 'C', 'pt-br') PALLET,
                        CONTAINER
                        ,STATUS
                        ,MARCA
                        ,MODELO
                        ,SERIE
                        ,PB
                        ,COLOR
                        ,TOTAL
                        ,FATOR
                        ,PALLET
                        ,SITUACAO
                        ,ORCAMENTO
                        ,CLIENTE
                        ,VENDEDOR
                        ,CLASSIFICACAO
                        ,OBSPEDIDO
                        ,OBSTECNICAS
                        ,NOTA
                        ,LOCAL
                   FROM Equipamentos_Estoque_PHP";
                $stmt = sqlsrv_query($conn, $sql);

                ?>

                <table class="table table-borderless" id="sortableTable">
                    <thead>
                        <tr>
                            <!-- Cabeçalhos das Colunas com Filtro -->
                            <th class="sticky fixed">CONTAINER <input type="text" class="form-control filter"
                                    data-column="0"></th>
                            <th class="sticky fixed">DATA CHEGADA<input type="text" class="form-control filter"
                                    data-column="1"></th>
                            <th class="sticky fixed">STATUS <input type="text" class="form-control filter"
                                    data-column="2"></th>
                            <th class="sticky fixed">MARCA <input type="text" class="form-control filter"
                                    data-column="3"></th>
                            <th class="sticky fixed">MODELO <input type="text" class="form-control filter"
                                    data-column="4"></th>
                            <th class="sticky fixed">SERIE <input type="text" class="form-control filter"
                                    data-column="5"></th>
                            <th class="sticky">PB <input type="text" class="form-control filter" data-column="6"></th>
                            <th class="sticky">COLOR<input type="text" class="form-control filter" data-column="7"></th>
                            <th class="sticky">TOTAL<input type="text" class="form-control filter" data-column="8"></th>
                            <th class="sticky">CUSTOSERIAL<input type="text" class="form-control filter"
                                    data-column="9"></th>
                            <th class="sticky">VALOR BASE<input type="text" class="form-control filter"
                                    data-column="10"></th>
                            <th class="sticky">FATOR <input type="text" class="form-control filter" data-column="11">
                            </th>
                            <th class="sticky">MINIMO<input type="text" class="form-control filter" data-column="12">
                            </th>
                            <th class="sticky">BASICO<input type="text" class="form-control filter" data-column="13">
                            </th>
                            <th class="sticky">ALMEJADO<input type="text" class="form-control filter" data-column="14">
                            </th>
                            <th class="sticky">PALLET <input type="text" class="form-control filter" data-column="15">
                            </th>
                            <th class="sticky">SITUAÇÃO<input type="text" class="form-control filter" data-column="16">
                            </th>
                            <th class="sticky">ORCAMENTO<input type="text" class="form-control filter" data-column="17">
                            </th>
                            <th class="sticky">CLIENTE<input type="text" class="form-control filter" data-column="18">
                            </th>
                            <th class="sticky">VENDEDOR<input type="text" class="form-control filter" data-column="19">
                            </th>
                            <th class="sticky">CLASSIFICAÇÃO<input type="text" class="form-control filter"
                                    data-column="20"></th>
                            <th class="sticky">OBS PEDIDO<input type="text" class="form-control filter"
                                    data-column="21"></th>
                            <th class="sticky">OBS TECNICAS<input type="text" class="form-control filter"
                                    data-column="22"></th>
                            <th class="sticky">NOTA<input type="text" class="form-control filter" data-column="23"></th>
                            <th class="sticky">LOCAL<input type="text" class="form-control filter" data-column="24">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tabela = "";
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $tabela .= "<tr>";
                            $tabela .= "<td class='fixed'>" . $row['CONTAINER'] . "</td>";
                            $tabela .= "<td class='fixed'>" . $row['DATACHEGADA'] . "</td>";
                            $tabela .= "<td class='fixed'>" . $row['STATUS'] . "</td>";
                            $tabela .= "<td class='fixed'>" . $row['MARCA'] . "</td>";
                            $tabela .= "<td class='fixed'>" . $row['MODELO'] . "</td>";
                            $tabela .= "<td class='fixed'><input id='flagSerie' type='checkbox' name='selecionado[]' value='$row[SERIE]'> " . $row['SERIE'] . "</td>";
                            $tabela .= "<td>" . $row['PB'] . "</td>";
                            $tabela .= "<td>" . $row['COLOR'] . "</td>";
                            $tabela .= "<td>" . $row['TOTAL'] . "</td>";
                            $tabela .= "<td>" . $row['CUSTOSERIAL'] . "</td>";
                            $tabela .= "<td>" . $row['VALORBASE'] . "</td>";
                            $tabela .= "<td>" . $row['FATOR'] . "</td>";
                            $tabela .= "<td>" . $row['MINIMO'] . "</td>";
                            $tabela .= "<td>" . $row['BASICO'] . "</td>";
                            $tabela .= "<td>" . $row['ALMEJADO'] . "</td>";
                            $tabela .= "<td>" . $row['PALLET'] . "</td>";
                            $tabela .= "<td>" . $row['SITUACAO'] . "</td>";
                            $tabela .= "<td>" . $row['ORCAMENTO'] . "</td>";
                            $tabela .= "<td>" . $row['CLIENTE'] . "</td>";
                            $tabela .= "<td>" . $row['VENDEDOR'] . "</td>";
                            $tabela .= "<td>" . $row['CLASSIFICACAO'] . "</td>";
                            $tabela .= "<td>" . $row['OBSPEDIDO'] . "</td>";
                            $tabela .= "<td>" . $row['OBSTECNICAS'] . "</td>";
                            $tabela .= "<td>" . $row['NOTA'] . "</td>";
                            $tabela .= "<td>" . $row['LOCAL'] . "</td>";
                            $tabela .= "</tr>";
                        }
                        $tabela .= "</table>";
                        print ($tabela);
                        ?>
                    </tbody>
                </table>

        </form>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/filtros.js" charset="utf-8"></script>
    <script src="../JS/ordenacao.js" charset="utf-8"></script>
</body>

</html>