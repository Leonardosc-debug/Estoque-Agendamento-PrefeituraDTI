<?php 
require "../../database/conexao.php";

$dadosJson = array();

function obterDadosFormData(mysqli $conn) 
{
    $camposTabelaAgendamento = [
        "dataAgendamento", "tipoAgendamento", 
        "conteudoAgendamento", "envolvidosAgendamento", 
        "statusAgendamento"
    ];
    $camposTabelaAnexo = [
        "textosAnexosAlterados", "idsTextosAlterados",
        "idsAnexosAlterados"
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

    executarSqlDosRetornos($conn, $dadosObtidos, $camposTabelaAgendamento, $modificacaoAgendamento, $modificacaoTextosAnexos, $idAgendamento);
}

function executarSqlDosRetornos(
    mysqli $conn,
    array $dadosObtidos, array $camposTabelaAgendamento, 
    bool $modificacaoAgendamento, bool $modificacaoTextosAnexos, 
    int $idAgendamento) 
{
    // Se possuir modificação no agendamento executar a SQL de Agendamento
    if ($modificacaoAgendamento) {
        $retornoAgendamento = construirSqlAgendamento($dadosObtidos, $camposTabelaAgendamento, $idAgendamento);
        $stmt = $conn->prepare($retornoAgendamento["consulta"]);
        $stmt->bind_param($retornoAgendamento["tipos"], ...$retornoAgendamento["parametros"]);
        if ($stmt->execute()) {
            global $jsonDados;
            $jsonDados[] = ["tipo" => "agendamento", "sucesso" => true, "mensagem" => "Os dados do agendamento foram atualizados com sucesso"];
        } else {
            global $jsonDados;
            $jsonDados[] = ["tipo" => "agendamento", "sucesso" => false, "mensagem" => "Erro na atualização dos dados do agendamento"];
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
            global $jsonDados;
            $jsonDados[] = ["tipo" => "textosAnexos", "sucesso" => true, "mensagem" => "Os dados dos textos dos anexos do agendamento foram atualizados com sucesso"];
        } else {
            global $jsonDados;
            $jsonDados[] = ["tipo" => "textosAnexos", "sucesso" => false, "mensagem" => "Erro na atualização dos dados dos textos dos anexos do agendamento"];
            error_log($stmt->error);
        }
        $stmt->close();
    }

    if (isset($_FILES["anexoArquivos"])) {
        $retornoAlteracaoArquivo = alterarArquivo($conn, $idAgendamento, $dadosObtidos["idsAnexosAlterados"]);
        if ($retornoAlteracaoArquivo) {
            $stmt = $conn->prepare($retornoAlteracaoArquivo["consulta"]);
            $stmt->bind_param($retornoAlteracaoArquivo["tipos"], ...$retornoAlteracaoArquivo["parametros"], ...$retornoAlteracaoArquivo["idsDosAlterados"]);
            if ($stmt->execute()) {
                global $jsonDados;
                $jsonDados[] = ["tipo" => "arquivos", "sucesso" => true, "mensagem" => "Os anexos do agendamento foram atualizados com sucesso"];
            } else {
                global $jsonDados;
                $jsonDados[] = ["tipo" => "arquivos", "sucesso" => false, "mensagem" => "Erro na atualização do arquivo(s) do agendamento"];
                error_log($stmt->error);
            }
            $stmt->close();
        }
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

function alterarArquivo(mysqli $conn, int $idAgendamento, array $idsAnexosAlterados)
{
    $contadorArquivosEditadosComSucesso = 0;
    //Mapeamento para tipos de extenções de arquivos
    $mapaMimeExtensao = [
        'image/jpeg' => '.jpg',
        'image/jpg' => '.jpg',
        'image/png' => '.png',
        // É possível adicionar mais no futuro
    ];
    $querryAlteraReferenciaArquivo = "UPDATE anexosAgendamento SET nomeAnexo = CASE ";
    $parametros = [];
    $idsDosAlterados = [];
    $tipos = "";
    $anexosEditadosImportados = $_FILES["anexoArquivos"];
    
    for ($contador = 0; $contador < count($anexosEditadosImportados["name"]); $contador++) {
        $tipoArquivoInstancia = $anexosEditadosImportados["type"][$contador];    
        
        if (!array_key_exists($tipoArquivoInstancia, $mapaMimeExtensao)) {
            echo json_encode(["sucesso" => false, "mensagem" => 'Falha em mover o arquivo ' . $anexosEditadosImportados["name"][$contador] . ' para o servidor', "extensao" => "invalida"]);
            unset($anexosEditadosImportados[$contador]);
            unset($idsAnexosAlterados[$contador]);
        } else {
            try {
                $stmt = $conn->prepare("SELECT nomeAnexo FROM anexosagendamento WHERE idAnexo = ?");
                $stmt->bind_param("i", $idsAnexosAlterados[$contador]);
                $stmt->execute();
                $stmt->bind_result($pegarNomeASerSubstituido);
                $stmt->fetch();
                $stmt->close();
            } catch(mysqli_sql_exception $e) {
                global $jsonDados;
                $jsonDados[] = ["tipo" => "arquivos", "sucesso" => false, "mensagem" => "Erro ao tentar buscar o nome do arquivo instanciado"];
                error_log($e->getMessage());
                continue;
            };

            $extensaoArquivoInstancia = $mapaMimeExtensao[$anexosEditadosImportados["type"][$contador]];
            $novoNomeDoNovoArquivoInstancia = "anexoImagemAgendamentoId" . $idAgendamento . "_" . $idsAnexosAlterados[$contador] . $extensaoArquivoInstancia;
            $caminhoDestino = "../../database/storage/arquivosAnexos/";
            $destinoArquivoComNovoNome = $caminhoDestino . $novoNomeDoNovoArquivoInstancia;
            
            // Se existem arquivos com o mesmo nome, ele os tenta excluir
            try {
                if (file_exists($caminhoDestino . $pegarNomeASerSubstituido)) {
                    if (!unlink($caminhoDestino . $pegarNomeASerSubstituido)) {
                        throw new Exception("Não foi possível excluir o arquivo antigo.");
                    }
                }
                if (rename($anexosEditadosImportados["tmp_name"][$contador], $destinoArquivoComNovoNome)) {
                    $querryAlteraReferenciaArquivo .= "WHEN idAnexo = ? THEN ? ";
                    $parametros[] = $idsAnexosAlterados[$contador];
                    $parametros[] = $novoNomeDoNovoArquivoInstancia;
                    $idsDosAlterados[] = $idsAnexosAlterados[$contador];
                    $tipos.= "is"; // "s" para string, "i" para inteiro
                    $contadorArquivosEditadosComSucesso++;
                } else {
                    throw new Exception("Não foi possível alterar o arquivo pelo o novo.");
                }
            } catch (Exception $e) {
                global $jsonDados;
                $jsonDados[] = ["tipo" => "arquivos", "sucesso" => false, "mensagem" => "Erro ao tentar mover o arquivo para o novo local"];
                error_log($e->getMessage());
                continue;
            }
        }
    }
    
    $querryAlteraReferenciaArquivo .= "END WHERE idAnexo IN (" . implode(",", array_fill(0, $contadorArquivosEditadosComSucesso, "?")) . ")";
    $tipos .= str_repeat("i", $contadorArquivosEditadosComSucesso); // "i" para inteiro

    if (!empty($parametros)) {
        return [
            "consulta" => $querryAlteraReferenciaArquivo,
            "parametros" => $parametros,
            "tipos" => $tipos,
            "idsDosAlterados" => $idsDosAlterados
        ];
    }

    return null;
}

// Execução de funções
obterDadosFormData($conn);
echo json_encode($jsonDados);
$conn->close(); // Fechar a conexão ao banco de dados