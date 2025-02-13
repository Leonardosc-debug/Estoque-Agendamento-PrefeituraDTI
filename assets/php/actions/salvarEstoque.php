<?php
include("db\conexao.php");

$tipoEquipamento = $_POST["tipoEquipamento"];
$numeroPatrimonio = $_POST["numeroPatrimonio"];
$numeroSerie = $_POST["numeroSerie"];
$quantidade = $_POST["quantidade"];

$sql = "INSERT INTO dbestoque (tipoEquipamento,numeroPatrimonio, numeroSerie,quantidade) VALUES('$tipoEquipamento', '$numeroPatrimonio', '$numeroSerie', '$quantidade')";

$innerJoin = "SELECT o.nomeOpcoes 
        FROM opcoes o
        JOIN dbestoque d ON o.nomeOpcoes = d.tipoEquipamento 
       WHERE d.tipoEquipamento = $tipoEquipamento";
$result = $conn->query($innerJoin);

if ($conn->query($sql) === TRUE) {
   echo "Novo registro criado com sucesso";
} else {
   echo "Erro ao criar registro";
}
;




//echo "<pre>";

//print_r($_POST);

// get data


// insert data on database;

// return resulset;


