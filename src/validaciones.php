<?php
/*
    Limpia los datos de entrada para evitar inyección de código (XSS).
    @param string $dato Dato a limpiar.
    @return string Dato limpio.
*/
function sanitizar($dato) {
    return htmlspecialchars(stripslashes(trim($dato)));
}

/*
    Valida si un campo está vacío (aunque ya no lo usemos en index, es útil tenerla).
    @param string $dato
    @return bool True si es válido (no vacío), False si está vacío.
*/
function validarRequerido($dato) {
    return !empty(trim($dato));
}

/*
    Valida el formato de un correo electrónico.
    @param string $email
    @return bool
*/
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/*
    Valida un número de teléfono (9 dígitos, formato español básico).
    @param string $telefono
    @return bool
*/
function validarTlfn($tlfn) {
    // Cambiado regex a comillas dobles
    return preg_match("/^[6789][0-9]{8}$/", $tlfn);
}

/*
    Valida un DNI español (8 números y una letra correcta).
    @param string $dni
    @return bool
*/
function validarDni($dni) {
    $dni = strtoupper(trim($dni));
    // Regex: 8 dígitos seguidos de una letra mayúscula
    if (preg_match("/^[0-9]{8}[A-Z]$/", $dni)) {
        $numero = substr($dni, 0, 8);
        $letra = substr($dni, -1);
        $letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";
        $indice = $numero % 23;
        
        // Comprobar si la letra calculada coincide con la introducida
        return $letrasValidas[$indice] === $letra;
    }
    return false;
}

/*
    Valida si una opción seleccionada existe en el array permitido.
    @param string $seleccion
    @param array $opciones
    @return bool
*/
function validarOpcion($seleccion, $opciones) {
    return array_key_exists($seleccion, $opciones);
}
?>