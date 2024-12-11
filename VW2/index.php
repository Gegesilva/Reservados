<?php
header('Content-type: text/html; charset=ISO-8895-1');
include_once "../DB/conexaoSQL.php";
include_once "../DB/func.php";
validaUsuario($conn);
ini_set('max_input_vars', 3000);
error_reporting(0); // Desativa a exibição de todos os tipos de erros
ini_set('display_errors', '0'); // Garante que erros não sejam exibidos no navegador

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DATABIT</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../CSS/styleTab.css">
        <link rel="stylesheet" href="../CSS/colunasfix.css">
        <link rel="stylesheet" href="../CSS/style2.css">
</head>

<body>
        <div class="div-geral">
                <div class="d-flex justify-content-between">
                        <h2>EQUIPAMENTOS EM ESTOQUE</h2>
                        <button class="btn-reset" id="resetBtn">Reset</button>
                </div>
                <form id="form-princ" action="../vw/index.php" method="post">
                        <div class="form-group mb-3">
                                <input type="text" class="form-control" id="globalFilter" placeholder="Filtro Geral">
                                <button type="submit" class="btn-selecionados">COTAÇÃO</button>
                        </div>
                        <div class="table-container">
                                <?php
                                $sql = "SELECT
                                                FORMAT(DATACHEGADA, 'dd/MM/yyyy') DATACHEGADA,
                                                FORMAT(VALORBASE, 'C', 'pt-br') VALORBASE,
                                                VALORBASE VALORBASENUM,
                                                FORMAT(CUSTOSERIAL, 'C','pt-br') CUSTOSERIAL,
                                                FORMAT(AVISTA, 'C', 'pt-br') AVISTA,
                                                FORMAT(AVISTA3, 'C', 'pt-br') AVISTA3,
                                                FORMAT(AVISTA6, 'C', 'pt-br') AVISTA6,
                                                FORMAT(AVISTA9, 'C','pt-br') AVISTA9,
                                                FORMAT(BASICO, 'C','pt-br') BASICO,
                                                FORMAT(BASICO3, 'C','pt-br') BASICO3,
                                                FORMAT(BASICO6, 'C','pt-br') BASICO6,
                                                FORMAT(BASICO9, 'C','pt-br') BASICO9,
                                                FORMAT(ALMEJADO, 'C','pt-br') ALMEJADO,
                                                FORMAT(PALLET_AVISTA, 'C','pt-br') PALLET_AVISTA,
                                                FORMAT(PALLET, 'C','pt-br') PALLET,
                                                EMPRESA,
                                                CONTAINER,
                                                STATUS,
                                                MARCA,
                                               -- CONCAT(CODPRODUTO,' - ',MODELO) MODELO,
                                                MODELO,
                                                SERIE,
                                                ISNULL(NOME, 'Sem Faixa') FAIXA,
                                                PB,
                                                COLOR,
                                                TOTAL MedidorTotal,
                                                FATOR,
                                                SITUACAO,
                                                ORCAMENTO,
                                                CLIENTE,
                                                VENDEDOR,
                                                CLASSIFICACAO,
                                                OBSPEDIDO,
                                                OBSTECNICAS,
                                                NOTA,
                                                LOCAL,
                                                TB01010_QTPREV CONTREF,
                                                CODCLASSIFICACAO,
                                                CODCLIENTE,
                                                CAST(DTCAD AS DATE) DTCAD,
                                                CAST(DATACHEGADA AS DATE) DATACHEGADADATE
                                        FROM Equipamentos_Estoque_PHP
                                        LEFT JOIN TB01010 ON TB01010_CODIGO = CODPRODUTO
                                        LEFT JOIN GS_FAIXA ON GS_FAIXA.FAIXA = FATOR AND CODIGO = CODPRODUTO";
                                $stmt = sqlsrv_query($conn, $sql);

                                ?>

                                <table class="table table-borderless" id="sortableTable">
                                        <thead>
                                                <tr>
                                                        <!-- Cabeçalhos das Colunas com Filtro -->
                                                        <th class="sticky ">EMPRESA <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="0">
                                                        </th>
                                                        <th class="sticky">DATA CHEGADA <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="1">
                                                        </th>

                                                        <th class="sticky filterAgrup ">
                                                                <div class="filter-container">MARCA <i
                                                                                class="fa fa-sort"
                                                                                aria-hidden="true"></i><input
                                                                                onclick="clicouNoFilho(event)"
                                                                                oninput="showDropdown(3)" id="filter3"
                                                                                type="text" class="form-control filter filter-input"
                                                                                data-column="2">
                                                                        <div class="dropdown" id="dropdown3">
                                                                        </div>
                                                                </div>
                                                        </th>

                                                        <th class="sticky filterAgrup fixed fixed-col ">
                                                                <div class="filter-container">MODELO <i
                                                                                class="fa fa-sort"
                                                                                aria-hidden="true"></i><input
                                                                                onclick="clicouNoFilho(event)"
                                                                                oninput="showDropdown(4)" id="filter4"
                                                                                type="text" class="form-control filter filter-input"
                                                                                data-column="3">
                                                                        <div class="dropdown" id="dropdown4">
                                                                        </div>
                                                                </div>
                                                        </th>
                                                        <!-- <th class="sticky filterAgrup fixed fixed-col-2 ">
                                                                <div class="filter-container">SÉRIE <i
                                                                                class="fa fa-sort"
                                                                                aria-hidden="true"></i><input
                                                                                onclick="clicouNoFilho(event)"
                                                                                oninput="showDropdown(5)" id="filter5"
                                                                                type="text" class="form-control filter"
                                                                                data-column="4">
                                                                        <div class="dropdown" id="dropdown5">
                                                                        </div>
                                                                </div>
                                                        </th> -->
                                                         <th class="sticky  fixed2 fixed-col fixed-col-2">SÉRIE <i
                                                                        class="fa fa-sort" aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="4">
                                                        </th>
                                                        <th class="sticky ">STATUS <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="5">
                                                        </th>
                                                        <!-- <th class="sticky filterAgrup ">
                                                                <div class="filter-container">STATUS <i
                                                                                class="fa fa-sort"
                                                                                aria-hidden="true"></i><input
                                                                                onclick="clicouNoFilho(event)"
                                                                                oninput="showDropdown(6)" id="filter6"
                                                                                type="text" class="form-control filter"
                                                                                data-column="5">
                                                                        <div class="dropdown" id="dropdown6">
                                                                        </div>
                                                                </div>
                                                        </th> -->
                                                        <!-- <th class="sticky filterAgrup ">
                                                                <div class="filter-container">FAIXA <i
                                                                                class="fa fa-sort"
                                                                                aria-hidden="true"></i><input
                                                                                onclick="clicouNoFilho(event)"
                                                                                oninput="showDropdown(7)" id="filter7"
                                                                                type="text" class="form-control filter"
                                                                                data-column="6">
                                                                        <div class="dropdown" id="dropdown7">
                                                                        </div>
                                                                </div>
                                                        </th> -->
                                                
                                                        <th class="sticky ">FAIXA <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="6">
                                                        </th>
                                                        <th class="sticky">PB <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="7">
                                                        </th>
                                                        <th class="sticky">COLOR <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="8">
                                                        </th>
                                                        <th class="sticky">TOTAL <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="9">
                                                        </th>
                                                        <!-- <th class="sticky">VALOR BASE <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="8"> -->
                                                        </th>
                                                        <!-- <th class="sticky">FATOR <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="10">
                                                        </th> -->
                                                        <th class="sticky">A VISTA <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="10">
                                                        </th>
                                                        <th class="sticky">A VISTA + 3% <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="11">
                                                        </th>
                                                        <th class="sticky">A VISTA + 6% <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="12">
                                                        </th>
                                                        <th class="sticky">A VISTA + 9% <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="13">
                                                        </th>
                                                        <th class="sticky">BASICO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="14">
                                                        </th>
                                                        <th class="sticky">BASICO + 3% <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="15">
                                                        </th>
                                                        <th class="sticky">BASICO + 6% <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="16">
                                                        </th>
                                                        <th class="sticky">BASICO + 9% <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="17">
                                                        </th>
                                                        <th class="sticky">ALMEJADO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="18">
                                                        </th>
                                                        <th class="sticky">PALLET A VISTA <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="19">
                                                        </th>
                                                        <th class="sticky">PALLET <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="20">
                                                        </th>
                                                        <th class="sticky">SITUAÇÃO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="21">
                                                        </th>
                                                        <th class="sticky">CONTAINER <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="22">
                                                        </th>
                                                        <th class="sticky">ORCAMENTO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="23">
                                                        </th>
                                                        <th class="sticky">CLIENTE <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="24">
                                                        </th>
                                                        <th class="sticky">VENDEDOR <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="25">
                                                        </th>
                                                        <th class="sticky">CLASSIFICAÇÃO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="26">
                                                        </th>
                                                        <th class="sticky">OBS PEDIDO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="27">
                                                        </th>
                                                        <th class="sticky">OBS TECNICAS <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="28">
                                                        </th>
                                                        <th class="sticky">NOTA <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="29">
                                                        </th>
                                                        <th class="sticky">LOCAL <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="30">
                                                        </th>
                                                        <th class="sticky">COM VAR <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="31">
                                                        </th>
                                                        <th class="sticky">COM FIX <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="32">
                                                        </th>
                                                        <th class="sticky">BONUS 1<i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="33">
                                                        </th>
                                                        <th class="sticky">BONUS 2<i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="34">
                                                        </th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                <?php

                                                $tabela = "";
                                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $valorVenda = $row['VALORBASENUM'];
                                                        $contRef = $row['CONTREF'];
                                                        $medTotal = $row['MedidorTotal'];
                                                        $classificacao = $row['CODCLASSIFICACAO'];
                                                        $CodCliente = $row['CODCLIENTE'];
                                                        $dataChegada = $row['DATACHEGADA'];
                                                        $dtCad2018 = $row['DATACHEGADADATE'];
                                                        $pontuacao = $row['NOTA'];

                                                        /* Calculo de comissao variavel*/
                                                        if ($contRef != 0 && ($classificacao == '0001' || $classificacao == '0003' || $classificacao == '00013')) {
                                                                $razaoVenda = $valorVenda / $contRef;
                                                                $valorPagina = $razaoVenda * 0.0105;

                                                                $comissaoVariavel = $medTotal * $valorPagina;
                                                        } else {
                                                                $comissaoVariavel = 0;
                                                        }

                                                        /* Calculo de comissao fixa*/
                                                        if ($classificacao == '0025' || $classificacao == '0026' || $classificacao == '0030') {
                                                                $comissaoFixa = $valorVenda * 0.004;
                                                        } elseif ($classificacao == '0002') {
                                                                $comissaoFixa = $valorVenda * 0.01;
                                                        } elseif ($classificacao == '0010' && $CodCliente != '00001843') {
                                                                $comissaoFixa = $valorVenda * 0.0025;
                                                        } elseif ($classificacao == '0006') {
                                                                $comissaoFixa = $valorVenda * 0.03;
                                                        } elseif ($classificacao == '0014') {
                                                                $comissaoFixa = $valorVenda * 0.0025;
                                                        } elseif ($classificacao == '0010' && $CodCliente == '00001843') {
                                                                $comissaoFixa = $valorVenda * 0.005;
                                                        } else {
                                                                $comissaoFixa = $valorVenda * 0;
                                                        }

                                                        /* Calculo bonus 1 */
                                                        if ($dtCad2018 > $dataChegada) {
                                                                $bonus1 = /* $comissaoVariavel + */ ($comissaoVariavel * 0.2);
                                                        }

                                                        /* Calculo bonus 2 */
                                                        switch ($pontuacao) {
                                                                case 1:
                                                                        $percentPont = 1;
                                                                        break;
                                                                case 2:
                                                                        $percentPont = 0.58;
                                                                        break;
                                                                case 3:
                                                                        $percentPont = 0.12;
                                                                        break;
                                                                case 4:
                                                                        $percentPont = 0.05;
                                                                        break;
                                                                case 5:
                                                                        $percentPont = 0;
                                                                        break;
                                                        }

                                                        $bonus2 = /* $comissaoVariavel + */ ($comissaoVariavel * $percentPont);

                                                        /* Verifica se a serie esta na situação disponivel, se sim habilita a flag e input de valor */

                                                        $situacao = $row['SITUACAO'];
                                                        $inputRadio = "";
                                                        if ($situacao == 'DISPONIVEL') {
                                                                $inputRadio = "<input id='flagSerie' type='checkbox' name='selecionado[]' value='$row[SERIE]'>";
                                                                $inputVlr = "<input id='vlrembalagem' class='vlrembalagem' type='number' step='0.01' placeholder='Vlr Emb' name='vlrembalagem[]'>";
                                                        } else {
                                                                $primeiraLetra = substr($row['SITUACAO'], 0, 1);
                                                                $inputRadio = "<span class='R-reservado'>$primeiraLetra</span>";
                                                                $inputVlr = "";
                                                        }

                                                        /* Define o nome ficticio dos status */
                                                        /* $statusReal = $row['STATUS'];
                                                        if (strpos($statusReal, 'PRONTA') !== false && strpos($statusReal, 'PALLET') == false) {
                                                                $statusFic = 'PRONTA';
                                                        } elseif (strpos($statusReal, 'PRONTA') !== false && strpos($statusReal, 'PALLET') !== false) {
                                                                $statusFic = 'PRONTA PALLET';
                                                        } elseif (strpos($statusReal, 'SUCATA') !== false) {
                                                                $statusFic = 'SUCATA';
                                                        } elseif (strpos($statusReal, 'TRANSITO') !== false) {
                                                                $statusFic = 'TRANSITO';
                                                        } else {
                                                                $statusFic = 'PRODUÇÃO';
                                                        } */


                                                        $tabela .= "<tr>";
                                                        $tabela .= "<td class=''>" . $row['EMPRESA'] . "</td>";
                                                        $tabela .= "<td>" . $row['DATACHEGADA'] . "</td>";
                                                        $tabela .= "<td class=''>" . $row['MARCA'] . "</td>";
                                                        $tabela .= "<td class='sticky fixed fixed-col'>" . $row['MODELO'] . "</td>";
                                                        $tabela .= "<td class='sticky fixed2 fixed-col fixed-col-2'>$inputRadio " . $row['SERIE'] . "$inputVlr</td>";
                                                        $tabela .= "<td class=''>" . $row['STATUS'] . "</td>";
                                                        $tabela .= "<td class=''>" . $row['FAIXA'] . "</td>";
                                                        $tabela .= "<td>" . number_format($row['PB'], 0, '', '.') . "</td>";
                                                        $tabela .= "<td>" . number_format($row['COLOR'], 0, '', '.') . "</td>";
                                                        $tabela .= "<td>" . number_format($row['MedidorTotal'], 0, '', '.') . "</td>";
                                                        /* $tabela .= "<td>" . $row['VALORBASE'] . "</td>";
                                                        $tabela .= "<td>" . $row['FATOR'] . "</td>"; */
                                                        $tabela .= "<td style= 'background-color: #ffff89;'>" . $row['AVISTA'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ffff89;'>" . $row['AVISTA3'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ffff89;'>" . $row['AVISTA6'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ffff89;'>" . $row['AVISTA9'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ade0ee;'>" . $row['BASICO'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ade0ee;'>" . $row['BASICO3'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ade0ee;'>" . $row['BASICO6'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ade0ee;'>" . $row['BASICO9'] . "</td>";
                                                        $tabela .= "<td style='background-color: #e2f1bb;'>" . $row['ALMEJADO'] . "</td>";
                                                        $tabela .= "<td style='background-color: #ffae69;'>" . $row['PALLET_AVISTA'] . "</td>";
                                                        $tabela .= "<td style='background-color: #ffae69;'>" . $row['PALLET'] . "</td>";
                                                        $tabela .= "<td>" . $row['SITUACAO'] . "</td>";
                                                        $tabela .= "<td>" . $row['CONTAINER'] . "</td>";
                                                        $tabela .= "<td>" . $row['ORCAMENTO'] . "</td>";
                                                        $tabela .= "<td>" . $row['CLIENTE'] . "</td>";
                                                        $tabela .= "<td>" . $row['VENDEDOR'] . "</td>";
                                                        $tabela .= "<td>" . $row['CLASSIFICACAO'] . "</td>";
                                                        $tabela .= "<td>" . $row['OBSPEDIDO'] . "</td>";
                                                        $tabela .= "<td>" . $row['OBSTECNICAS'] . "</td>";
                                                        $tabela .= "<td>" . $row['NOTA'] . "</td>";
                                                        $tabela .= "<td>" . $row['LOCAL'] . "</td>";
                                                        $tabela .= "<td> R$ " . number_format($comissaoVariavel, 2, ',', '') . "</td>";
                                                        $tabela .= "<td> R$ " . number_format($comissaoFixa, 2, ',', '') . "</td>";
                                                        $tabela .= "<td> R$ " . number_format($bonus1, 2, ',', '') . "</td>";
                                                        $tabela .= "<td> R$ " . number_format($bonus2, 2, ',', '') . "</td>";
                                                        $tabela .= "</tr>";
                                                }
                                                $tabela .= "</table>";
                                                print ($tabela);
                                                ?>
                                        </tbody>
                                </table>
                </form>

        </div>
        <div class="acoes-rodape">
                <form action="../VW/cotacaoRec.php" method="POST">
                        <input class="input-rodape" name="codCotacao" type="text" placeholder="Recuperar Cotação">
                        <button class="btn-rodape">Gerar</button>
                </form>
                <form action="listar.php" method="POST">
                        <button class="btn-listar">Listar</button>
                </form>
                <button class="btn-sair" onclick="location.href='../login.php'">Sair</button>
        </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../JS/filtros.js" charset="utf-8"></script>
        <script src="../JS/forms.js" charset="utf-8"></script>
</body>

</html>