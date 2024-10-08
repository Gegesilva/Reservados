<?php
header('Content-type: text/html; charset=ISO-8895-1');
include_once "../DB/conexaoSQL.php";
include_once "../DB/filtros.php";

//Pega as series selecionadas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se alguma célula foi selecionada
    if (isset($_POST['selecionado']) && is_array($_POST['selecionado'])) {
        // Recupera os valores das células selecionadas
        $selecionados = $_POST['selecionado'];

        // Coloca os valores dentro de aspas simples e os separa por vírgula
        $seriesSelecionadas = implode(",", array_map('htmlspecialchars', $selecionados));
    }
}

$serieEnvio = urlencode(serialize($selecionados));

$serie = $_GET['serie'];


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
    <div class="form-geral">
        <img src="../img/logo.jpg" alt="logo">
        <div class="btn-solic-btn">
        </div>
        <h1 class="titulos"></h1>
        <div class="buttons-forms">
            <button class="btn-req" id="btn-req" style="color: black; opacity: 0.4;"
                onClick="window.location='index.php';" type="submit" class="voltar-btn-form">Equipamentos</button>
            <button class="btn-req" id="btn-req-sup" onClick="window.location='index2.php?serie=<?= $serieEnvio; ?>';"
                type="submit" class="voltar-btn-form">suprimentos</button>
        </div>
        <form method="POST" action="result.php">

            <h6 class="msg-os"></h6>
            <div class="form-group">
                <div class="form-input">
                    <label for="selecionado">Series *</label>
                    <textarea id="selecionado" name="selecionado" rows="1"
                        required><?= $seriesSelecionadas; ?></textarea>
                </div>
                <div class="form-input">
                    <label for="estado">Estado*</label>
                    <div class="custom-select">
                        <input type="text" name="estado" class="estado" id="selectEstado"
                            placeholder="Digite para filtrar" onkeyup="filterEstado()" >
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
                        <input type="text" name="class" class="class" id="selectClass" placeholder="Digite para filtrar"
                            onkeyup="filterClass()" required>
                        <div id="selectClassLista" class="select-items">
                            <?php filtroClass($conn); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-input">
                    <label for="class">Clientes * (Toma lugar do estado se for selecionado)</label>
                    <div class="custom-select">
                        <input type="text" name="cliente" class="cliente" id="selectCliente" placeholder="Digite para filtrar"
                            onkeyup="filterCliente()">
                        <div id="selectClienteLista" class="select-items">
                            <?php filtroCliente($conn); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-index">
                <input type="hidden" name="trava" id="trava" value="1">
                <button type="submit" class="submit-btn">Gerar</button>
                <a onClick="window.location='../vw2/index.php';" type="" class="voltar-btn-form">Voltar</a>
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