<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get("/", function () use ($router) {
    return $router->app->version();
});

$router->group(
    [
        "middleware" => "api",
        "prefix" => "auth",
    ],
    function () use ($router) {
        $router->post("login", "AuthController@login");
        $router->post("logout", "AuthController@logout");
        $router->get("me", "AuthController@me");
    }
);

$router->group(
    [
        "middleware" => "api",
        "prefix" => "auth",
    ],
    function ($router) {
        Route::post("login", "AuthController@login");
        Route::post("logout", "AuthController@logout");
        Route::post("refresh", "AuthController@refresh");
        Route::post("me", "AuthController@me");
    }
);

$router->group(["prefix" => "api"], function () use ($router) {
    $router->get("permissions", "PermissionsController@index");
    $router->post("permissions", "PermissionsController@store");
    $router->get("permissions/{id}", "PermissionsController@show");
    $router->put("permissions/{id}", "PermissionsController@update");
    $router->delete("permissions/{id}", "PermissionsController@destroy");

    $router->get("properties", "PropertiesController@index");
    $router->post("properties", "PropertiesController@store");
    $router->get("properties/{id}", "PropertiesController@show");
    $router->put("properties/{id}", "PropertiesController@update");
    $router->delete("properties/{id}", "PropertiesController@destroy");

    $router->get("agents", "AgentsController@index");
    $router->post("agents", "AgentsController@store");
    $router->get("agents/{id}", "AgentsController@show");
    $router->put("agents/{id}", "AgentsController@update");
    $router->delete("agents/{id}", "AgentsController@destroy");

    $router->get("clients", "ClientsController@index");
    $router->post("clients", "ClientsController@store");
    $router->get("clients/{id}", "ClientsController@show");
    $router->put("clients/{id}", "ClientsController@update");
    $router->delete("clients/{id}", "ClientsController@destroy");

    $router->get("features", "FeaturesController@index");
    $router->post("features", "FeaturesController@store");
    $router->get("features/{id}", "FeaturesController@show");
    $router->put("features/{id}", "FeaturesController@update");
    $router->delete("features/{id}", "FeaturesController@destroy");

    $router->get("propertyFeatures", "PropertyFeaturesController@index");
    $router->post("propertyFeatures", "PropertyFeaturesController@store");
    $router->get("propertyFeatures/{id}", "PropertyFeaturesController@show");
    $router->put("propertyFeatures/{id}", "PropertyFeaturesController@update");
    $router->delete(
        "propertyFeatures/{id}",
        "PropertyFeaturesController@destroy"
    );

    $router->get("departments", "DepartmentsController@index");
    $router->post("departments", "DepartmentsController@store");
    $router->get("departments/{id}", "DepartmentsController@show");
    $router->put("departments/{id}", "DepartmentsController@update");
    $router->delete("departments/{id}", "DepartmentsController@destroy");
    $router->get(
        "departments/{department_id}/provinces",
        "DepartmentsController@getProvincesByDepartment"
    );

    $router->get("provinces", "ProvincesController@index");
    $router->post("provinces", "ProvincesController@store");
    $router->get("provinces/{id}", "ProvincesController@show");
    $router->put("provinces/{id}", "ProvincesController@update");
    $router->delete("provinces/{id}", "ProvincesController@destroy");
    $router->get(
        "provinces/{province_id}/districts",
        "ProvincesController@getDistrictsByProvince"
    );

    $router->get("districts", "DistrictsController@index");
    $router->post("districts", "DistrictsController@store");
    $router->get("districts/{id}", "DistrictsController@show");
    $router->put("districts/{id}", "DistrictsController@update");
    $router->delete("districts/{id}", "DistrictsController@destroy");

    //$router->get('propertytypes', 'PropertyTypes@index');

    $router->post("/upload", "FileUploadController@upload");
});
