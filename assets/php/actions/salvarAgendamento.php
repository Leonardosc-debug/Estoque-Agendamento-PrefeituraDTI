<?php
require "../../database/conexao.php";

// Variaveis Globais
$dadosRecebidosTratadosAgendamento = tratarDadosRecebidosAgendamento($conn);
$textosAnexosTratados = tratarTextosAnexos($conn);
$consultaDadosAgendamento = prepararConsultaDeCriacaoAgendamento($dadosRecebidosTratadosAgendamento);
$idAgendamento = executarConsultaAgendamento($conn, $consultaDadosAgendamento);
$arquivosRecebidos = $_FILES["anexoArquivos"] ?? null;

function tratarDadosRecebidosAgendamento(mysqli $conn) 
{
    $camposTabelaAgendamento = [
        "dataAgendamento", "tipoAgendamento", 
        "conteudoAgendamento", "envolvidosAgendamento", 
        "statusAgendamento"
    ];

    $dadosRecebidos = [];
    foreach ($camposTabelaAgendamento as $campo) {
        $dadosRecebidos[$campo] = isset($_POST[$campo]) 
            ? mysqli_real_escape_string($conn, $_POST[$campo]) 
            : null;
    }

    if ($dadosRecebidos["envolvidosAgendamento"] == null or $dadosRecebidos["envolvidosAgendamento"] == "") {
        $dadosRecebidos["envolvidosAgendamento"] = "Nenhum citado";
    }

    return $dadosRecebidos;
}

function tratarTextosAnexos(mysqli $conn) 
{
    $textosAnexosTratados = [];

    if (!empty($_POST["textosAnexos"]) && is_array($_POST["textosAnexos"])) {
        foreach ($_POST["textosAnexos"] as $texto) {
            $textosAnexosTratados[] = mysqli_real_escape_string($conn, $texto);
        }
    } else {
        return false;
    }

    return $textosAnexosTratados;
}

function prepararConsultaDeCriacaoAgendamento(array $dadosRecebidos)
{
    if (empty($dadosRecebidos)) {
        return false;
    }
    $consultaSql = "INSERT INTO agendamento (" . 
    implode(", ", array_keys($dadosRecebidos)) . 
    ") VALUES (" . 
    implode(", ", array_fill(0, count($dadosRecebidos), "?")) . 
    ")";
    $tipos = implode("", array_fill(0, count($dadosRecebidos), "s"));


    return [
        "consulta" => $consultaSql,
        "dados" => $dadosRecebidos,
        "tipos" => $tipos
    ];
}

function executarConsultaAgendamento(mysqli $conn, array $dadosConsulta) 
{
    print_r($dadosConsulta);
    $stmt = $conn->prepare($dadosConsulta["consulta"]);
    $stmt->bind_param($dadosConsulta["tipos"], ...array_values($dadosConsulta["dados"]));
    if ($stmt->execute()) {
        $idAgendamento = $stmt->insert_id;
        $stmt->close();
        return $idAgendamento;
    } else {
        error_log($stmt->error);
        $stmt->close();
        return false;
    }
}

function executarConsultaAnexos(
    mysqli $conn, string $extensaoArquivoInstancia, 
    array $textosAnexos, int $instancia, 
    int $idAgendamento
    ) 
{
    $textoDoAnexo = $textosAnexos[$instancia] ?? "";

    // Inserir um registro temporário
    $conn->query("INSERT INTO anexosagendamento (idAgendamento, nomeAnexo, textoAnexo) VALUES ($idAgendamento, '', '')");

    // Pegar o ID gerado
    $idAnexo = $conn->insert_id;

    // Gerar o nome do arquivo
    $nomeDoArquivo = "anexoImagemAgendamentoId" . $idAgendamento . "_" . $idAnexo . $extensaoArquivoInstancia;

    // Atualizar com os dados reais
    $stmt = $conn->prepare("UPDATE anexosagendamento SET idAgendamento = ?, nomeAnexo = ?, textoAnexo = ? WHERE idAnexo = ?");
    $stmt->bind_param("issi", $idAgendamento, $nomeDoArquivo, $textoDoAnexo, $idAnexo);
    if ($stmt->execute()) {
        $stmt->close();
        return $nomeDoArquivo;
    } else {
        error_log($stmt->error);
        $stmt->close();
        return false;
    }
}


function salvarArquivos(mysqli $conn, int $idAgendamento, array $textosAnexos, $arquivos) 
{
    //Mapeamento para tipos de extenções de arquivos
    $mapaMimeExtensao = [
        'image/jpeg' => '.jpg',
        'image/jpg' => '.jpg',
        'image/png' => '.png',
    ];
    $caminhoDestino = "../../database/storage/arquivosAnexos/";

    if (!is_dir($caminhoDestino)) {
        error_log("O sistema não consigou encontrar o caminho de destino:" . $caminhoDestino);
        return false;
    }
    
    for ($contador = 0; $contador < count($arquivos["name"]); $contador++) {
        $nomeArquivoEmInstancia = $arquivos["name"][$contador];
        $extensaoArquivoInstancia = $mapaMimeExtensao[$arquivos["type"][$contador]] ?? null;

        if (!$extensaoArquivoInstancia) {
            error_log("O arquivo " . $nomeArquivoEmInstancia . " possui uma extensão inválida e foi ignorado do array.");
            continue;
        }

        $novoNomeDoArquivo = executarConsultaAnexos($conn, $extensaoArquivoInstancia, $textosAnexos, $contador, $idAgendamento);

        if ($novoNomeDoArquivo) {
            if (move_uploaded_file($arquivos["tmp_name"][$contador], $caminhoDestino . $novoNomeDoArquivo)) {
                echo "O arquivo " . $nomeArquivoEmInstancia . " foi movido com sucesso para o servidor";
            } else {
                echo "O arquivo " . $nomeArquivoEmInstancia . " não foi movido com sucesso para o servidor";
            }
        }
    }
}

if ($arquivosRecebidos) {
    salvarArquivos($conn, $idAgendamento, $textosAnexosTratados, $arquivosRecebidos);
}