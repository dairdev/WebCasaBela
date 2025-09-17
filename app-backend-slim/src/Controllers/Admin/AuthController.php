<?php
namespace App\Controllers\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;
use Firebase\JWT\JWT;

class AuthController
{
    private $jwtSecret;
    private $jwtExpiry;

    public function __construct($jwtSecret, $jwtExpiry)
    {
        $this->jwtSecret = $jwtSecret;
        $this->jwtExpiry = $jwtExpiry;
    }

    public function login(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (!isset($data["email"]) || !isset($data["password"])) {
            $response->getBody()->write(
                json_encode([
                    "error" => "Email y contraseña son requeridos",
                ])
            );
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(400);
        }

        $user = User::where("email", $data["email"])->first();

        if (!$user || !$user->verifyPassword($data["password"])) {
            $response->getBody()->write(
                json_encode([
                    "error" => "Credenciales inválidas",
                ])
            );
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(401);
        }

        // Actualizar última conexión
        $user->last_connection = date('Y-m-d H:i:s');
        $user->save();

        // Generar JWT
        $payload = [
            "user_id" => $user->id,
            "email" => $user->email,
            "role_id" => $user->role_id,
            "iat" => time(),
            "exp" => time() + $this->jwtExpiry,
        ];

        $token = JWT::encode($payload, $this->jwtSecret, "HS256");

        $response->getBody()->write(
            json_encode([
                "success" => true,
                "token" => $token,
                "user" => [
                    "id" => $user->id,
                    "email" => $user->email,
                    "role_id" => $user->role_id,
                    "last_connection" => $user->last_connection,
                ],
            ])
        );

        return $response->withHeader("Content-Type", "application/json");
    }

    public function me(Request $request, Response $response): Response
    {
        $userId = $request->getAttribute("user_id");
        $user = User::with("role")->find($userId);

        if (!$user) {
            $response
                ->getBody()
                ->write(json_encode(["error" => "Usuario no encontrado"]));
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(404);
        }

        $response->getBody()->write(
            json_encode([
                "user" => $user,
            ])
        );

        return $response->withHeader("Content-Type", "application/json");
    }
}
