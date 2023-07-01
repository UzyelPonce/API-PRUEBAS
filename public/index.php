<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ .'/../src/config/db.php';
require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name'); 
    $response->getBody()->write("Hello $name");
    return $response;
});

//require "../src/rutas/libros.php";


$app->get('/api/rol',function(Request $request , Response $response){
    $consulta = 'SELECT * FROM roles';

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $roles = $ejecutar->fetchAll(PDO::FETCH_OBJ);

        /* ($roles as $resultado) {
            $idroll = $resultado->idroll;
            $tiporoll = $resultado->tiporoll;    

        }*/
       
        $response->getBody()->write(json_encode(["roles" => $roles]));
  
        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);   


});

$app->get('/api/marcas',function(Request $request , Response $response){
    $consulta = 'SELECT * FROM marca';

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $marcas = $ejecutar->fetchAll(PDO::FETCH_OBJ);       
       
        $response->getBody()->write(json_encode(["marcas" => $marcas]));
  
        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);   


});



$app->get('/api/msj',function(Request $request , Response $response){
    $consulta = 'SELECT * FROM mensajes';

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $mensaje = $ejecutar->fetchAll(PDO::FETCH_OBJ);       
       
        $response->getBody()->write(json_encode(["mensajes" => $mensaje]));
  
        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);   


});


$app->get('/api/ventas',function(Request $request , Response $response){
    $consulta = 'SELECT * FROM venta';

        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $ventas = $ejecutar->fetchAll(PDO::FETCH_OBJ);

        /* ($roles as $resultado) {
            $idroll = $resultado->idroll;
            $tiporoll = $resultado->tiporoll;    

        }*/
       
        $response->getBody()->write(json_encode(["ventas" => $ventas]));
  
        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);   


});

$app->post('/registro', function(Request $request, Response $response) {
  // Obtener los datos del cuerpo de la solicitud
  $parsedBody = $request->getParsedBody();
  
  // Obtener los valores de los campos
  $nombre = $parsedBody['NOMBRE'] ?? '';
  $apellidos = $parsedBody['APELLIDOS'] ?? '';
  $correo = $parsedBody['CORREO'] ?? '';
  $contrasena = $parsedBody['PASS'] ?? '';

  // Consulta SQL para insertar los datos en la tabla
    $consulta = "INSERT INTO usuarios (NOMBRE, APELLIDOS, CORREO, PASS) 
               VALUES (:nombre, :apellidos, :correo, :contrasena)";

  try {
      // Instancia de base de datos
      $db = new db();

      // Conexión
      $conexion = $db->conectar();
      
      // Preparar la consulta
      $stmt = $conexion->prepare($consulta);
      
      // Vincular los parámetros
      $stmt->bindParam(':nombre', $nombre);
      $stmt->bindParam(':apellidos', $apellidos);
      $stmt->bindParam(':correo', $correo);
      $stmt->bindParam(':contrasena', $contrasena);
      
      // Ejecutar la consulta
      $stmt->execute();
      
      // Crear una respuesta JSON
      $responseData ='Registro exitoso';
      
      
      // Establecer el cuerpo de la respuesta JSON
      $response->getBody()->write(json_encode($responseData));
      
      // Devolver la respuesta con el código de estado 200 (OK)
      return $response
          ->withStatus(200)
          ->withHeader('Content-Type', 'application/json');
  } catch(PDOException $e) {
      // Crear una respuesta JSON de error
      $responseData = [
          'error' => ['text' => $e->getMessage()]
      ];
      
      // Establecer el cuerpo de la respuesta JSON
      $response->getBody()->write(json_encode($responseData));
      
      // Devolver la respuesta con el código de estado 500 (Error interno del servidor)
      return $response
          ->withStatus(500)
          ->withHeader('Content-Type', 'application/json');
  }
});




$app->run();