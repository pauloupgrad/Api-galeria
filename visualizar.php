<?php
// Cabeçalhos
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir Conexão
include_once "conexao.php";

//$id = 16;
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$response = "";

$query_video = "SELECT id, titulo, canal, embed FROM videos WHERE id = :id LIMIT 1";
$result_video = $conn->prepare($query_video);
$result_video->bindParam(':id', $id);
$result_video->execute();

if(($result_video) AND ($result_video->rowCount() != 0)) {

    $row_video = $result_video->fetch(PDO::FETCH_ASSOC);
    extract($row_video);

    $video = [
        "id" => $id,
        "titulo" => $titulo,
        "canal" => $canal,        
        "embed" => $embed
    ];

    $response = [
        "erro" => false,
        "mensagem" => "Vídeo encontrado com sucesso!",
        "video" => $video
    ];
}else {
    $response = [
        "erro" => true,
        "mensagem" => "Nenhum vídeo encontrado!!"
    ];
}
// Resposta com status 200
http_response_code(200);
// Retornar videos em formato JSON
echo json_encode($response);