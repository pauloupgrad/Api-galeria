<?php
// Cabeçalhos
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");
//header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

// Incluir conexão
include_once "conexao.php";

$res_json = file_get_contents("php://input");
$dados = json_decode($res_json, true);


if($dados) {
    $embedDoLink = explode('?v=',$dados['video']['embed']);
    $embedDoLink = $embedDoLink[1];

    $canal = $dados['video']['canal'];
    
    $query_video = "INSERT INTO videos (titulo, canal, embed) VALUES (:titulo, :canal, :embed)";
    $cad_video = $conn->prepare($query_video);
    $cad_video->bindParam(":titulo", $dados['video']['titulo']);
    $cad_video->bindParam(":canal", $canal);    
    $cad_video->bindParam(":embed", $embedDoLink);
    $cad_video->execute(); 
    
    if($cad_video->rowCount()) {
        $video_id = $conn->lastInsertId();
        $query_categoria = "INSERT INTO categorias (video_id, nome_cat) VALUES (:id, :nome)";
        $cad_categoria = $conn->prepare($query_categoria);
        $cad_categoria->bindParam(':id', $video_id);
        $cad_categoria->bindParam(':nome', $canal);
        $cad_categoria->execute();

        $response = [            
            "error" => false,
            "mensagem" => "Vídeo e categoria cadastrado com sucesso!!"
        ];
    } else {
        $response = [
            "error" => true,
            "mensagem" => "Vídeo e categoria não foi cadastrado com sucesso 1!!"
        ];
    }
}else{
    $response = [
        "error" => false,
        "mensagem" => "Vídeo e categoria não foi cadastrado com sucesso 2!!"
    ];
}
http_response_code(200);
echo json_encode($response);
