<?php
header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
	header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\UploadedFileInterface;
use \Firebase\JWT\JWT;
use Slim\Http\UploadedFile;
require 'vendor/autoload.php';
require_once('./db.php');
require_once('./auth.php');


/*
 * turn off errors on prod
 */
$app = new Slim\App([
	'settings' => [
			 'displayErrorDetails' => true
	 ]
]);

$container = $app->getContainer();

$container['upload_directory'] ='../img/';

$app->get('/api/meetups', function ($request, $response, $args) {


  $db = new db();

	$meetups = $db->SELECT_N_COUNT();

	/*
	 * set absolute path
	*/
	$path = 'http://localhost:4040/img/banners/';

	foreach ($meetups as &$meetup) {
		$meetup['img'] = $path . $meetup['img'];
	}

	return $response->getBody()->write(json_encode($meetups));

});

$app->post('/api/auth', function ($request, $response, $args) {

		$db = new db();

		$user = $db->GET_USER_BY_EMAIL($request->getParsedBody());

		if(!$user)
		{
			return;
		}

		$token = Auth::signToken($user);

		$result = [
			"token" => $token
		];

		return $response->getBody()->write(json_encode($result));

});

$app->post('/api/auth/signin', function ($request, $response, $args) {

		$db = new db();

		$token = $request->getParsedBody()['token'];

		$decoded = Auth::decodeToken($token);

		$id = $decoded->{'user_id'};

		$user = $db->GET_USER_BY_ID($id);

		if(!$user)
		{
			return;
		}

		return $response->getBody()->write(json_encode($user));

});

$app->post('/api/auth/signup', function ($request, $response) {

    $db = new db();

    $user = $request->getParsedBody();

		if(!$user)
		{
				return;
		}

  	$id = $db->INSERT_TO_USERS($user);

		$user['user_id'] = $id;



		$token = Auth::signToken($user);

		$result = [
			"token" => $token,
			"user" => $user
		];


		return $response->getBody()->write(json_encode($result));
});

$app->get('/api/meetup/{url}', function ($request, $response, $args) {

    $db = new db();

    $url = $args['url'];


    $result = $db->SELECT_URL('meetups', $url);

		$path = 'http://localhost:4040/img/banners/';


		$result['img'] = $path . $result;
    $result = json_encode($result);

    return $response->getBody()->write($result);
});

$app->get('/api/meetup/{url}/user/{id}', function ($request, $response, $args) {

    $db = new db();

    $url = $args['url'];

		$id = $args['id'];

    $meetup = $db->SELECT_MEETUP_N_COUNT_MEMBERS($url, $id);
    return $response->getBody()->write(json_encode($meetup));
});

$app->get('/api/meetup/{url}/members', function ($request, $response, $args) {
	$db = new db();

	$url = $args['url'];
	$members = $db->GET_MEMBERS($url);

	return $response->getBody()->write(json_encode($members));

});

$app->get('/api/meetup/{url}/discussion', function ($request, $response, $args) {
	$db = new db();

	$url = $args['url'];
	$discussion = $db->GET_DISCUSSION($url);

	return $response->getBody()->write(json_encode($discussion));

});




$app->post('/api/meetup/join', function ($request, $response) {

    $db = new db();

    $data = $request->getParsedBody();

    $db->JOIN_MEETUP($data['meetup_id'], $data['user_id']);

		$status = ['status' => 'ok'];
		return $response->getBody()->write(json_encode($status));


});

$app->post('/api/meetup/create', function ($request, $response) {

    $db = new db();

    $data = $request->getParsedBody();

		var_dump($data);
		$db->CREATE_MEETUP($data);

		$status = ['status' => 'ok'];
		return $response->getBody()->write(json_encode($status));


});

$app->post('/api/meetup/unjoin', function ($request, $response) {

    $db = new db();

    $data = $request->getParsedBody();

    $db->UNJOIN_MEETUP($data['meetup_id'], $data['user_id']);

		$status = ['status' => 'ok'];

		return $response->getBody()->write(json_encode($status));

});

$app->get('/users', function ($request, $response, $args) {

    $db = new db();

    $result = $db->SELECT('users');

    //return $response->getBody()->write(json_encode($result));
});

$app->get('/user/{name}', function ($request, $response, $args) {

    $db = new db();

		$name = $args['name'];

    $result = $db->GET_USER_BY_NAME($name);

		return $response->getBody()->write(json_encode($result));
});

$app->post('/api/user/upload', function ($request, $response) {

				$db = new db();


        $file = $request->getUploadedFiles()['image'];

				$name = $file->getClientFilename();

				$file->moveTo('./img/avatars/' . $name);


				$db->UPDATE_AVATAR(10, $name);
});

$app->get('/api/user/{id}/users-meetups', function ($request, $response, $args) {

  $id = $args['id'];

	$db = new db();

	if(Auth::verifyToken()){
		$result = $db->GET_MEETUPS_BY_USER($id);
	}
	else {
		$result = "No access!";
	}


		return $response->getBody()->write(json_encode($result));

});

$app->post('/api/meetup/add-comment', function ($request, $response) {

    $db = new db();

    $comment = $request->getParsedBody();

		var_dump($comment);
    $db->ADD_COMMENT($comment);

		$status = ['status' => 'ok'];

		return $response->getBody()->write(json_encode($status));

});

$app->get('/api/img/{category}/{path}', function ($request, $response, $args) {

    $db = new db();

    $url = $args;

		$path = 'http://localhost:4040/img/' . $url['category'] . '/' . $url['path'] . '.jpg';

		$img = "<img src='" . $path . "' />";

		echo $img;
});

$app->get('/api/user/{id}/contacts', function ($request, $response, $args) {

    $db = new db();

    $id = $args['id'];

		$contacts = $db->SELECT_CONTACTS($id);

		return $response->getBody()->write(json_encode($contacts));


});


$app->run();
