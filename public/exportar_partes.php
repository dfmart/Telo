<?php
header("Content-Type:application/xls");
header("Content-Disposition: attchment; filename=archivo.xls")


?>

<table>
<tr>
        <th>Id</th>
        <th>Tipo</th>
        <th>Placa</th>
        <th>Serial</th>
        <th>Proveedor</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Especificacion</th>
        <th>Estado</th>
        <th>Cliente</th>
        <th>Descripcion</th>
        <th>Tecnico</th>
        <th>Fecha Ingreso</th>
        <th>Fecha Salida</th>
    </tr>

    <?php

include("../conexion/conexion.php");
$registros = $base->query("SELECT * FROM registro_partes")->fetchAll(PDO::FETCH_OBJ); 
foreach ($registros as $persona) : ?>
    <tr>
        <td><?php echo htmlspecialchars($persona->id); ?></td>
        <td><?php echo htmlspecialchars($persona->tipo); ?></td>
        <td><?php echo htmlspecialchars($persona->placa); ?></td>
        <td><?php echo htmlspecialchars($persona->serial); ?></td>
        <td><?php echo htmlspecialchars($persona->proveedor); ?></td>
        <td><?php echo htmlspecialchars($persona->marca); ?></td>
        <td><?php echo htmlspecialchars($persona->modelo); ?></td>
        <td><?php echo htmlspecialchars($persona->especificacion); ?></td>
        <td><?php echo htmlspecialchars($persona->estado); ?></td>
        <td><?php echo htmlspecialchars($persona->cliente); ?></td>
        <td><?php echo htmlspecialchars($persona->descripcion); ?></td>
        <td><?php echo htmlspecialchars($persona->tecnico); ?></td>
        <td><?php echo htmlspecialchars($persona->fecha_ingreso); ?></td>
        <td><?php echo htmlspecialchars($persona->fecha_salida); ?></td>

    
    </tr>
    <?php endforeach; ?>
</table>

