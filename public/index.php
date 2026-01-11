<?php
// public/index.php

// 1. Incluimos los archivos de lógica
require_once "../src/datos.php";
require_once "../src/validaciones.php";
require_once "../src/vistas.php";

// Inicializamos variables
$errores = [];
$datos = [];
$registroExitoso = false;

// 2. Comprobar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Recogemos los datos (Sanitizar debe estar en validaciones.php)
    // Si no tienes la función sanitizar, usa htmlspecialchars
    $datos["nombre"] = isset($_POST["nombre"]) ? trim(htmlspecialchars($_POST["nombre"])) : "";
    $datos["apellidos"] = isset($_POST["apellidos"]) ? trim(htmlspecialchars($_POST["apellidos"])) : "";
    $datos["dni"] = isset($_POST["dni"]) ? trim(htmlspecialchars($_POST["dni"])) : "";
    
    $datos["correo"] = isset($_POST["correo"]) ? trim(htmlspecialchars($_POST["correo"])) : "";
    $datos["tlfno"] = isset($_POST["tlfno"]) ? trim(htmlspecialchars($_POST["tlfno"])) : "";
    $datos["fecha"] = isset($_POST["fecha"]) ? trim(htmlspecialchars($_POST["fecha"])) : "";
    
    $datos["provincia"] = isset($_POST["provincia"]) ? $_POST["provincia"] : "";
    $datos["sede"] = isset($_POST["sede"]) ? $_POST["sede"] : "";
    $datos["departamento"] = isset($_POST["departamento"]) ? $_POST["departamento"] : "";

    // 3. Validaciones (PHP) - Asumimos que las funciones existen en validaciones.php
    // Si no existen, comenta estas líneas para probar
    if (function_exists('validarDni') && !validarDni($datos["dni"])) {
        $errores["dni"] = "DNI incorrecto.";
    }
    if (function_exists('validarEmail') && !validarEmail($datos["correo"])) {
        $errores["correo"] = "Correo inválido.";
    }
    if (function_exists('validarTlfn') && !validarTlfn($datos["tlfno"])) {
        $errores["tlfno"] = "Teléfono incorrecto (9 dígitos).";
    }

    // Validar que los IDs de los selects existen en los arrays cargados de la BBDD
    if (!array_key_exists($datos["provincia"], $provincias)) $errores["provincia"] = "Provincia inválida.";
    if (!array_key_exists($datos["sede"], $sedes)) $errores["sede"] = "Sede inválida.";
    if (!array_key_exists($datos["departamento"], $departamentos)) $errores["departamento"] = "Departamento inválido.";

    // Si no hay errores, intentamos guardar en BBDD
    if (empty($errores)) {
        try {
            // Reutilizamos la conexión de datos.php
            if (!isset($pdo)) { 
                require_once "../src/db.php";
                $pdo = conectarBD(); 
            }

            // CORRECCIÓN IMPORTANTE:
            // La tabla empleados tiene: nombre, apellidos, dni, email, telefono, fecha_alta, id_sede, id_departamento
            // NO tiene provincia_id (porque la sede ya pertenece a una provincia)
            
            $sql = "INSERT INTO empleados (nombre, apellidos, dni, email, telefono, fecha_alta, id_sede, id_departamento) 
                    VALUES (:nombre, :apellidos, :dni, :email, :tlfno, :fecha, :sede, :departamento)";
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                ':nombre'       => $datos["nombre"],
                ':apellidos'    => $datos["apellidos"],
                ':dni'          => $datos["dni"],
                ':email'        => $datos["correo"],
                ':tlfno'        => $datos["tlfno"],
                ':fecha'        => $datos["fecha"],
                ':sede'         => $datos["sede"],         // ID de la sede
                ':departamento' => $datos["departamento"]  // ID del departamento
            ]);

            $registroExitoso = true;

        } catch (PDOException $e) {
            $errores["general"] = "Error BBDD: " . $e->getMessage();
        }
    }
}

// Función auxiliar 'old' por si no está en vistas.php
if (!function_exists('old')) {
    function old($campo, $datos) {
        return isset($datos[$campo]) ? $datos[$campo] : "";
    }
}

// Función auxiliar 'mostrarError' por si no está
if (!function_exists('mostrarError')) {
    function mostrarError($campo, $errores) {
        if (isset($errores[$campo])) {
            echo '<span class="error-msg">' . $errores[$campo] . '</span>';
        }
    }
}

// Función auxiliar 'pintarSelectOpciones' por si no está
if (!function_exists('pintarSelectOpciones')) {
    function pintarSelectOpciones($opciones, $seleccionado) {
        echo '<option value="">-- Seleccione una opción --</option>';
        foreach ($opciones as $id => $nombre) {
            $selected = ($id == $seleccionado) ? 'selected' : '';
            echo "<option value=\"$id\" $selected>$nombre</option>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario empleados Cloud</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>

<div class="container">
    <h1>Gestión de Empleados (Cloud)</h1>

    <?php if ($registroExitoso): ?>
        <div class="success-box">
            <h2>✅ Alta correcta en AWS RDS</h2>
            <p>Datos registrados:</p>
            <ul>
                <li><strong>Nombre:</strong> <?php echo $datos["nombre"] . " " . $datos["apellidos"]; ?></li>
                <li><strong>DNI:</strong> <?php echo $datos["dni"]; ?></li>
                <li><strong>Sede:</strong> <?php echo $sedes[$datos["sede"]]; ?></li>
                <li><strong>Departamento:</strong> <?php echo $departamentos[$datos["departamento"]]; ?></li>
            </ul>
            <a href="index.php" class="btn-submit" style="display:block; text-align:center; text-decoration:none; margin-top:15px;">Volver</a>
        </div>

    <?php else: ?>
        
        <?php if (isset($errores["general"])): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                <?php echo $errores["general"]; ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required value="<?php echo old("nombre", $datos); ?>">
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required value="<?php echo old("apellidos", $datos); ?>">
            </div>
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" required value="<?php echo old("dni", $datos); ?>">
                <?php mostrarError("dni", $errores); ?>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required value="<?php echo old("correo", $datos); ?>">
                <?php mostrarError("correo", $errores); ?>
            </div>
            <div class="form-group">
                <label for="tlfno">Teléfono:</label>
                <input type="tel" id="tlfno" name="tlfno" required value="<?php echo old("tlfno", $datos); ?>">
                <?php mostrarError("tlfno", $errores); ?>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha de alta:</label>
                <input type="date" id="fecha" name="fecha" required value="<?php echo old("fecha", $datos); ?>">
            </div>

            <div class="form-group">
                <label for="provincia">Provincia:</label>
                <select name="provincia" id="provincia" required>
                    <?php pintarSelectOpciones($provincias, old("provincia", $datos)); ?>
                </select>
                <?php mostrarError("provincia", $errores); ?>
            </div>

            <div class="form-group">
                <label for="sede">Sede:</label>
                <select name="sede" id="sede" required>
                    <?php pintarSelectOpciones($sedes, old("sede", $datos)); ?>
                </select>
                <?php mostrarError("sede", $errores); ?>
            </div>

            <div class="form-group">
                <label for="departamento">Departamento:</label>
                <select name="departamento" id="departamento" required>
                    <?php pintarSelectOpciones($departamentos, old("departamento", $datos)); ?>
                </select>
                <?php mostrarError("departamento", $errores); ?>
            </div>

            <input type="submit" value="Enviar Datos" class="btn-submit">
        </form>
    <?php endif; ?>
</div>

</body>
</html>
