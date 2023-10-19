<?php
include_once '../negocio/controlador.php';
include_once '../datos/catalogo_usuario.php';

$controlador = new Controlador();

$tareas = $controlador->datosTareaComplete();
$usuariosResponsables = $controlador->getUsuariosResponsables();

$tabla = '<table id="taskTableComplete" class="table align-items-center mb-0">';
$tabla .= '<thead>';
$tabla .= '<tr>';
$tabla .= '<th>Titulo</th>';
$tabla .= '<th>Descripción</th>';
$tabla .= '<th>Responsable</th>';
$tabla .= '<th>Fecha de Vencimiento</th>';
$tabla .= '<th>Integrantes</th>';
$tabla .= '<th>Eliminar</th>';
$tabla .= '</tr>';
$tabla .= '</thead>';
$tabla .= '<tbody id="taskTableBody-complete">';

foreach ($tareas as $tarea) {
    $tabla .= '<tr>';
    $tabla .= '<td>' . $tarea['titulo'] . '</td>';
    $tabla .= '<td>' . $tarea['descripcion'] . '</td>';
    $tabla .= '<td>' . $tarea['responsable'] . '</td>';
    $tabla .= '<td>' . $tarea['fecha_venc'] . '</td>';
    $tabla .= '<td>' . $tarea['integrantes'] . '</td>';
    $tabla .= '<td><button type="button" class="btn-eliminar" data-tarea-id="' . $tarea['id'] . '">Eliminar</button></td>';
}

$tabla .= '</tbody>';
$tabla .= '</table>';
echo $tabla;
?>