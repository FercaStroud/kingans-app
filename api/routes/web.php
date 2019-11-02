<?php

use App\PanelUser;
use App\User;
use App\Branch;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

$app->get('/', function (Request $request) {
    echo Hash::make("1");
});

$app->group(['prefix' => 'branches'], function () use ($app) {

    $app->post('/add', function (Request $request) {
        $random_string = function ($length, $directory = '', $extension = '') {
            $dir = !empty($directory) && is_dir($directory) ? $directory : dirname(__FILE__);
            do {
                $key = '';
                $keys = array_merge(range(0, 9), range('a', 'z'));
                for ($i = 0; $i < $length; $i++) {
                    $key .= $keys[array_rand($keys)];
                }
            } while (file_exists($dir . '/' . $key . (!empty($extension) ? '.' . $extension : '')));
            return $key . (!empty($extension) ? '.' . $extension : '');
        };
        $fileName = $random_string(40, '', $request->file('svg')->getClientOriginalExtension());
        $destinationPath = "images/branches/";
        if ($request->file('svg') != null) {
            $request->file('svg')->move($destinationPath, $fileName);
        } else {
            return response()->json(['success' => false]);
        }

        $branch = new Branch();

        $branch->name = $request->get("name");
        $branch->city = $request->get("city");
        $branch->address = $request->get("address");
        $branch->phone = $request->get("phone");
        $branch->scheduling = $request->get("scheduling");
        $branch->map = $request->get("map");
        $branch->facebook = $request->get("facebook");
        $branch->svg = $fileName;
        $branch->created_by = $request->get("created_by");
        $branch->save();

        return $branch;
    });

    $app->post('/edit', function (Request $request) {

        if($request->file("svg") === null){
            $fileName = $request->get("svg");
        } else {
            $random_string = function ($length, $directory = '', $extension = '') {
                $dir = !empty($directory) && is_dir($directory) ? $directory : dirname(__FILE__);
                do {
                    $key = '';
                    $keys = array_merge(range(0, 9), range('a', 'z'));
                    for ($i = 0; $i < $length; $i++) {
                        $key .= $keys[array_rand($keys)];
                    }
                } while (file_exists($dir . '/' . $key . (!empty($extension) ? '.' . $extension : '')));
                return $key . (!empty($extension) ? '.' . $extension : '');
            };
            $fileName = $random_string(40, '', $request->file('svg')->getClientOriginalExtension());
            $destinationPath = "images/branches/";
            if ($request->file('svg') != null) {
                $request->file('svg')->move($destinationPath, $fileName);
            } else {
                return response()->json(['success' => false]);
            }
        }

        $branch = Branch::find($request->get("id"));

        $branch->name = $request->get("name");
        $branch->city = $request->get("city");
        $branch->address = $request->get("address");
        $branch->phone = $request->get("phone");
        $branch->scheduling = $request->get("scheduling");
        $branch->map = $request->get("map");
        $branch->facebook = $request->get("facebook");
        $branch->svg = $fileName;
        $branch->created_by = $request->get("created_by");

        $branch->save();

        return $branch;
    });

    $app->post('/get', function (Request $request) {
        return Branch::all();
    });

    $app->post('/delete', function (Request $request) {
        return response()->json([
            "success" => Branch::find($request->get("id"))->delete()
        ]);
    });

});


$app->group(['prefix' => 'users'], function () use ($app) {
    $app->group(['prefix' => 'panel'], function () use ($app) {

        $app->post('/login', function (Request $request) {
            $user = PanelUser::where(
                'username', '=', $request->get('username')
            )->first();

            if (Hash::check($request->get('password'), $user->password)) {
                return $user;
            } else {
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
