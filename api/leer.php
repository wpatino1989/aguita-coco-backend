<?php
/**
 * Regresa la lista de productos.
 */
require 'database.php';

$productos = [];
$sql = "SELECT id ,nombre ,descripcion,precio,descuento ,fecha_inicial_descuento ,fecha_final_descuento ,fecha_creacion 
        FROM producto Order by id desc ";

if($result = mysqli_query($con,$sql))
{
    $i = 0;
    while($row = mysqli_fetch_assoc($result))
    {
        $productos[$i]['id']                      = $row['id'];
        $productos[$i]['nombre']                  = $row['nombre'];
        $productos[$i]['descripcion']             = $row['descripcion'];
        $productos[$i]['precio']                  = $row['precio'];
        $productos[$i]['descuento']               = $row['descuento'];
        $productos[$i]['fecha_inicial_descuento'] = $row['fecha_inicial_descuento'];
        $productos[$i]['fecha_final_descuento']   = $row['fecha_final_descuento'];
        $productos[$i]['fecha_creacion']          = $row['fecha_creacion'];

        $i++;
    }

    echo json_encode($productos);
}
else
{
    http_response_code(404);
}