<?php
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;


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

$router->get('/', function () use ($router) {
    return response()->json('Welcome Hermes API :)', 404);
});

$router->post('/login', 'AuthController@login');

$router->get('/me', ['middleware' => 'auth:api', 'uses' => 'AuthController@me']);

$router->post('/users', ['uses' => 'UserController@create']);
/*
|--------------------------------------------------------------------------
| Lista de Contatos
|--------------------------------------------------------------------------
| Rotas para lista de contatos
*/
# Create
$router->post('/user/{id}/lists', ['middleware' => 'auth:api', 'as' => 'contact-list.create' ,'uses' => 'ContactListController@create']);
// Update
$router->put('/user/{userid}/list/{listaid}', ['middleware' => 'auth:api', 'as' => 'contact-list.updatte' ,'uses' => 'ContactListController@update']);
# Get All
$router->get('/user/{id}/lists', ['middleware' => 'auth:api', 'as' => 'contact-list.get' ,'uses' => 'ContactListController@view']);

/*
|--------------------------------------------------------------------------
| Contatos
|--------------------------------------------------------------------------
| Rotas para contatos
*/
# Create
$router->post('/user/{userid}/list/{listid}/contacts/import', ['middleware' => 'auth:api', 'as' => 'contacts.import' ,'uses' => 'ContactController@create']);
# Get All
$router->get('/list/{listid}/contacts', ['middleware' => 'auth:api', 'as' => 'contacts.all' ,'uses' => 'ContactController@index']);

$router->get('/login/forgot', 'AuthController@forgot');

$router->post('/login/reset/{token}', ['as' => 'password.reset', 'uses' => 'AuthController@reset']);

// $router->get('/mail', function() {
//     Mail::to(['belemlc@gmail.com'])->send(new ResetPassword);

//     return new ResetPassword;
// });

