<?php
require_once 'db.php';

try {
    $pdo = conectarBD();

    // 1. Obtener Provincias
    $stmt = $pdo->query("SELECT id, nombre FROM provincias");
    // Creamos un array asociativo id => nombre
    $provincias = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // 2. Obtener Sedes
    $stmt = $pdo->query("SELECT id, nombre FROM sedes");
    $sedes = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // 3. Obtener Departamentos
    $stmt = $pdo->query("SELECT id, nombre FROM departamentos");
    $departamentos = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

} catch (PDOException $e) {
    // Si falla la BD, dejamos arrays vacíos para que no rompa la web
    $provincias = [];
    $sedes = [];
    $departamentos = [];
    $errorConexion = "Error cargando datos: " . $e->getMessage();
}
?>