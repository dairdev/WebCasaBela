<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;
use Firebase\JWT\JWT;
use Slim\Views\Twig;

class CmsController
{

    public function __construct()
    {
    }

    public function index(Request $request, Response $response): Response
    {
      $twig = $this->get(Twig::class);
      return $twig->render($response, 'index.html.twig');
    }

}
