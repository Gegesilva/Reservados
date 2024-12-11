<?php
header('Content-type: text/html; charset=ISO-8895-1');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtro de Tabela com Navegação</title>
    <link rel="stylesheet" href="../CSS/listar.css">
    <link rel="stylesheet" href="../CSS/styleTab.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <div id="loadingScreen">Carregando...</div>

    <div class="filter-container">
        <div>
            <label for="startDate">Data Início:</label>
            <input class="filters" type="date" id="startDate">
        </div>
        <div>
            <label for="endDate">Data Fim:</label>
            <input class="filters" type="date" id="endDate">
        </div>
        <div>
            <label for="filterClient">Cliente:</label>
            <input class="filters" type="text" id="filterClient" placeholder="Digite o nome do cliente">
        </div>
        <div>
            <label for="filterCode">Código:</label>
            <input class="filters" type="text" id="filterCode" placeholder="Digite o código">
        </div>
        <button id="applyFilters">Aplicar Filtros</button>
        <button id="resetFilters">Resetar Filtros</button>
    </div>
    </div>
    <?php
    $sql = "";
    $stmt = sqlsrv_query($conn, $sql);
    ?>

    <table id="dataTable" class="table-container">
        <thead>
            <tr>
                <th data-type="numeric">COTAÇÃO</th>
                <th data-type="date">DATA</th>
                <th data-type="text">CLIENTE</th>
                <th data-type="numeric">QUANTIDADE</th>
                <th data-type="numeric">VALOR TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tabela = "";

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $tabela .= "<tr>";
                $tabela .= "<td>" . $row['OS'] . "</td>";
                $tabela .= "<td>" . $row['Status'] . "</td>";
                $tabela .= "</tr>";
            }
            $tabela .= "</table>";

            print ($tabela);
            ?>

            </div>


        </tbody>
    </table>
    <script src="../JS/listar.js" charset="utf-8"></script>
</body>

</html>