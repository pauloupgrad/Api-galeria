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
    $query_video = "UPDATE videos SET titulo = :titulo, canal = :canal, embed = :embed  WHERE id = :id";
    $result_video = $conn->prepare($query_video);
    $result_video->bindParam(':titulo', $dados['titulo']);
    $result_video->bindParam(':canal', $dados['canal']);
    $result_video->bindParam(':embed', $dados['embed']);
    $result_video->bindParam(':id', $dados['id']);
    $result_video->execute();

    if($result_video->rowCount()) {
        $query_categoria = "UPDATE categorias SET nome_cat = :nome_canal WHERE video_id = :id";
        $cad_categoria = $conn->prepare($query_categoria);
        $cad_categoria->bindParam(':nome_canal', $dados['canal']);
        $cad_categoria->bindParam(':id', $dados['id']);
        $cad_categoria->execute();
        
        $response = [
            "erro" => false,
            "mensagem" => "Vídeo editado com sucesso!",
            "data" => $dados
        ];
    }else{
        $response = [
            "erro" => true,
            "mensagem" => "Vídeo não editado com sucesso!",       
        ];        
    }
}else{
    $response = [
        "erro" => true,
        "mensagem" => "Vídeo não editado com sucesso!",       
    ]; 
}


http_response_code(200);
echo json_encode($response);