<?php

try {
    require "../../database/conexao.php";
} catch (\Throwable $e) {
    error_log($e->getMessage());
    http_response_code(403);
    die("Não foi possivel realizar a conexão com o banco de dados.");
}


$idAgendamento = mysqli_escape_string($conn, $_POST["idAgendamento"]);
$sqlApagarLinhaAgendamentos = "DELETE FROM `agendamento` WHERE `idAgendamento` = '$idAgendamento'";
$sqlConsultaNomesArquivosReferentes = "SELECT `nomeAnexo` FROM `anexosagendamento` WHERE `idAgendamento` = '$idAgendamento'";
$consultaNomesArquivosReferentes = mysqli_query($conn, $sqlConsultaNomesArquivosReferentes);

if ($consultaNomesArquivosReferentes and $consultaNomesArquivosReferentes -> num_rows > 0) {
    print_r(mysqli_query($conn, $sqlConsultaNomesArquivosReferentes));
    $sqlApagarLinhasAnexos = "";
    $resultados = mysqli_query($conn, $sqlConsultaNomesArquivosReferentes);
    while ($nomeAnexoInstancia = mysqli_fetch_assoc($resultados)) {
            $nomeArquivo = $nomeAnexoInstancia["nomeAnexo"];
            if (file_exists("./db/arquivosAnexos/" . $nomeArquivo)) {
                unlink("./db/arquivosAnexos/$nomeArquivo");
                $sqlApagarLinhasAnexos = "DELETE FROM `anexosagendamento` WHERE `nomeAnexo` = '$nomeArquivo'";
            } else {
                $sqlApagarLinhasAnexos = "DELETE FROM `anexosagendamento` WHERE `idAgendamento` = '$idAgendamento'"; 
            }
    }
    if (mysqli_query($conn, $sqlApagarLinhasAnexos)) {
        if (mysqli_query($conn, $sqlApagarLinhaAgendamentos)) {
            echo json_encode(["sucesso" => true, "mensagem" => "Agendamento excluido com sucesso"]);
        } else {
            print_r($sqlApagarLinhasAnexos);
            echo json_encode(["sucesso" => false, "mensagem" => "Falha ao excluir agendamento sem registro na tebela anexos"]);
            http_response_code(403);
            die();
        }
    }
} else {
    if (mysqli_query($conn, $sqlApagarLinhaAgendamentos)) {
        echo json_encode(["sucesso" => true, "mensagem" => "Agendamento excluido com sucesso"]);
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Falha ao excluir agendamento sem registro na tebela anexos"]);
        http_response_code(403);
        die();
    }
}