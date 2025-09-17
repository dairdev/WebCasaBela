<?php
namespace App\Controllers\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;

class UserController
{
    public function index(Request $request, Response $response): Response
    {
        $users = User::with("role")->get();

        $response->getBody()->write(
            json_encode([
                "users" => $users,
            ])
        );

        return $response->withHeader("Content-Type", "application/json");
    }

    public function show(
        Request $request,
        Response $response,
        array $args
    ): Response {
        $user = User::with("role")->find($args["id"]);

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

    public function store(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $currentUserId = $request->getAttribute("user_id");

        // Validaciones básicas
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

        // Verificar si el email ya existe
        if (User::where("email", $data["email"])->exists()) {
            $response->getBody()->write(
                json_encode([
                    "error" => "El email ya está registrado",
                ])
            );
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(400);
        }

        try {
            $user = new User();
            $user->email = $data["email"];
            $user->password = $data["password"]; // Se encripta automáticamente
            $user->role_id = $data["role_id"] ?? null;
            $user->created_by = $currentUserId;
            $user->save();

            $user->load("role");

            $response->getBody()->write(
                json_encode([
                    "success" => true,
                    "message" => "Usuario creado exitosamente",
                    "user" => $user,
                ])
            );

            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(201);
        } catch (Exception $e) {
            $response->getBody()->write(
                json_encode([
                    "error" => "Error al crear usuario: " . $e->getMessage(),
                ])
            );
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(500);
        }
    }

    public function update(
        Request $request,
        Response $response,
        array $args
    ): Response {
        $user = User::find($args["id"]);

        if (!$user) {
            $response
                ->getBody()
                ->write(json_encode(["error" => "Usuario no encontrado"]));
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(404);
        }

        $data = json_decode($request->getBody()->getContents(), true);
        $currentUserId = $request->getAttribute("user_id");

        try {
            if (isset($data["email"]) && $data["email"] !== $user->email) {
                // Verificar si el nuevo email ya existe
                if (
                    User::where("email", $data["email"])
                        ->where("id", "!=", $user->id)
                        ->exists()
                ) {
                    $response->getBody()->write(
                        json_encode([
                            "error" => "El email ya está registrado",
                        ])
                    );
                    return $response
                        ->withHeader("Content-Type", "application/json")
                        ->withStatus(400);
                }
                $user->email = $data["email"];
            }

            if (isset($data["password"]) && !empty($data["password"])) {
                $user->password = $data["password"]; // Se encripta automáticamente
            }

            if (isset($data["role_id"])) {
                $user->role_id = $data["role_id"];
            }

            $user->updated_by = $currentUserId;
            $user->save();

            $user->load("role");

            $response->getBody()->write(
                json_encode([
                    "success" => true,
                    "message" => "Usuario actualizado exitosamente",
                    "user" => $user,
                ])
            );

            return $response->withHeader("Content-Type", "application/json");
        } catch (Exception $e) {
            $response->getBody()->write(
                json_encode([
                    "error" =>
                        "Error al actualizar usuario: " . $e->getMessage(),
                ])
            );
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(500);
        }
    }

    public function delete(
        Request $request,
        Response $response,
        array $args
    ): Response {
        $user = User::find($args["id"]);

        if (!$user) {
            $response
                ->getBody()
                ->write(json_encode(["error" => "Usuario no encontrado"]));
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(404);
        }

        try {
            $user->delete();

            $response->getBody()->write(
                json_encode([
                    "success" => true,
                    "message" => "Usuario eliminado exitosamente",
                ])
            );

            return $response->withHeader("Content-Type", "application/json");
        } catch (Exception $e) {
            $response->getBody()->write(
                json_encode([
                    "error" => "Error al eliminar usuario: " . $e->getMessage(),
                ])
            );
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(500);
        }
    }
}
