<?php 
require '../../database/conexao.php';

$conteudoFiltro = mysqli_real_escape_string($conn, $_POST["conteudoFiltro"]);
$tipoFiltro = mysqli_real_escape_string($conn, $_POST["tipoFiltro"]);
$statusFiltro = mysqli_real_escape_string($conn, $_POST["statusFiltro"]);
$dataFiltro = mysqli_real_escape_string($conn, $_POST["dataFiltro"]);
$dataAteFiltro = mysqli_real_escape_string($conn, $_POST["dataAteFiltro"]);

$sql = 
"SELECT 
`idAgendamento`, 
DATE_FORMAT(`dataAgendamento`, '%d/%m/%Y') AS 'dataAgendamento', 
`tipoAgendamento`, 
`conteudoAgendamento`, 
`envolvidosAgendamento`, 
`statusAgendamento`
FROM `agendamento`
WHERE 1"; // WHERE 1 é um truque para facilitar a adição de condições

// Filtrando por `conteudoFiltro` (incluindo `idAgendamento` também para a filtragem)
if (!empty($conteudoFiltro)) {
    $sql .= " AND (`conteudoAgendamento` LIKE '%" . $conteudoFiltro . "%' 
              OR `idAgendamento` = " . intval($conteudoFiltro) . ")";
}

// Filtrando pelo tipo de agendamento fornecido
if (!empty($tipoFiltro)) {
    $sql .= " AND `tipoAgendamento` = '" . $tipoFiltro . "'";
}

// Adicionando filtro para `dataFiltro` e `dataAteFiltro`
if ((!empty($dataFiltro)) and (empty($dataAteFiltro))) {
    // Caso o filtro seja só por data
    $sql .= " AND DATE(`dataAgendamento`) = '" . $dataFiltro . "'";
} else if ((!empty($dataFiltro)) and (!empty($dataAteFiltro))) {
    // Caso o filtro seja por intervalo de datas
    $sql.= " AND DATE(`dataAgendamento`) BETWEEN '" . $dataFiltro. "' AND '" . $dataAteFiltro. "'";
}

// Filtrando pelo status fornecido
if (!empty($statusFiltro)) {
    $sql .= " AND `statusAgendamento` = '" . $statusFiltro . "'";
}

// Ordernar por data decrescente
$sql.= " ORDER BY `dataAgendamento` DESC";

$resultadoConsulta = mysqli_query($conn, $sql) or die("Erro ao executar a consulta!" . mysqli_error($conn));

$arrayRetornaLinhas = [];
while($linha = mysqli_fetch_assoc($resultadoConsulta)) {
    $arrayRetornaLinhas[] = $linha;
}

echo json_encode($arrayRetornaLinhas);