<?php
// Cabeçalhos
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir Conexão
include_once "conexao.php";

$query_videos = "SELECT id, titulo, canal, embed FROM videos ORDER BY id DESC";
$result_videos = $conn->prepare($query_videos);
$result_videos->execute();

if(($result_videos) AND ($result_videos->rowCount() != 0)){   
    while($row_videos = $result_videos->fetch(PDO::FETCH_ASSOC)){        

        extract($row_videos);

        $lista_videos["records"][$id] = [
            'id' => $id,
            'titulo' => $titulo,
            'canal' => $canal,            
            'embed' => $embed
        ];
    }
    
    // Resposta com status 200
    http_response_code(200);

    // Retornar produtos em formato JSON
    
    echo json_encode($lista_videos);
}