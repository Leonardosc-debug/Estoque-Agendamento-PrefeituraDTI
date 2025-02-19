<?php
// Declaração das variaveís que armazenam a conexão
const SERVIDOR = "localhost";
const USUARIO = "root";
const SENHA = "";
const DBNOME = "dtiagendaestoque";

// Criar conexão com MySQLi
try {
    $conn = new mysqli(SERVIDOR, USUARIO, SENHA, DBNOME);
    $conn->set_charset("utf8");
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    error_log($e->getMessage());
    die("Erro ao tentar se conectar com o banco de dados.");
}