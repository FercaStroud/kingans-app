<?php

use App\PanelUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$app->get('/session/current', function (Request $request) {
    return $_SESSION;
});

$app->group(['prefix' => 'api'], function () use ($app) {
    $app->group(['prefix' => 'user'], function () use ($app) {

        $app->post('/isLogged/', function () {
            if (isLogged()) {
                return $_SESSION['user'];
            } else {
                return response()->json(['success' => false]);
            }
        });

        $app->post('/logout/', function () {
            session_unset();
            return $_SESSION;
        });
    });
});

$app->group(['prefix' => 'panel'], function () use ($app) {
    $app->group(['prefix' => 'user'], function () use ($app) {

        $app->post('/login', function (Request $request) {
            $user = PanelUser::where(
                'username', '=', $request->get('username')
            )->first();

            if (Hash::check($request->get('password'), $user->password)) {
                $_SESSION['user'] = $user;
                return $_SESSION['user'];
            } else {
                $_SESSION['user'] = null;
                response()->json(['success' => false]);
            }
        });

    });
});

$app->group(['prefix' => 'app'], function () use ($app) {
    $app->group(['prefix' => 'user'], function () use ($app) {

        $app->post('/login', function (Request $request) {
            $user = User::where(
                'phone', '=', $request->get('phone')
            )->first();

            if (Hash::check($request->get('password'), $user->password)) {
                $_SESSION['user'] = $user;
                return $_SESSION['user'];
            } else {
                $_SESSION['user'] = null;
                response()->json(['success' => false]);
            }
        });

    });
});

function isLogged()
{
    return !isset($_SESSION['user']) ? false : true;
}