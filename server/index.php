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
require_once('./Db.php');
require_once('./auth.php');

/*
 * turn off errors on prod
 */
$app = new Slim\App([
	'settings' => [
			 'displayErrorDetails' => true
	 ]
]);

Db::init();

$app->get('/api/meetups', function ($request, $response, $args) {


$meetups = Db::SELECT_N_COUNT();


	// set absolute path

	$path = 'http://localhost:4040/img/banners/';

	foreach ($meetups as &$meetup) {
		$meetup['img'] = $path . $meetup['img'];
	}

	return $response->getBody()->write(json_encode($meetups));

});

$app->post('/api/auth', function ($request, $response, $args) {

		$user = Db::GET_USER_BY_EMAIL($request->getParsedBody());

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

		$token = $request->getParsedBody()['token'];

		$decoded = Auth::decodeToken($token);

		$id = $decoded->{'user_id'};

		$user = Db::GET_USER_BY_ID($id);

		if(!$user)
		{
			return;
		}

		return $response->getBody()->write(json_encode($user));
});


$app->post('/api/user/contacts', function ($request, $response) {

		$contact = $request->getParsedBody();

		$result = Db::INSERT_TO_CONTACTS($contact);

		return $response->getBody()->write(json_encode($result));
});

$app->post('/api/user/contacts/edit', function ($request, $response) {

	$contact = $request->getParsedBody();

	$result = Db::UPDATE_CONTACTS($contact);

	return $response->getBody()->write(json_encode($result));
});

$app->post('/api/user/contacts/delete', function ($request, $response) {

	$contact = $request->getParsedBody();

	$result = Db::DELETE_CONTACT($contact);

	return $response->getBody()->write(json_encode($result));
});

$app->post('/api/auth/signup', function ($request, $response) {

		$user = $request->getParsedBody();

		$id = Db::INSERT_TO_USERS($user);

		$user = ["user_id" => $id];

		$token = Auth::signToken($user);

		$result = ["token" => $token];

		return $response->getBody()->write(json_encode($result));
});

$app->get('/api/meetup/{url}', function ($request, $response, $args) {

    $url = $args['url'];

    $result = Db::SELECT_URL('meetups', $url);
	/*
		$path = 'http://localhost:4040/img/banners/';


		$result['img'] = $path . $result;*/
    $result = json_encode($result);

    return $response->getBody()->write($result);
});

$app->get('/api/meetup/{url}/user/{id}', function ($request, $response, $args) {

    $url = $args['url'];

		$id = $args['id'];

    $meetup = Db::SELECT_MEETUP_N_COUNT_MEMBERS($url, $id);

    return $response->getBody()->write(json_encode($meetup));
});

$app->get('/api/meetup/{url}/members', function ($request, $response, $args) {

	$url = $args['url'];

	$members = Db::GET_MEMBERS($url);

	return $response->getBody()->write(json_encode($members));
});

$app->get('/api/meetup/{url}/discussion', function ($request, $response, $args) {

	$url = $args['url'];

	$discussion = Db::GET_DISCUSSION($url);

	return $response->getBody()->write(json_encode($discussion));
});




$app->post('/api/meetup/join', function ($request, $response) {

    $data = $request->getParsedBody();

    Db::JOIN_MEETUP($data['meetup_id'], $data['user_id']);

		$status = ['status' => 'ok'];

		return $response->getBody()->write(json_encode($status));
});

$app->post('/api/meetup/create', function ($request, $response) {

    $data = $request->getParsedBody();

		Db::CREATE_MEETUP($data);

		$status = ['status' => 'ok'];

		return $response->getBody()->write(json_encode($status));
});

$app->post('/api/meetup/unjoin', function ($request, $response) {

    $data = $request->getParsedBody();

    Db::UNJOIN_MEETUP($data['meetup_id'], $data['user_id']);

		$status = ['status' => 'ok'];

		return $response->getBody()->write(json_encode($status));
});

$app->get('/users', function ($request, $response, $args) {

    $result = Db::SELECT('users');

    //return $response->getBody()->write(json_encode($result));
});

$app->get('/user/{name}', function ($request, $response, $args) {

		$name = $args['name'];

    $result = Db::GET_USER_BY_NAME($name);

		return $response->getBody()->write(json_encode($result));
});

$app->post('/api/user/upload', function ($request, $response) {

        $file = $request->getUploadedFiles()['image'];

				$name = $file->getClientFilename();

				$file->moveTo('./img/avatars/' . $name);

				Db::UPDATE_AVATAR(10, $name);
});

$app->get('/api/user/{id}/users-meetups', function ($request, $response, $args) {

  $id = $args['id'];

	if(Auth::verifyToken()){
		$result = Db::GET_MEETUPS_BY_USER($id);
	}
	else {
		$result = "No access!";
	}


		return $response->getBody()->write(json_encode($result));
});

$app->post('/api/meetup/add-comment', function ($request, $response) {

    $comment = $request->getParsedBody();

    Db::ADD_COMMENT($comment);

		$status = ['status' => 'ok'];

		return $response->getBody()->write(json_encode($status));
});

$app->get('/api/img/{category}/{path}', function ($request, $response, $args) {

    $url = $args;

		$path = 'http://localhost:4040/img/' . $url['category'] . '/' . $url['path'] . '.jpg';

		$img = "<img src='" . $path . "' />";

		echo $img;
});

$app->get('/api/user/{id}/contacts', function ($request, $response, $args) {

    $db = new db();

    $id = $args['id'];

		$contacts = Db::SELECT_CONTACTS($id);

		return $response->getBody()->write(json_encode($contacts));
});

$app->get('/api/contact-type', function ($request, $response, $args) {

	$contactType = Db::SELECT_CONTACT_TYPE();

	return $response->getBody()->write(json_encode($contactType));
});

$app->get('/api/user/{id}/organized-meetups', function ($request, $response, $args) {

	$id = $args['id'];

	$meetups = Db::GET_ORGANIZED_MEETUPS($id);

	return $response->getBody()->write(json_encode($meetups));
});

$app->post('/api/meetup/edit', function ($request, $response) {

	$meetup = $request->getParsedBody();

	$result = Db::EDIT_MEETUP($meetup);

	return $response->getBody()->write(json_encode($result));
});

$app->run();
