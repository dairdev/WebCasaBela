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
    echo "Setting up database tables...\n";

    // Create roles table
    Capsule::schema()->dropIfExists("roles");
    Capsule::schema()->create("roles", function ($table) {
        $table->id();
        $table->string("name", 100)->unique();
        $table->text("description")->nullable();
        $table->boolean("active")->default(true);
        $table->timestamps();
    });
    echo "✓ Roles table created\n";

    // Create users table
    /*
    Capsule::schema()->dropIfExists("users");
    Capsule::schema()->create("users", function ($table) {
        $table->id();
        $table->string("email", 255)->unique();
        $table->string("password", 255);
        $table->timestamp("last_connection")->nullable();
        $table->unsignedBigInteger("role_id");
        $table->unsignedBigInteger("created_by")->nullable();
        $table->unsignedBigInteger("updated_by")->nullable();
        $table->timestamps();

        $table
            ->foreign("role_id")
            ->references("id")
            ->on("roles")
            ->onDelete("cascade");
        $table
            ->foreign("created_by")
            ->references("id")
            ->on("users")
            ->onDelete("set null");
        $table
            ->foreign("updated_by")
            ->references("id")
            ->on("users")
            ->onDelete("set null");
    });
    echo "✓ Users table created\n";

    // Create property_types table
    Capsule::schema()->dropIfExists("property_types");
    Capsule::schema()->create("property_types", function ($table) {
        $table->id();
        $table->string("name", 100)->unique();
        $table->text("description")->nullable();
        $table->boolean("active")->default(true);
        $table->timestamps();
    });
    echo "✓ Property types table created\n";

    // Create districts table
    Capsule::schema()->dropIfExists("districts");
    Capsule::schema()->create("districts", function ($table) {
        $table->id();
        $table->string("name", 100)->unique();
        $table->text("description")->nullable();
        $table->boolean("active")->default(true);
        $table->timestamps();
    });
    echo "✓ Districts table created\n";
     */

    // Create properties table
    Capsule::schema()->dropIfExists("properties");
    Capsule::schema()->create("properties", function ($table) {
        $table->id();
        $table->string("title", 255);
        $table->text("description");
        $table->decimal("price", 12, 2);
        $table->string("address", 255);
        $table->unsignedBigInteger("district_id");
        $table->unsignedBigInteger("property_type_id");
        $table->integer("bedrooms")->default(0);
        $table->integer("bathrooms")->default(0);
        $table->decimal("area", 8, 2)->nullable();
        $table->boolean("to_rent")->default(false);
        $table->boolean("to_sell")->default(false);
        $table->boolean("active")->default(true);
        $table->json("images")->nullable();
        $table->json("features")->nullable();
        $table->decimal("latitude", 10, 8)->nullable();
        $table->decimal("longitude", 11, 8)->nullable();
        $table->unsignedBigInteger("created_by")->nullable();
        $table->unsignedBigInteger("updated_by")->nullable();
        $table->timestamps();

        $table
            ->foreign("district_id")
            ->references("id")
            ->on("districts")
            ->onDelete("cascade");
        $table
            ->foreign("property_type_id")
            ->references("id")
            ->on("property_types")
            ->onDelete("cascade");
        $table
            ->foreign("created_by")
            ->references("id")
            ->on("users")
            ->onDelete("set null");
        $table
            ->foreign("updated_by")
            ->references("id")
            ->on("users")
            ->onDelete("set null");
    });
    echo "✓ Properties table created\n";

    // Seed roles
    echo "\nSeeding default data...\n";

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

    echo "✓ Default roles created\n";

    // Seed property types
    $propertyTypes = [
        ["name" => "Casa", "description" => "Casa unifamiliar"],
        ["name" => "Apartamento", "description" => "Apartamento en edificio"],
        ["name" => "Duplex", "description" => "Vivienda de dos plantas"],
        ["name" => "Local Comercial", "description" => "Espacio comercial"],
        ["name" => "Oficina", "description" => "Espacio de oficina"],
        ["name" => "Terreno", "description" => "Lote de terreno"],
    ];

    foreach ($propertyTypes as $type) {
        App\Models\PropertyType::create($type);
    }
    echo "✓ Property types seeded\n";

    // Seed districts
    $districts = [
        ["name" => "Centro", "description" => "Centro de la ciudad"],
        ["name" => "Norte", "description" => "Zona norte"],
        ["name" => "Sur", "description" => "Zona sur"],
        ["name" => "Este", "description" => "Zona este"],
        ["name" => "Oeste", "description" => "Zona oeste"],
        ["name" => "Residencial", "description" => "Zona residencial"],
    ];

    foreach ($districts as $district) {
        App\Models\District::create($district);
    }
    echo "✓ Districts seeded\n";

    // Create admin user
    $adminUser = User::create([
        "email" => "admin@casabela.com",
        "password" => "admin123", // This will be hashed by the model
        "role_id" => $adminRole->id,
        "last_connection" => null,
        "created_by" => null,
        "updated_by" => null,
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
        "updated_by" => null,
    ]);

    echo "✓ Demo user created\n";
    echo "  Email: demo@casabela.com\n";
    echo "  Password: demo123\n";

    // Seed some sample properties
    echo "\nSeeding sample properties...\n";

    $sampleProperties = [
        [
            "title" => "Casa familiar en el centro",
            "description" =>
                "Hermosa casa de 3 habitaciones en el centro de la ciudad, completamente renovada con acabados modernos.",
            "price" => 250000.0,
            "address" => "Calle Principal 123",
            "district_id" => 1,
            "property_type_id" => 1,
            "bedrooms" => 3,
            "bathrooms" => 2,
            "area" => 150.0,
            "to_sell" => true,
            "to_rent" => false,
            "active" => true,
            "features" => json_encode(["garage", "jardin", "balcon"]),
            "created_by" => $adminUser->id,
        ],
        [
            "title" => "Apartamento moderno",
            "description" =>
                "Apartamento de 2 habitaciones con vista al mar, piscina y gimnasio.",
            "price" => 1200.0,
            "address" => "Avenida del Mar 456",
            "district_id" => 2,
            "property_type_id" => 2,
            "bedrooms" => 2,
            "bathrooms" => 1,
            "area" => 80.0,
            "to_sell" => false,
            "to_rent" => true,
            "active" => true,
            "features" => json_encode(["piscina", "gimnasio", "vista_mar"]),
            "created_by" => $adminUser->id,
        ],
        [
            "title" => "Local comercial céntrico",
            "description" =>
                "Excelente local comercial en zona de alto tráfico, ideal para cualquier tipo de negocio.",
            "price" => 180000.0,
            "address" => "Plaza Central 789",
            "district_id" => 1,
            "property_type_id" => 4,
            "bedrooms" => 0,
            "bathrooms" => 1,
            "area" => 120.0,
            "to_sell" => true,
            "to_rent" => true,
            "active" => true,
            "features" => json_encode([
                "aire_acondicionado",
                "vitrina",
                "almacen",
            ]),
            "created_by" => $adminUser->id,
        ],
    ];

    foreach ($sampleProperties as $property) {
        App\Models\Property::create($property);
    }

    echo "✓ Sample properties created\n";

    echo "\n🎉 Database setup completed successfully!\n";
    echo "\nYou can now login with:\n";
    echo "Admin: admin@casabela.com / admin123\n";
    echo "Demo: demo@casabela.com / demo123\n";
    echo "\nAccess the login page at: http://localhost:8080/admin/login\n";
} catch (Exception $e) {
    echo "❌ Error setting up database: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
