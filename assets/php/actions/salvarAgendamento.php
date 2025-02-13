<?php
include "./db/conexao.php";

//Mapeamento para tipos de extenções de arquivos
$mapaMimeExtensao = [
    'image/jpeg' => '.jpg',
    'image/jpg' => '.jpg',
    'image/png' => '.png',
    // É possível adicionar mais no futuro
];

//Variaveis globais de validação génericos que são alterados dentro da validação
$validoCampos = false;

//Atribuindo os valores recebidos do POST para variaveis
$dataAgendamento = mysqli_real_escape_string($conn, $_POST["dataAgendamento"]);
$tipoAgendamento = mysqli_real_escape_string($conn, $_POST["tipoAgendamento"]);
$conteudoAgendamento = mysqli_real_escape_string($conn, $_POST["conteudoAgendamento"]);
$envolvidosAgendamento = mysqli_real_escape_string($conn, $_POST["envolvidosAgendamento"]);
$statusAgendamento = mysqli_real_escape_string($conn, $_POST["statusAgendamento"]);


//Variaveis que interagem com o banco de dados
$proximoId = $conn -> query("SHOW TABLE STATUS LIKE 'agendamento'") -> fetch_assoc()['Auto_increment']; // Pega o próximo ID para relacionar com a chave estrangeira dos anexos
$sqlDeInsercaoAgendamento = "INSERT INTO `agendamento`(`dataAgendamento`, `tipoAgendamento`, `conteudoAgendamento`, `envolvidosAgendamento`, `statusAgendamento`)
VALUES ('$dataAgendamento', '$tipoAgendamento', '$conteudoAgendamento', '$envolvidosAgendamento', '$statusAgendamento')";
$arraySqlsInsercaoAnexosAgendamento = []; // Declaração array vazia para colocar na query fora do if

//Verificando se há arquivos, converte o tipo para .formatodoarquivo, validar o tipo de arquivo e depois insere na tabela de arquivos "anexosagendamento" e na pasta no servidor
if (isset($_FILES["anexoArquivos"])) {
    $anexosImportados = $_FILES["anexoArquivos"];
    $quantidadeArquivos = count($anexosImportados["name"]);
    $caminhoDestino = "./db/arquivosAnexos/";

    if (!is_dir($caminhoDestino)) {
        try {
            mkdir($caminhoDestino, 0755, true);
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar criar a pasta: ". $caminhoDestino);
        }
    }

    for ($contador = 0; $contador < $quantidadeArquivos; $contador++) {
        $extensaoArquivoInstancia = $mapaMimeExtensao[$anexosImportados["type"][$contador]]; // Conversão para .formatodoarquivo

        if (($extensaoArquivoInstancia != ".jpg") && ($extensaoArquivoInstancia != ".png")) {
            unset($anexosImportados[$contador]);
            echo json_encode(["sucesso" => false, "mensagem" => "A extensao " . $extensaoArquivoInstancia . " nao foi aceito como formato valido pelo servidor", "extensao" => "invalido"]);
        } else {
            // Seção do manejamento de textos dos anexos
            $textoAnexoInstancia = mysqli_real_escape_string($conn, $_POST["textosAnexos"][$contador]);

            // Seção do manejamento de arquivos
            $pegarNomeArquivo = basename($anexosImportados["name"][$contador]);
            $novoNomeArquivo = "anexoImagemAgendamentoId$proximoId" . "_$contador" . $extensaoArquivoInstancia;
            $caminhoDestinoComNovoNome = "./db/arquivosAnexos/$novoNomeArquivo";

            if (rename($anexosImportados["tmp_name"][$contador], $caminhoDestinoComNovoNome)) {
                echo json_encode(["sucesso" => true, "mensagem" => "Sucesso em mover o arquivo para o servidor", "extensao" => "valido"]);
                $sqlAnexoInstancia = "INSERT INTO `anexosagendamento`(`idAgendamento`, `nomeAnexo`, `textoAnexo`) 
                VALUES ('$proximoId','$novoNomeArquivo', '$textoAnexoInstancia')";
                array_push($arraySqlsInsercaoAnexosAgendamento, $sqlAnexoInstancia);
            } else {
                echo json_encode(["sucesso" => false, "mensagem" => "Falha em tentar mover o arquivo para o servidor", "extensao" => "valido"]);
                http_response_code(403);
            };
        };
    };
};

if (mysqli_query($conn, $sqlDeInsercaoAgendamento)) {
    //For que será ativo se possuir sql's de arquivos nele
    for ($contador = 0; $contador < count($arraySqlsInsercaoAnexosAgendamento); $contador++) {
        $resultadoConsultaAnexos = mysqli_query($conn, $arraySqlsInsercaoAnexosAgendamento[$contador]) or die("Erro ao executar a consulta!" . mysqli_error($conn));
    }
} else {
    http_response_code(400);
    die("Erro ao executar a consulta!" . mysqli_error($conn));
};



