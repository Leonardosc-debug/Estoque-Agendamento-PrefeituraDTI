<?php 
require "../../database/conexao.php";

obterDadosFormData($conn);

function obterDadosFormData(mysqli $conn) 
{
    $camposTabelaAgendamento = [
        "dataAgendamento", "tipoAgendamento", 
        "conteudoAgendamento", "conteudoAgendamento", 
        "envolvidosAgendamento", "statusAgendamento"
    ];
    $camposTabelaAnexo = [
        "textosAnexosAlterados", "idsTextosAlterados",
        "nomesImagensAlterados"
    ];
    $modificacaoAgendamento = false;
    $modificacaoTextosAnexos = false;

    $idAgendamento = null;
    if (isset($_POST["idAgendamento"]) && is_numeric($_POST["idAgendamento"])) {
        $idAgendamento = (int) $_POST["idAgendamento"];  // Converte diretamente para inteiro após validação
    } else {
        die("As operações não podem continuar sem um id de agendamento válido");
    }

    $dadosObtidos = [];
    foreach ($camposTabelaAgendamento as $campo) {
        if (!isset($_POST[$campo])) continue;
        $dadosObtidos[$campo] = mysqli_real_escape_string($conn, $_POST[$campo]);
        $modificacaoAgendamento = true;
    }
    foreach ($camposTabelaAnexo as $campo) {
        if (!isset($_POST[$campo])) continue;
        $dadosObtidos[$campo] = array_map(function($texto) use ($conn) {
                return mysqli_real_escape_string($conn, $texto);
            }, $_POST["$campo"]);
        if ($campo == "textosAnexosAlterados") {
            $modificacaoTextosAnexos = true;
        }
    }

    converterDadosParaConsultaSql($conn, $dadosObtidos, $camposTabelaAgendamento, $modificacaoAgendamento, $modificacaoTextosAnexos, $idAgendamento);
}

function converterDadosParaConsultaSql(
    mysqli $conn,
    array $dadosObtidos, array $camposTabelaAgendamento, 
    bool $modificacaoAgendamento, bool $modificacaoTextosAnexos, 
    int $idAgendamento) 
{
    // Se possuir modificação no agendamento executar a SQL de Agendamento
    if ($modificacaoAgendamento) {
        $retornoAgendamento = construirSqlAgendamento($dadosObtidos, $camposTabelaAgendamento, $idAgendamento);
        print_r($retornoAgendamento["parametros"]);
        $stmt = $conn->prepare($retornoAgendamento["consulta"]);
        $stmt->bind_param($retornoAgendamento["tipos"], ...$retornoAgendamento["parametros"]);
        if ($stmt->execute()) {
            echo "Agendamento atualizado com sucesso!<br>";
        } else {
            echo "Erro na atualização do agendamento<br>";
            error_log($stmt->error);
        }
        $stmt->close();
    }

    // Se possuir modificação nos textos dos anexos executar a SQL dos Textos dos anexos
    if ($modificacaoTextosAnexos) {
        $retornoTextosAnexos = construirSqlTextosAnexos($dadosObtidos);
        $stmt = $conn->prepare($retornoTextosAnexos["consulta"]);
        $stmt->bind_param($retornoTextosAnexos["tipos"], ...$retornoTextosAnexos["parametros"]);
        if ($stmt->execute()) {
            echo "Agendamento atualizado com sucesso!<br>";
        } else {
            echo "Erro na atualização do agendamento<br>";
            error_log($stmt->error);
        }
        $stmt->close();
    }
}

function construirSqlAgendamento(array $dadosObtidos, array $camposTabelaAgendamento, int $idAgendamento) 
{
    $QRAgendamento = "UPDATE agendamento SET ";
    $tipos = "";
    $parametros = [];
    foreach ($dadosObtidos as $campo => $valor) {
        if (!in_array($campo, $camposTabelaAgendamento)) continue;
        $QRAgendamento .= "$campo = ?, ";
        $parametros[] = $valor;
        $tipos .= "s"; // "s" para cada string do $campo
    }

    // Remove a virgula e o espaçamento para inserir o final da consulta
    $QRAgendamento = rtrim($QRAgendamento, ", ");
    $QRAgendamento.= " WHERE idAgendamento = ?;";
    $parametros[] = $idAgendamento;
    $tipos .= "i"; // "i" para inteiro id adicionado no final


    if (isset($parametros)) {
        return [
            "consulta" => $QRAgendamento,
            "parametros" => $parametros,
            "tipos" => $tipos
        ];
    }

    return null;
}

function construirSqlTextosAnexos(array $dadosObtidos) 
{
    $arrayAdicoesSqlAnexos = [];
    foreach ($dadosObtidos["idsTextosAlterados"] as $index => $id) {
        if (isset($dadosObtidos["textosAnexosAlterados"][$index])) {
            $arrayAdicoesSqlAnexos[$id] = $dadosObtidos["textosAnexosAlterados"][$index];
        }
    }

    if (!empty($arrayAdicoesSqlAnexos)) {
        $QRAnexos = "UPDATE anexosagendamento SET textoAnexo = CASE ";
        $parametros = [];
        $tipos = "";

        foreach ($arrayAdicoesSqlAnexos as $id => $textoAnexo) {
            $QRAnexos .= "WHEN idAnexo = ? THEN ? ";
            $parametros[] = $id;
            $parametros[] = $textoAnexo;
            $tipos .= "is"; // "i" para inteiro e "s" para string
        }

        $QRAnexos .= "END WHERE idAnexo IN (" . implode(",", array_keys($arrayAdicoesSqlAnexos)) . ");";

        return [
            "consulta" => $QRAnexos,
            "parametros" => $parametros,
            "tipos" => $tipos
        ];
    }

    return null;
}


function alterarArquivo(mysqli $conn , array $nomesImagensTratadosAlterados)
{
    //Mapeamento para tipos de extenções de arquivos
    $mapaMimeExtensao = [
        'image/jpeg' => '.jpg',
        'image/jpg' => '.jpg',
        'image/png' => '.png',
        // É possível adicionar mais no futuro
    ];
    $anexosEditadosImportados = $_FILES["anexoArquivos"];
    
    for ($contador = 0; $contador < count($anexosEditadosImportados["name"]); $contador++) {
        $extensaoArquivoInstancia = $mapaMimeExtensao[$anexosEditadosImportados["type"][$contador]];
        
        if (($extensaoArquivoInstancia !== ".jpg") and ($extensaoArquivoInstancia !== ".png")) {
            echo json_encode(["sucesso" => false, "mensagem" => "Falha em mover o arquivo para o servidor", "extensao" => "invalida"]);
            unset($anexosEditadosImportados[$contador]);
            http_response_code(400);
        } else {
            $pegarNomeArquivo = $nomesImagensTratadosAlterados[$contador];
            $tratandoNomeArquivo = pathinfo($pegarNomeArquivo);
            $nomeArquivoComExtensao = $tratandoNomeArquivo["filename"] . $extensaoArquivoInstancia;
            $caminhoDestino = "../../database/storage/arquivosAnexos/";
            $destinoArquivoComNovoNome = $caminhoDestino . $nomeArquivoComExtensao;
            
            // Se existem arquivos com o mesmo nome, os exclui
            if (file_exists($caminhoDestino . $pegarNomeArquivo)) {
                echo json_encode(["sucesso" => true, "mensagem" => "Havia um arquivo neste index, porem ele foi removido", "extensao" => "valido"]);
                unlink($caminhoDestino . $pegarNomeArquivo);
            }

            if (rename($anexosEditadosImportados["tmp_name"][$contador], $destinoArquivoComNovoNome)) {
                $sqlAnexoInstancia = "UPDATE `anexosagendamento` SET `nomeAnexo` = '$nomeArquivoComExtensao' WHERE `nomeAnexo` = '$pegarNomeArquivo'";
                if (mysqli_query($conn, $sqlAnexoInstancia)) {
                    echo json_encode(["sucesso" => true, "mensagem" => "Sucesso em mover o arquivo para o servidor", "extensao" => "valido"]);       
                } else {
                    echo json_encode(["sucesso" => false, "mensagem" => "Erro na movimentação do arquivo enviado para o servidor", "extensao" => "valido"]);
                    http_response_code(400);
                    die("Erro na movimentação do arquivo enviado" . mysqli_error($conn));
                }
            }
        }
    }
}

// Fechar a conexão ao banco de dados
$conn->close();