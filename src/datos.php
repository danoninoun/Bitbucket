<?php
// src/datos.php
require_once 'db.php';

try {
    $pdo = conectarBD();

    // 1. Obtener Provincias (Usamos id_provincia y nombre)
    $stmt = $pdo->query("SELECT id_provincia, nombre FROM provincias");
    $provincias = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // 2. Obtener Sedes (Usamos id_sede y nombre)
    $stmt = $pdo->query("SELECT id_sede, nombre FROM sedes");
    $sedes = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // 3. Obtener Departamentos (Usamos id_departamento y nombre)
    $stmt = $pdo->query("SELECT id_departamento, nombre FROM departamentos");
    $departamentos = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

} catch (PDOException $e) {
    // Si falla, dejamos los arrays vacíos para que no explote la web
    $provincias = [];
    $sedes = [];
    $departamentos = [];
    // Descomenta la siguiente línea si quieres ver el error en pantalla:
    // echo "Error cargando datos: " . $e->getMessage();
}
?>