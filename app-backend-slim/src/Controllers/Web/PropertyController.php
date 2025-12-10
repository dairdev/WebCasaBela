<?php
namespace App\Controllers\Web;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Property;

class PropertyController
{
  public function index(Request $request, Response $response): Response
  {
    $queryParams = $request->getQueryParams();

    // Construir query con filtros opcionales
    $query = Property::with(['propertyType', 'district.province', 'creator', 'updater']);

    // Filtros
    if (isset($queryParams['active']) && $queryParams['active'] === '1') {
      $query->active();
    }

    if (isset($queryParams['to_rent']) && $queryParams['to_rent'] === '1') {
      $query->forRent();
    }

    if (isset($queryParams['to_sell']) && $queryParams['to_sell'] === '1') {
      $query->forSale();
    }

    if (isset($queryParams['district_id'])) {
      $query->byDistrict($queryParams['district_id']);
    }

    if (isset($queryParams['property_type_id'])) {
      $query->byPropertyType($queryParams['property_type_id']);
    }

    if (isset($queryParams['min_price']) && isset($queryParams['max_price'])) {
      $query->priceRange($queryParams['min_price'], $queryParams['max_price']);
    }

    // Ordenamiento
    $sortBy = $queryParams['sort_by'] ?? 'created_at';
    $sortOrder = $queryParams['sort_order'] ?? 'desc';
    $query->orderBy($sortBy, $sortOrder);

    // Paginación
    $page = (int) ($queryParams['page'] ?? 1);
    $perPage = (int) ($queryParams['per_page'] ?? 10);
    $offset = ($page - 1) * $perPage;

    $total = $query->count();
    $properties = $query->skip($offset)->take($perPage)->get();

    $response->getBody()->write(json_encode([
      'properties' => $properties,
      'pagination' => [
        'current_page' => $page,
        'per_page' => $perPage,
        'total' => $total,
        'total_pages' => ceil($total / $perPage)
      ]
    ]));

    return $response->withHeader('Content-Type', 'application/json');
  }

  public function show(Request $request, Response $response, array $args): Response
  {
    $property = Property::with(['propertyType', 'district.province', 'creator', 'updater'])
      ->find($args['id']);

    if (!$property) {
      $response->getBody()->write(json_encode(['error' => 'Propiedad no encontrada']));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }

    $response->getBody()->write(json_encode([
      'property' => $property
    ]));

    return $response->withHeader('Content-Type', 'application/json');
  }
  
}
