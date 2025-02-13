<?php 
const SERVIDOR = "localhost";
const USUARIO = "root";
const SENHA = "";
const DBNOME = "dtiagendaestoque";

// Criar conexão com o banco de dados
try {
    $conn = mysqli_connect(SERVIDOR, USUARIO, SENHA, DBNOME);
    mysqli_set_charset($conn, "utf8");
} catch (mysqli_sql_exception $e) {
    http_response_code(400);
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}