<?php
namespace App\Controllers\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\District;

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

  public function store(Request $request, Response $response): Response
  {
    $data = json_decode($request->getBody()->getContents(), true);
    $currentUserId = $request->getAttribute('user_id');

    // Validaciones básicas
    $requiredFields = ['description', 'address'];
    foreach ($requiredFields as $field) {
      if (!isset($data[$field]) || empty($data[$field])) {
        $response->getBody()->write(json_encode([
          'error' => "El campo {$field} es requerido"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
      }
    }

    // Validar que al menos una opción de venta/alquiler esté activa
    if (empty($data['to_rent']) && empty($data['to_sell'])) {
      $response->getBody()->write(json_encode([
        'error' => 'La propiedad debe estar disponible para venta o alquiler'
      ]));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    // Validar relaciones si se proporcionan
    if (isset($data['district_id']) && !District::find($data['district_id'])) {
      $response->getBody()->write(json_encode([
        'error' => 'El distrito especificado no existe'
      ]));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    if (isset($data['propertytype_id']) && !PropertyType::find($data['propertytype_id'])) {
      $response->getBody()->write(json_encode([
        'error' => 'El tipo de propiedad especificado no existe'
      ]));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    try {
      $property = new Property();

      // Campos obligatorios
      $property->description = $data['description'];
      $property->address = $data['address'];
      $property->created_by = $currentUserId;

      // Campos opcionales con valores por defecto
      $property->propertytype_id = $data['propertytype_id'] ?? null;
      $property->district_id = $data['district_id'] ?? null;
      $property->number = $data['number'] ?? null;
      $property->floor = $data['floor'] ?? null;
      $property->department_number = $data['department_number'] ?? null;
      $property->building_name = $data['building_name'] ?? null;
      $property->floors = $data['floors'] ?? null;
      $property->base_price = $data['base_price'] ?? 0;
      $property->shown_price = $data['shown_price'] ?? 0;
      $property->contract_price = $data['contract_price'] ?? 0;
      $property->covered_area = $data['covered_area'] ?? 0;
      $property->build_area = $data['build_area'] ?? 0;
      $property->total_area = $data['total_area'] ?? 0;
      $property->to_rent = isset($data['to_rent']) ? (bool)$data['to_rent'] : false;
      $property->to_sell = isset($data['to_sell']) ? (bool)$data['to_sell'] : false;
      $property->rooms = $data['rooms'] ?? 0;
      $property->bathrooms = $data['bathrooms'] ?? 0;
      $property->garages = $data['garages'] ?? 0;
      $property->laundries = $data['laundries'] ?? 0;
      $property->water_tanker = $data['water_tanker'] ?? 0;
      $property->yards = $data['yards'] ?? 0;
      $property->year_build = $data['year_build'] ?? null;
      $property->is_active = isset($data['is_active']) ? (bool)$data['is_active'] : false;

      $property->save();

      $property->load(['propertyType', 'district.province', 'creator']);

      $response->getBody()->write(json_encode([
        'success' => true,
        'message' => 'Propiedad creada exitosamente',
        'property' => $property
      ]));

      return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    } catch (Exception $e) {
      $response->getBody()->write(json_encode([
        'error' => 'Error al crear propiedad: ' . $e->getMessage()
      ]));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
  }


  public function update(Request $request, Response $response, array $args): Response
  {
    $property = Property::find($args['id']);

    if (!$property) {
      $response->getBody()->write(json_encode(['error' => 'Propiedad no encontrada']));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }

    $data = json_decode($request->getBody()->getContents(), true);
    $currentUserId = $request->getAttribute('user_id');

    // Validar relaciones si se proporcionan
    if (isset($data['district_id']) && $data['district_id'] && !District::find($data['district_id'])) {
      $response->getBody()->write(json_encode([
        'error' => 'El distrito especificado no existe'
      ]));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    if (isset($data['propertytype_id']) && $data['propertytype_id'] && !PropertyType::find($data['propertytype_id'])) {
      $response->getBody()->write(json_encode([
        'error' => 'El tipo de propiedad especificado no existe'
      ]));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    try {
      // Actualizar campos si se proporcionan
      if (isset($data['description'])) {
        $property->description = $data['description'];
      }

      if (isset($data['address'])) {
        $property->address = $data['address'];
      }

      if (isset($data['propertytype_id'])) {
        $property->propertytype_id = $data['propertytype_id'];
      }

      if (isset($data['district_id'])) {
        $property->district_id = $data['district_id'];
      }

      if (isset($data['number'])) {
        $property->number = $data['number'];
      }

      if (isset($data['floor'])) {
        $property->floor = $data['floor'];
      }

      if (isset($data['department_number'])) {
        $property->department_number = $data['department_number'];
      }

      if (isset($data['building_name'])) {
        $property->building_name = $data['building_name'];
      }

      if (isset($data['floors'])) {
        $property->floors = $data['floors'];
      }

      if (isset($data['base_price'])) {
        $property->base_price = $data['base_price'];
      }

      if (isset($data['shown_price'])) {
        $property->shown_price = $data['shown_price'];
      }

      if (isset($data['contract_price'])) {
        $property->contract_price = $data['contract_price'];
      }

      if (isset($data['covered_area'])) {
        $property->covered_area = $data['covered_area'];
      }

      if (isset($data['build_area'])) {
        $property->build_area = $data['build_area'];
      }

      if (isset($data['total_area'])) {
        $property->total_area = $data['total_area'];
      }

      if (isset($data['to_rent'])) {
        $property->to_rent = (bool)$data['to_rent'];
      }

      if (isset($data['to_sell'])) {
        $property->to_sell = (bool)$data['to_sell'];
      }

      if (isset($data['rooms'])) {
        $property->rooms = $data['rooms'];
      }

      if (isset($data['bathrooms'])) {
        $property->bathrooms = $data['bathrooms'];
      }

      if (isset($data['garages'])) {
        $property->garages = $data['garages'];
      }

      if (isset($data['laundries'])){
        $property->laundries = $data['laundries'];
      }

      if (isset($data['water_tanker'])) {
        $property->water_tanker = $data['water_tanker'];
      }

      if (isset($data['yards'])) {
        $property->yards = $data['yards'];
      }

      if (isset($data['year_build'])) {
        $property->year_build = $data['year_build'];
      }

      if (isset($data['is_active'])) {
        $property->is_active = (bool)$data['is_active'];
      }

      $property->updated_by = $currentUserId;
      $property->save();

      $property->load(['propertyType', 'district.province', 'creator', 'updater']);

      $response->getBody()->write(json_encode([
        'success' => true,
        'message' => 'Propiedad actualizada exitosamente',
        'property' => $property
      ]));

      return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
      $response->getBody()->write(json_encode([
        'error' => 'Error al actualizar propiedad: ' . $e->getMessage()
      ]));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
  }

  public function delete(Request $request, Response $response, array $args): Response
  {
    $property = Property::find($args['id']);

    if (!$property) {
      $response->getBody()->write(json_encode(['error' => 'Propiedad no encontrada']));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }

    try {
      $property->delete();

      $response->getBody()->write(json_encode([
        'success' => true,
        'message' => 'Propiedad eliminada exitosamente'
      ]));

      return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
      $response->getBody()->write(json_encode([
        'error' => 'Error al eliminar propiedad: ' . $e->getMessage()
      ]));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
  }

  // Método adicional para obtener estadísticas
  public function stats(Request $request, Response $response): Response
  {
    try {
      $stats = [
        'total_properties' => Property::count(),
        'active_properties' => Property::active()->count(),
        'for_rent' => Property::forRent()->count(),
        'for_sale' => Property::forSale()->count(),
        'by_property_type' => PropertyType::withCount('properties')->get(),
        'average_price' => Property::where('shown_price', '>', 0)->avg('shown_price'),
        'price_range' => [
          'min' => Property::where('shown_price', '>', 0)->min('shown_price'),
          'max' => Property::where('shown_price', '>', 0)->max('shown_price')
        ]
      ];

      $response->getBody()->write(json_encode([
        'stats' => $stats
      ]));

      return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
      $response->getBody()->write(json_encode([
        'error' => 'Error al obtener estadísticas: ' . $e->getMessage()
      ]));
      return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
  }
}
