<?php

require 'database.php';

// Se obtiene y se valida el id.
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
    return http_response_code(400);
}

// Se Porcede a Eliminar el Producto.
$sql = "DELETE FROM `producto` WHERE `id` ='{$id}' LIMIT 1";

if(mysqli_query($con, $sql))
{
    http_response_code(204);
}
else
{
    return http_response_code(422);
}