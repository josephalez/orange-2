<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get("/sale/{id}", "SaleController@find");//AQUI obtiene los comentarios
//Route::get("/sale/line/{id}", "SaleController@lines");


Route::group(['middleware' => ['JwtMiddleware']], function () {

  Route::get("/dashboard", "SaleController@dashboard");
  //Route::get("/sale/{id}", "SaleController@find");

  Route::get('/equipment/{id}', 'EquipmentController@find');
  Route::get('/equipments', 'EquipmentController@getAll');
  Route::get('/promotion/{id}', 'PromotionController@find');
  Route::get('/promotions', 'PromotionController@getAll');
  Route::get('/promotions/pages', 'PromotionController@paginate');
  Route::get('/equipments/pages', 'EquipmentController@paginate');

  //Rutas especiales
  Route::get('/rut/{rut}', 'ClientController@findRut');

  //Rutas propias
  Route::get('/me', 'UsersController@me');
  Route::post('/me/edit', 'UsersController@profileEdit'); //Editar mi perfil... ponerla en PUT /me

  //Informacion publica (para autenticados)
  Route::get('/users', 'UsersController@getAll');
  Route::get("/user/{slug}", "UsersController@getUser");
  Route::get("/users/extra/{id}", "UsersController@getOne");
  Route::post('/user/edit', 'UsersController@profileEdit');//<--- clon de "me/edit" ?

  //Modulo de eventos
  Route::post('/event', 'EventController@createEvent');
  Route::get('/events', 'EventController@getEvents');
  Route::put('/event/{id}', 'EventController@eventState');
  Route::delete('/event/{id}', 'EventController@removeEvent');
  Route::get("/events/list", "EventController@paginate");
  Route::get('/events/view', 'EventController@viewEvents');

  //Planes
  Route::get('/plan/{id}', 'PlanController@find');
  Route::get('/plans', 'PlanController@getAll');

  Route::get("/substates", "SubstateController@get");
  Route::get("/states", "StateController@get");

  Route::group(["middleware" => ["role:ejecutivo,supervisor,backoffice,backoffice_general"]], function () {
    Route::post('/sale', 'SaleController@createSale');
    Route::get("/sales/list", "SaleController@paginate");
    //Route::get("/sale/pdf/{id}", "SaleController@exportToPDF");
    Route::put("/sale/line/cancel/{id}", "LineController@CancelLine");
    Route::put("/sale/state/line/{line}", "LineController@changeSubstate");
    Route::get("/sale/{sale}/{substate}", "SaleController@changeSubState");
  });
  //Ventas

  Route::group(["middleware" => ["isOwner:sales"]], function(){
    Route::put("/sale/{id}", "SaleController@updateSale");
    Route::put("/sale/detail/{id}", "SaleController@detailEdit");
    Route::get("/sale/permission/{id}", "SaleController@find");
  });

  Route::group(["middleware" => ["isOwner:sales,true"]], function(){
    Route::post("/comments/{sell}", "CommentController@store");
    Route::get("/sale/{id}", "SaleController@find");
    Route::post("/operate/sale/{saleID}/{to}", "SaleController@sendTo");
  });

  Route::group(['middleware' => ['role:rrhh']], function () {

    Route::post('/rrhh/createUser', 'UsersController@createUser'); //Crea un nuevo usuario
    Route::put('/rrhh/editUser/{id}', 'UsersController@editUserRRHH');
    Route::get("/users/list", "UsersController@usersList"); //Enlista los usuarios

  });

  Route::group(['middleware' => ['role:bodega']], function () {

    Route::get('/plans/pages', 'PlanController@paginate');
    Route::post('/plans', 'PlanController@store');
    Route::put('/plan/{id}', 'PlanController@update');
    Route::delete('/plan/{id}', 'PlanController@destroy');

    Route::post('/equipments', 'EquipmentController@store');
    Route::put('/equipment/{id}', 'EquipmentController@update');
    Route::delete('/equipment/{id}', 'EquipmentController@destroy');

    Route::post('/promotions', 'PromotionController@store');
    Route::put('/promotion/{id}', 'PromotionController@update');
    Route::delete('/promotion/{id}', 'PromotionController@destroy');

    Route::post('/stock/import', 'StockController@import');
    Route::get('/stock/pages', 'StockController@paginate');

    Route::get('/excel/download/{id}', 'ExcelController@download');
    Route::get('/excels', 'ExcelController@getAll');
    Route::get('/excel/pages', 'ExcelController@paginate');
    Route::get('/excel/{id}', 'ExcelController@find');

  });

});
Route::get("/sale/pdf/{id}", "SaleController@exportToPDF"); //Esto hay que arreglarlo para que se pueda descargar estando adentro del middleware
//Informacion publica
Route::get('/regions', 'RegionController@getRegions');
Route::get('/communes', 'CommuneController@getCommunes');

//Rutas necesarias para obtener autenticacion
Route::post('/login', 'Auth\LoginController@enter');
Route::post("/register","Auth\RegisterController@create");
Route::get("/verify-email/{verifyToken}","UsersController@verifyEmail");
