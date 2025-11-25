<?php

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
    
    // Recogemos los datos usando TUS nombres de variables
    // El operador ?? "" asigna una cadena vacía si no llega el dato
    $datos["nombre"] = sanitizar($_POST["nombre"] ?? "");
    $datos["apellidos"] = sanitizar($_POST["apellidos"] ?? "");
    $datos["dni"] = sanitizar($_POST["dni"] ?? "");
    
    $datos["correo"] = sanitizar($_POST["correo"] ?? "");
    $datos["tlfno"] = sanitizar($_POST["tlfno"] ?? "");
    $datos["fecha"] = sanitizar($_POST["fecha"] ?? "");
    
    $datos["provincia"] = sanitizar($_POST["provincia"] ?? "");
    $datos["sede"] = sanitizar($_POST["sede"] ?? "");
    $datos["departamento"] = sanitizar($_POST["departamento"] ?? "");

    // 3. Validaciones (PHP)
    
    // DNI: Si el formato o la letra no cuadran
    if (!validarDni($datos["dni"])) {
        $errores["dni"] = "DNI incorrecto (revisa número y letra).";
    }

    // Correo: Si el formato no es de email
    if (!validarEmail($datos["correo"])) {
        $errores["correo"] = "Formato de correo inválido.";
    }

    // Teléfono: Si no tiene 9 dígitos
    if (!validarTlfn($datos["tlfno"])) {
        $errores["tlfno"] = "Debe tener 9 dígitos.";
    }

    // Validar Selects: Importante por seguridad
    if (!validarOpcion($datos["provincia"], $provincias)) $errores["provincia"] = "Elige una provincia válida.";
    if (!validarOpcion($datos["sede"], $sedes)) $errores["sede"] = "Elige una sede válida.";
    if (!validarOpcion($datos["departamento"], $departamentos)) $errores["departamento"] = "Elige un departamento válido.";

    // Si no hay errores, marcamos éxito
    if (empty($errores)) {
        $registroExitoso = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario empleados</title>
    <!-- Mantenemos el CSS para que se vea decente -->
    <link rel="stylesheet" href="./style.css">
</head>
<body>

<div class="container">
    <h1>Gestión de Empleados</h1>

    <?php if ($registroExitoso): ?>
        <!-- VISTA DE ÉXITO -->
        <div class="success-box">
            <h2>✅ Alta correcta</h2>
            <p>Datos registrados:</p>
            <ul>
                <li><strong>Nombre:</strong> <?php echo $datos["nombre"] . " " . $datos["apellidos"]; ?></li>
                <li><strong>DNI:</strong> <?php echo $datos["dni"]; ?></li>
                <li><strong>Correo:</strong> <?php echo $datos["correo"]; ?></li>
                <li><strong>Teléfono:</strong> <?php echo $datos["tlfno"]; ?></li>
                <li><strong>Fecha:</strong> <?php echo $datos["fecha"]; ?></li>
                <li><strong>Provincia:</strong> <?php echo $provincias[$datos["provincia"]]; ?></li>
                <li><strong>Sede:</strong> <?php echo $sedes[$datos["sede"]]; ?></li>
                <li><strong>Departamento:</strong> <?php echo $departamentos[$datos["departamento"]]; ?></li>
            </ul>
            <a href="index.php" class="btn-submit" style="display:block; text-align:center; text-decoration:none; margin-top:15px;">Volver</a>
        </div>

    <?php else: ?>
        
        <!-- FORMULARIO -->
        <form action="index.php" method="POST">
            
            <div class="form-group">
                <label for="nombre">Escribe tu nombre:</label>
                <!-- Usamos value para que no se borre si hay error -->
                <input type="text" id="nombre" name="nombre" required value="<?php echo old("nombre", $datos); ?>">
            </div>

            <div class="form-group">
                <label for="apellidos">Escribe tus apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required value="<?php echo old("apellidos", $datos); ?>">
            </div>

            <div class="form-group">
                <label for="dni">Escribe tu DNI:</label>
                <input type="text" id="dni" name="dni" placeholder="12345678A" required value="<?php echo old("dni", $datos); ?>">
                <?php mostrarError("dni", $errores); ?>
            </div>

            <div class="form-group">
                <label for="correo">Indica tu correo electrónico:</label>
                <input type="email" id="correo" name="correo" required value="<?php echo old("correo", $datos); ?>">
                <?php mostrarError("correo", $errores); ?>
            </div>

            <div class="form-group">
                <label for="tlfno">Escribe tu teléfono:</label>
                <input type="tel" id="tlfno" name="tlfno" required value="<?php echo old("tlfno", $datos); ?>">
                <?php mostrarError("tlfno", $errores); ?>
            </div>

            <div class="form-group">
                <label for="fecha">Fecha de alta:</label>
                <input type="date" id="fecha" name="fecha" required value="<?php echo old("fecha", $datos); ?>">
            </div>

            <!-- IMPORTANTE: Selects con arrays PHP -->
            
            <div class="form-group">
                <label for="provincia">Elige tu provincia:</label>
                <select name="provincia" id="provincia" required>
                    <?php pintarSelectOpciones($provincias, old("provincia", $datos)); ?>
                </select>
                <?php mostrarError("provincia", $errores); ?>
            </div>

            <div class="form-group">
                <label for="sede">Elige tu sede:</label>
                <select name="sede" id="sede" required>
                    <?php pintarSelectOpciones($sedes, old("sede", $datos)); ?>
                </select>
                <?php mostrarError("sede", $errores); ?>
            </div>

            <div class="form-group">
                <label for="departamento">Elige tu departamento:</label>
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