<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

//GET TODOS LOS CLIENTES

$app->get('/api/clientes',function(Request $request , Response $response){
    $consulta = 'SELECT * FROM libro';
    try{
        $db = new db();

        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $clientes = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

       echo(json_encode($clientes));
  }
  catch(PDOException $e){
    $error = array('error' => array('text' => $e->getMessage()));
    $response->getBody()->write(json_encode($error));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
}
});

