<?php 
include '../../database/conexao.php';

function obterDadosFormDataPassados(mysqli $conn) 
{
    $camposTabelaAgendamento = [
        "idAgendamento", "dataAgendamento", 
        "tipoAgendamento", "conteudoAgendamento", 
        "conteudoAgendamento", "envolvidosAgendamento", 
        "statusAgendamento"
    ];
    $camposTabelaAnexo = [
        "textosAnexos", "idsTextosAlterados",
        "nomesImagensAlterados"
    ];

    $dadosObtidos = [];
    foreach ($camposTabelaAgendamento as $campo) {
        if (!isset($_POST[$campo])) continue;
        $dadosObtidos[$campo] = mysqli_real_escape_string($conn, $_POST[$campo]);
    }
    foreach ($camposTabelaAnexo as $campo) {
        if (!isset($_POST[$campo])) continue;
        $dadosObtidos[$campo] = array_map(function($texto) use ($conn) {
                return mysqli_real_escape_string($conn, $texto);
            }, $_POST["$campo"]);
    }
    
    salvarEdicaoBancoDados($conn, $dadosObtidos, $camposTabelaAgendamento, $camposTabelaAnexo);
}

obterDadosFormDataPassados($conn);

function salvarEdicaoBancoDados(mysqli $conn, array $dadosObtidos, array $camposTabelaAgendamento, array $camposTabelaAnexo) 
{
    $arrayAdicoesSqlAgendamento = [];
    foreach ($dadosObtidos as $dado => $valor) {
        if (in_array($dado, $camposTabelaAgendamento)) {
            $arrayAdicoesSql[] = "`$dado` = '" . $valor . "'";
        }
    }
    $sqlAnexos = "UPDATE anexosagendamento SET textoAnexo = CASE ";
    $parametrosSubstituir = [];
    foreach ($dadosObtidos["textosAnexos"] as $indexTexto => $texto) {
        foreach ($dadosObtidos["idsTextosAlterados"] as $indexId => $id) {
            $sqlAnexos .= "WHEN idAnexo = $id THEN '$texto' ";
        }
    }

    $sqlAgendamento = "";
    if (!empty($arrayAdicoesSqlAgendamento)) {
        $sqlAgendamento = 
        "UPDATE `agendamento` SET "
        . implode(",", $arrayAdicoesSql)
        . " WHERE `idAgendamento` = {$dadosObtidos["idAgendamento"]};"; ;
    }
}

$edicaoAgendamento = false;
$arrayAdicoesSql = [];
if (!empty($dataAgendamento)) {
    $arrayAdicoesSql[] = "`dataAgendamento` = '" . $dataAgendamento . "'";
    $edicaoAgendamento = true;
} 
if (!empty($tipoAgendamento)) {
    $arrayAdicoesSql[] = "`tipoAgendamento` = '" . $tipoAgendamento . "'";
    $edicaoAgendamento = true;
} 
if (!empty($conteudoAgendamento)) {
    $arrayAdicoesSql[] = "`conteudoAgendamento` = '" . $conteudoAgendamento . "'";
    $edicaoAgendamento = true;
} 
if (!empty($envolvidosAgendamento)) {
    $arrayAdicoesSql[] = "`envolvidosAgendamento` = '" . $envolvidosAgendamento . "'";
    $edicaoAgendamento = true;
} 
if (!empty($statusAgendamento)) {
    $arrayAdicoesSql[] = "`statusAgendamento` = '" . $statusAgendamento . "'";
    $edicaoAgendamento = true;
}

if ($edicaoAgendamento) {
    $sqlAgendamento = "UPDATE `agendamento` SET ";
    $sqlAgendamento .= implode(",", $arrayAdicoesSql);
    $sqlAgendamento .= " WHERE `idAgendamento` = {$idAgendamento};";
    echo $sqlAgendamento;
    if (mysqli_query($conn, $sqlAgendamento)) {
        echo json_encode(["sucesso" => true, "mensagem" => "A parte do Agendamento foi editado com sucesso"]);
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Falha ao editar o Agendamento"]);
        print_r($sqlAgendamento);
        http_response_code(400);
        die("Falha ao editar o Agendamento");
    }
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

function alterarDescricaoAnexo(mysqli $conn, array $textosAnexosTratados, array $idsTextosAlterados) 
{
    for($i = 0; $i < count($textosAnexosTratados); $i++) {
        $textoInstancia = $textosAnexosTratados[$i];
        $idInstancia = $idsTextosAlterados[$i];

        $sql = 
        "UPDATE `anexosagendamento` 
        SET `textoAnexo` = '$textoInstancia' 
        WHERE `idAnexo` = '$idInstancia'";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["sucesso" => true, "mensagem" => "Textos dos anexos atualizados com sucesso"]);
        } else {
            http_response_code(400);
            echo json_encode(["sucesso" => false, "mensagem" => "Falha ao atualizar o texto dos anexos"]);
            die("Erro ao executar a consulta!" . mysqli_error($conn));
        }
    }    
}

if ((isset($_FILES["anexoArquivos"])) and (!empty($nomesImagensTratadosAlterados))) {
    alterarArquivo($conn, $nomesImagensTratadosAlterados);
}

// Seção do salvamento dos textos dos anexos, não será executado se faltar algum campo necessário
if ((!empty($textosAnexosTratados)) and (!empty($idsTextosAlterados))) {
    foreach ($idsTextosAlterados as $id) {
        if (!is_numeric($id)) {
            http_response_code(400);
            die(json_encode(["sucesso" => false, "mensagem" => "Os ids recebidos são inválidos"]));
        }
    }
    alterarDescricaoAnexo($conn, $textosAnexosTratados, $idsTextosAlterados);
}