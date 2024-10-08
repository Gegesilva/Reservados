<?php
header('Content-type: text/html; charset=ISO-8895-1');
include_once "../DB/conexaoSQL.php";
include_once "../DB/filtros.php";
include_once "../Config.php";
/* pega o array recebido no formado de URL e transforma em array comum */
$serie = unserialize(urldecode($_GET['serie']));

if ($serie) {
    /* coloca os itens do array saparados por virgula */
    $seriesSelecionadas = implode(",", array_map('htmlspecialchars', $serie));
    /* coloca os itens ds array entre aspas simples e separa por virgula */
    $seriesSelecionadasAspas = "'" . implode("', '", array_map('htmlspecialchars', $serie)) . "'";
}

/* Pega o codigo do prod */
if ($seriesSelecionadasAspas) {
    $sql = "SELECT STRING_AGG(TB02054_PRODUTO, ',') Prod FROM TB02054
        WHERE TB02054_NUMSERIE IN ($seriesSelecionadasAspas)
        AND TB02054_QTPROD > TB02054_QTPRODS";

    $stmt = sqlsrv_query($conn, $sql);

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $Prod = $row['Prod'];
    }
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
</head>

<body>
    <!--  <form method="POST" class="form-geral" action="<?= $url ?>/save.php"> -->
    <div class="div-save" id="div-save"></div>
    <div class="div-form">
        <div class="form-geral">
            <img src="../img/logo.jpg" alt="logo">
            <div class="btn-solic-btn">
            </div>
            <h1 class="titulos"></h1>
            <div class="buttons-forms">
                <button class="btn-req" id="btn-req" onClick="voltar();" type="submit"
                    class="voltar-btn-form">EQUIPAMENTOS</button>
                <button class="btn-req" id="btn-req-sup" style="color: black; opacity: 0.4;"
                    onClick="window.location='index2.php';" type="submit" class="voltar-btn-form">SUPRIMENTOS</button>
            </div>
            <form method="POST" action="result2.php">
                <h6 class="msg-os"></h6>
                <div class="form-group">
                    <div class="form-input">
                        <label for="produto">Produto</label>
                        <textarea id="selecionado" name="selecionado" rows="1" required><?= $Prod; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-input">
                        <label for="tipo">Tipo *</label>
                        <select name="tipo" id="" required>
                            <option value="01">Suprimento</option>
                            <option value="00">Equipamento</option>
                        </select>
                    </div>
                    <div class="form-input">
                        <label for="estado">Estado*</label>
                        <div class="custom-select">
                            <input type="text" name="estado" class="estado" id="selectEstado"
                                placeholder="Digite para filtrar" onkeyup="filterEstado()" required>
                            <div id="selectEstadoLista" class="select-items">
                                <?php filtroEstado($conn); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-input">
                        <label for="pessoa">Tipo Pessoa *</label>
                        <select name="pessoa" id="">
                            <option value="J">Juridica</option>
                            <option value="F">Fisica</option>
                        </select>
                    </div>
                    <div class="form-input">
                        <label for="consumo">CONS/REV *</label>
                        <select name="consumo" id="">
                            <option value="S">Consumo</option>
                            <option value="N">Revenda</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-input">
                        <label for="condicao">Condição de Receb *</label>
                        <div class="custom-select">
                            <input type="text" name="condicao" class="condicao" id="selectCondicao"
                                placeholder="Digite para filtrar" onkeyup="filterCondicao()" required>
                            <div id="selectCondicaoLista" class="select-items">
                                <?php filtroCondicao($conn); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-input">
                        <label for="condicao">Tabela *</label>
                        <div class="custom-select">
                            <input type="text" name="tabela" class="tabela" id="selectTabela"
                                placeholder="Digite para filtrar" onkeyup="filterTabela()" required>
                            <div id="selectTabelaLista" class="select-items">
                                <?php filtroTabela($conn); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-input">
                        <label for="class">Classificação *</label>
                        <div class="custom-select">
                            <input type="text" name="class" class="class" id="selectClass"
                                placeholder="Digite para filtrar" onkeyup="filterClass()" required>
                            <div id="selectClassLista" class="select-items">
                                <?php filtroClass($conn); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-index">
                    <input type="hidden" name="trava" id="trava" value="1">
                    <button type="submit" class="submit-btn">Gerar</button>
                    <!--  <button onClick="window.location='.php';" type="submit"
                    class="voltar-btn-form">Voltar</button> -->
                </div>
                <input type="hidden" id="urlOS" value="<?= $url ?>/save.php">
            </form>
            <?php
            /* gera um codigo de 6 numeros pseudo aleatorio */

            //echo 'A'.sprintf("%'.05d\n",  mt_rand(0, 0xF00));
            ?>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../JS/script.js" charset="utf-8"></script>
</body>

</html>