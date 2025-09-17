<?php

use Illuminate\Database\Capsule\Manager as Capsule;

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Configurar Eloquent
$capsule = new Capsule();

$capsule->addConnection([
    "driver" => $_ENV["DB_DRIVER"] ?? "mysql",
    "host" => $_ENV["DB_HOST"] ?? "localhost",
    "database" => $_ENV["DB_DATABASE"] ?? "",
    "username" => $_ENV["DB_USERNAME"] ?? "",
    "password" => $_ENV["DB_PASSWORD"] ?? "",
    "charset" => $_ENV["DB_CHARSET"] ?? "utf8mb4",
    "collation" => $_ENV["DB_COLLATION"] ?? "utf8mb4_unicode_ci",
    "prefix" => $_ENV["DB_PREFIX"] ?? "",
    "port" => $_ENV["DB_PORT"] ?? 3306,
    "options" => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
]);

// Hacer que Eloquent esté disponible globalmente
$capsule->setAsGlobal();

// Inicializar Eloquent
$capsule->bootEloquent();

return $capsule;

?>
