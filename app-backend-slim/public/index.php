<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Controllers\CmsController;
use App\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\UserController;
use App\Controllers\Web\PropertyController as WebPropertyController;
use App\Middleware\JwtMiddleware;

require __DIR__ . "/../vendor/autoload.php";

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

// Configurar base de datos
require __DIR__ . "/../config/database.php";

// Create Container
$container = new Container();

// Set view in Container
$container->set(Twig::class, function () {
    //return Twig::create(__DIR__ . '/../templates', ['cache' => __DIR__ . '/../cache']);
    return Twig::create(__DIR__ . '/../templates');
});

// Create App from container
$app = AppFactory::createFromContainer($container);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $container->get(Twig::class)));

// Agregar middleware de parsing del body
$app->addBodyParsingMiddleware();

// Middleware de manejo de errores
$app->addErrorMiddleware(true, true, true);

// CORS Middleware
$app->add(function (Request $request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader("Access-Control-Allow-Origin", "*")
        ->withHeader(
            "Access-Control-Allow-Headers",
            "X-Requested-With, Content-Type, Accept, Origin, Authorization"
        )
        ->withHeader(
            "Access-Control-Allow-Methods",
            "GET, POST, PUT, DELETE, PATCH, OPTIONS"
        );
});

// Controladores
$authController = new AuthController($_ENV["JWT_SECRET"], $_ENV["JWT_EXPIRY"]);
$userController = new UserController();
$propertyController = new WebPropertyController();
$adminPropertyController = new AdminPropertyController();
$cmsController = new CmsController();

// JWT Middleware
$jwtMiddleware = new JwtMiddleware($_ENV["JWT_SECRET"]);

// Rutas públicas
$app->get('/', function (Request $request, Response $response) {
      $twig = $this->get(Twig::class);
      return $twig->render($response, 'index.html.twig');
});

$app->get('/propiedades', function (Request $request, Response $response) {
      $twig = $this->get(Twig::class);
      return $twig->render($response, 'propiedades.html.twig');
});

$app->get('/propiedad/{id}', function (Request $request, Response $response, array $args) {
      $twig = $this->get(Twig::class);
      return $twig->render($response, 'propiedad.html.twig');
});

$app->get('/contacto', function (Request $request, Response $response) {
      $twig = $this->get(Twig::class);
      return $twig->render($response, 'contacto.html.twig');
});

$app->get('/admin', function (Request $request, Response $response) {
      $twig = $this->get(Twig::class);
      return $twig->render($response, 'admin.html.twig');
});

$app->get('/admin/login', function (Request $request, Response $response) {
      $twig = $this->get(Twig::class);
      return $twig->render($response, 'login.html.twig');
});

$app->post("/api/auth/login", [$authController, "login"]);

// Rutas protegidas
$app->group("/api", function ($group) use ($authController, $userController, $adminPropertyController) {
    $group->get("/auth/me", [$authController, "me"]);

    // CRUD de usuarios
    $group->get("/users", [$userController, "index"]);
    $group->get("/users/{id}", [$userController, "show"]);
    $group->post("/users", [$userController, "store"]);
    $group->put("/users/{id}", [$userController, "update"]);
    $group->delete("/users/{id}", [$userController, "delete"]);

    // CRUD de propiedades
    $group->get('/properties', [$propertyController, 'index']);
    $group->get('/properties/{id}', [$propertyController, 'show']);
    $group->post('/properties', [$propertyController, 'store']);
    $group->put('/properties/{id}', [$propertyController, 'update']);
    $group->delete('/properties/{id}', [$propertyController, 'delete']);
    //$group->get('/properties/stats', [$propertyController, 'stats']); // Estadísticas
})->add($jwtMiddleware);

// Ruta de prueba
/*
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write(json_encode([
        'message' => 'API CRUD de Usuarios y Propiedades con SlimPHP 4 y JWT',
        'version' => '1.0.0',
        'endpoints' => [
            // Autenticación
            'POST /api/auth/login' => 'Iniciar sesión',
            'GET /api/auth/me' => 'Información del usuario actual',

            // Usuarios
            'GET /api/users' => 'Listar usuarios',
            'GET /api/users/{id}' => 'Obtener usuario',
            'POST /api/users' => 'Crear usuario',
            'PUT /api/users/{id}' => 'Actualizar usuario',
            'DELETE /api/users/{id}' => 'Eliminar usuario',

            // Propiedades
            'GET /api/properties' => 'Listar propiedades (con filtros)',
            'GET /api/properties/{id}' => 'Obtener propiedad',
            'POST /api/properties' => 'Crear propiedad',
            'PUT /api/properties/{id}' => 'Actualizar propiedad',
            'DELETE /api/properties/{id}' => 'Eliminar propiedad',
            'GET /api/properties/stats' => 'Estadísticas de propiedades'
        ],
        'property_filters' => [
            'active' => 'Filtrar propiedades activas (1/0)',
            'to_rent' => 'Filtrar propiedades en alquiler (1/0)',
            'to_sell' => 'Filtrar propiedades en venta (1/0)',
            'district_id' => 'Filtrar por distrito',
            'property_type_id' => 'Filtrar por tipo de propiedad',
            'min_price' => 'Precio mínimo',
            'max_price' => 'Precio máximo',
            'sort_by' => 'Ordenar por campo',
            'sort_order' => 'Orden (asc/desc)',
            'page' => 'Página',
            'per_page' => 'Elementos por página'
        ]
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});*/

$app->run();
