<?php
// src/db.php
function conectarBD() {
    $host = getenv('DB_HOST');
    $db   = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');
    $charset = 'utf8mb4';

    // Si no pilla las variables de entorno, usa valores por defecto
    if (!$host) $host = 'localhost';
    if (!$db)   $db   = 'empresa';
    if (!$user) $user = 'root';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        // En producción no deberíamos mostrar el error real, pero para depurar sí:
        die("Error de conexión a la BBDD: " . $e->getMessage());
    }
}
?>