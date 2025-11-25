<?php
/*
    Genera las opciones de un <select> HTML a partir de un array.
    Mantiene la opción seleccionada si hubo error en el formulario.
*/
function pintarSelectOpciones($opciones, $seleccionado = "") {
    // Nota: Las comillas dobles DENTRO del HTML deben escaparse con \".
    echo "<option value=\"\" disabled " . ($seleccionado == "" ? "selected" : "") . ">-- Seleccione una opción --</option>";
    
    foreach ($opciones as $clave => $valor) {
        $selected = ($clave == $seleccionado) ? "selected" : "";
        echo "<option value=\"$clave\" $selected>$valor</option>";
    }
}

/*
    Muestra un mensaje de error si existe para un campo determinado.
*/
function mostrarError($campo, $errores) {
    if (isset($errores[$campo])) {
        echo "<span class=\"error-msg\">" . $errores[$campo] . "</span>";
    }
}

/*
    Recupera el valor antiguo de un campo para no borrarlo si hay error.
*/
function old($campo, $datos) {
    return isset($datos[$campo]) ? $datos[$campo] : "";
}
?>