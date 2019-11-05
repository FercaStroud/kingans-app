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

        if ($request->file("svg") === null) {
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

    $app->post('/get', function () {
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

        $app->post('/add', function (Request $request) {
            $user = new PanelUser();

            $user->username = $request->get('username');
            $user->name = $request->get('name');
            $user->branch_id = $request->get('branch_id');
            $user->type = $request->get('type');
            $user->password = Hash::make($request->get('password'));
            $user->created_by = $request->get("created_by");
            $user->save();

            return $user;
        });

        $app->post('/edit', function (Request $request) {
            $user = PanelUser::find($request->get("id"));

            $user->username = $request->get('username', $user->username);
            $user->name = $request->get('name', $user->name);
            $user->branch_id = $request->get('branch_id', $user->branch_id);
            $user->type = $request->get('type', $user->type);
            $user->updated_by = $request->get("updated_by");
            $user->save();

            return $user;
        });

        $app->post('/get', function () {
            $users = PanelUser::all();
            foreach ($users as $key => $value) {
                $users[$key]->{"branch"} = Branch::find($value->branch_id);
                if($value->created_by != null) {
                    $users[$key]->created_by = PanelUser::find($value->created_by);
                }
                if($value->updated_by != null) {
                    $users[$key]->updated_by = PanelUser::find($value->updated_by);
                }
            }
            return $users;
        });

        $app->post('/delete', function (Request $request) {
            return response()->json([
                "success" => PanelUser::find($request->get("id"))->delete()
            ]);
        });

    });
    $app->group(['prefix' => 'app'], function () use ($app) {

        $app->post('/login', function (Request $request) {
            $user = User::where(
                'phone', '=', $request->get('phone')
            )->first();

            if (Hash::check($request->get('password'), $user->password)) {
                return $user;
            } else {
                response()->json(['success' => false]);
            }
        });

        $app->post('/add', function (Request $request) {
            $user = new User();

            $user->phone = $request->get('phone');
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->city = $request->get('city');
            $user->gender = $request->get('gender');
            $user->birthday = $request->get('birthday');
            $user->password = Hash::make($request->get('password'));
            $user->created_by = $request->get("created_by");
            $user->save();

            return $user;
        });

        $app->post('/edit', function (Request $request) {
            $user = User::find($request->get("id"));

            $user->phone = $request->get('phone', $user->phone);
            $user->name = $request->get('name',$user->name);
            $user->email = $request->get('email',$user->email);
            $user->city = $request->get('city',$user->city);
            $user->gender = $request->get('gender', $user->gender);
            $user->birthday = $request->get('birthday', $user->birthday);
            $user->updated_by = $request->get("updated_by");
            $user->save();

            return $user;
        });

        $app->post('/get', function () {
            $users = User::all();
            foreach ($users as $key => $value) {
                if($value->created_by != null) {
                    $users[$key]->created_by = PanelUser::find($value->created_by);
                }
                if($value->updated_by != null) {
                    $users[$key]->updated_by = PanelUser::find($value->updated_by);
                }
            }
            return $users;
        });

        $app->post('/delete', function (Request $request) {
            return response()->json([
                "success" => User::find($request->get("id"))->delete()
            ]);
        });

    });
});
