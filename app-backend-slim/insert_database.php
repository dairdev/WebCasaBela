<?php
require __DIR__ . "/vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\User;
use App\Models\Role;

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
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

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
  // Seed roles
  echo "\nSeeding default data...\n";

  /*
  $adminRole = Role::create([
    "name" => "Administrador",
    "description" => "Acceso completo al sistema",
    "active" => true,
  ]);

  $userRole = Role::create([
    "name" => "Usuario",
    "description" => "Acceso limitado al sistema",
    "active" => true,
  ]);
   */

  echo "✓ Default roles created\n";

  // Create admin user
  $adminUser = User::create([
    "email" => "admin@casabela.com",
    "password" => "admin123", // This will be hashed by the model
    "role_id" => $adminRole->id,
    "last_connection" => null,
    "created_by" => 1,
    "created_at" => date('Y-m-d H:i:s'),
  ]);

  echo "✓ Admin user created\n";
  echo "  Email: admin@casabela.com\n";
  echo "  Password: admin123\n";

  // Create a demo user
  $demoUser = User::create([
    "email" => "demo@casabela.com",
    "password" => "demo123", // This will be hashed by the model
    "role_id" => $userRole->id,
    "last_connection" => null,
    "created_by" => $adminUser->id,
    "created_at" => date('Y-m-d H:i:s'),
  ]);

  echo "✓ Demo user created\n";
  echo "  Email: demo@casabela.com\n";
  echo "  Password: demo123\n";


} catch (Exception $e) {
    echo "❌ Error setting up database: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

