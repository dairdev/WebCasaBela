<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Slim\Psr7\Response as SlimResponse;

class JwtMiddleware
{
    private $jwtSecret;

    public function __construct($jwtSecret)
    {
        $this->jwtSecret = $jwtSecret;
    }

    public function __invoke(
        Request $request,
        RequestHandler $handler
    ): Response {
        $authHeader = $request->getHeaderLine("Authorization");

        if (!$authHeader) {
            $response = new SlimResponse();
            $response
                ->getBody()
                ->write(json_encode(["error" => "Token requerido"]));
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(401);
        }

        $token = str_replace("Bearer ", "", $authHeader);

        try {
            $decoded = JWT::decode($token, new Key($this->jwtSecret, "HS256"));
            $request = $request->withAttribute("user_id", $decoded->user_id);
            $request = $request->withAttribute("user_email", $decoded->email);

            return $handler->handle($request);
        } catch (Exception $e) {
            $response = new SlimResponse();
            $response
                ->getBody()
                ->write(json_encode(["error" => "Token inválido"]));
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(401);
        }
    }
}
