<?php
include_once '../negocio/controlador.php';
include_once '../datos/catalogo_usuario.php';

$controlador = new Controlador();

$tareas = $controlador->datosTarea();
$usuariosResponsables = $controlador->getUsuariosResponsables();

$tabla = '<table id="taskTable" class="table align-items-center mb-0">';
$tabla .= '<thead>';
$tabla .= '<tr>';
$tabla .= '<th>Titulo</th>';
$tabla .= '<th>Descripción</th>';
$tabla .= '<th>Responsable</th>';
$tabla .= '<th>Fecha de Vencimiento</th>';
$tabla .= '<th>Terminado</th>';
$tabla .= '<th>Integrantes</th>';
$tabla .= '<th>&nbsp;</th>';
$tabla .= '<th>Editar</th>';
$tabla .= '<th>Eliminar</th>';
$tabla .= '</tr>';
$tabla .= '</thead>';
$tabla .= '<tbody id="taskTableBody">';

foreach ($tareas as $tarea) {
    $tabla .= '<tr>';
    $tabla .= '<td>' . $tarea['titulo'] . '</td>';
    $tabla .= '<td>' . $tarea['descripcion'] . '</td>';
    $tabla .= '<td>' . $tarea['responsable'] . '</td>';
    $tabla .= '<td>' . $tarea['fecha_venc'] . '</td>';
    $tabla .= '<td><input type="checkbox" data-tarea-id="' . $tarea['id'] . '"></td>';
    $tabla .= '<td><select data-id="' . $tarea['id'] . '">';
    $tabla .= '<option value="">Seleccionar Integrante</option>';

    foreach ($usuariosResponsables as $usuario) {
        $selected = ($tarea['responsable'] == $usuario['nombre']) ? 'selected' : '';
        $tabla .= '<option value="' . $usuario['id'] . '" ' . $selected . '>' . $usuario['nombre'] . '</option>';
    }

    $tabla .= '</select>';
    $tabla .= '<div class="usuarios-tarea"></div>'; 
    $tabla .= '<td><button type="button" class="btn-agregar">Agregar</button></td>';
    $tabla .= '<td><button class="btn-editar">Editar</button></td>';    
    $tabla .= '<td><button class="btn-eliminar" data-tarea-id="' . $tarea['id'] . '">Eliminar</button></td>';
    $tabla .= '</tr>';
}

$tabla .= '</tbody>';
$tabla .= '</table>';
echo $tabla;
?>