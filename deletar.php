<?php
// Cabeçalhos
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir Conexão
include_once "conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$response = "";

$query_video = "DELETE FROM videos WHERE id = :id LIMIT 1";
$result_video = $conn->prepare($query_video);
$result_video->bindParam(':id', $id);

if($result_video->execute()) {
    $query_categoria = "DELETE FROM categorias WHERE video_id = :id";
    $result_categoria = $conn->prepare($query_categoria);
    $result_categoria->bindParam(':id', $id);
    $result_categoria->execute();

    $response = [
        "erro" => false,
        "mensagem" => "Vídeo deletado com sucesso!!"
    ];
}else{
    $response = [
        "erro" => true,
        "mensagem" => "Vídeo não foi deletado com sucesso!!"
    ];
}

http_response_code(200);
echo json_encode($response);