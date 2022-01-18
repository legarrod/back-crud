<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//get all customers
$app->get('/api/getitems', function (Request $request, Response $response) {

    return try_catch_wrapper(function(){
        //throw new Exception('malo');
        $sql =  "SELECT * FROM `pedidos` WHERE 	estado_pedido = 'PENDIENTE' ORDER BY id DESC";
        $dbConexion = new DBConexion(new Conexion());
        $resultado = $dbConexion->executeQuery($sql);
        
        foreach ($resultado as $i=>$registro)  {
            $resultado[$i]['id'] = (int)$registro['id'];  
        }

        return $resultado ?: [];
    }, $response);
});

//create new customer
$app->post('/api/pedidos/post', function (Request $request, Response $response) {
    return try_catch_wrapper(function() use ($request){
          //throw new Exception('malo');
          $params = $request->getParams(); 

            $sql = "INSERT INTO pedidos (id, numero_mesa, id_pedido, nombre_empleado, direccion_pedido, observacion_pedido, estado_pedido) VALUES 
            (NULL,:numero_mesa, :id_pedido,:nombre_empleado,:direccion_pedido, :observacion_pedido, :estado_pedido)";
            $dbConexion = new DBConexion(new Conexion());
         
        $resultado = $dbConexion->executePrepare($sql, $params);
        return $resultado ?: [];
      }, $response);
  });


  //update all information for customer
$app->put('/api/pedidos/update', function (Request $request, Response $response) {

    return try_catch_wrapper(function() use ($request){
         //throw new Exception('malo');
         $sql = "UPDATE pedidos SET 
        numero_mesa = :numero_mesa,
        id_pedido = :id_pedido,
        direccion_pedido = :direccion_pedido,
        observacion_pedido = :observacion_pedido WHERE id_pedido = :id_pedido";
         $dbConexion = new DBConexion(new Conexion());
        $params = $request->getParams(); 
         $resultado = $dbConexion->executePrepare($sql, $params);
         return $resultado ?: [];
     }, $response);
 });

 $app->put('/api/pedidos/estado', function (Request $request, Response $response) {

    return try_catch_wrapper(function() use ($request){
         //throw new Exception('malo');
         $sql = "UPDATE pedidos SET 
        estado_pedido = :estado_pedido WHERE id_pedido = :id_pedido";
         $dbConexion = new DBConexion(new Conexion());
        $params = $request->getParams(); 
         $resultado = $dbConexion->executePrepare($sql, $params);
         return $resultado ?: [];
     }, $response);
 });

?>