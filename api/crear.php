<?php
require 'database.php';

// Obtener los datos publicados
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extraer los datos
    $request = json_decode($postdata);


    // validar.
    if(trim($request->nombre) === '' || (float)$request->precio < 0)
    {
        return http_response_code(400);
    }

    // Sanear.
    $nombre                  = mysqli_real_escape_string($con, trim($request->nombre));
    $descripcion             = mysqli_real_escape_string($con, trim($request->descripcion));
    $precio                  = mysqli_real_escape_string($con, trim($request->precio));
    $descuento               = mysqli_real_escape_string($con, (int)$request->descuento);
    $fecha_inicial_descuento = mysqli_real_escape_string($con, trim($request->fecha_inicial_descuento));
    $fecha_final_descuento   = mysqli_real_escape_string($con, trim($request->fecha_final_descuento));

    // Crear.
    $sql = "INSERT INTO `producto`(`id`,`nombre`,`descripcion`,`precio`,`descuento`,`fecha_inicial_descuento`,`fecha_final_descuento`,`fecha_creacion`) 
           VALUES (null,'{$nombre}','{$descripcion}','{$precio}','{$descuento}','{$fecha_inicial_descuento}','{$fecha_final_descuento}',current_date )";

    if(mysqli_query($con,$sql))
    {
        http_response_code(201);
        $producto = [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'descuento' => $descuento,
            'fecha_inicial_descuento' => $fecha_inicial_descuento,
            'fecha_final_descuento' => $fecha_final_descuento,
            'id'    => mysqli_insert_id($con)
        ];
        echo json_encode($producto);
    }
    else
    {
        http_response_code(422);
    }
}