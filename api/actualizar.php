<?php
require 'database.php';

// Obtener los datos publicados
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extraer los datos.
    $request = json_decode($postdata);

    // Validar si hay informacion.
    if ((int)$request->id < 1 || trim($request->nombre) == '' || (float)$request->precio < 0) {
        return http_response_code(400);
    }

    // Sanear.
    $id    = mysqli_real_escape_string($con, (int)$request->id);
    $nombre                  = mysqli_real_escape_string($con, trim($request->nombre));
    $descripcion             = mysqli_real_escape_string($con, trim($request->descripcion));
    $precio                  = mysqli_real_escape_string($con, trim($request->precio));
    $descuento               = mysqli_real_escape_string($con, (int)$request->descuento);
    $fecha_inicial_descuento = mysqli_real_escape_string($con, trim($request->fecha_inicial_descuento));
    $fecha_final_descuento   = mysqli_real_escape_string($con, trim($request->fecha_final_descuento));

    // Actualizar.
    $sql = "UPDATE `producto` SET `nombre`='$nombre',`descripcion`='$descripcion' ,
                      `precio` = '$precio', `descuento` = '$descuento',
                      `fecha_inicial_descuento` = '$fecha_inicial_descuento',
                      `fecha_final_descuento` = '$fecha_final_descuento'
           WHERE `id` = '{$id}' LIMIT 1";

    if(mysqli_query($con, $sql))
    {
        http_response_code(204);
    }
    else
    {
        return http_response_code(422);
    }
}