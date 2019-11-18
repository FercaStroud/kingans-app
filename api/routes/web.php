<?php

use App\PanelUser;
use App\User;
use App\Branch;
use App\Survey;
use App\Question;
use App\Answer;
use App\Coupon;

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
        $branch->updated_by = $request->get("updated_by");

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
                if ($value->created_by != null) {
                    $users[$key]->created_by = PanelUser::find($value->created_by);
                }
                if ($value->updated_by != null) {
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
            $user->name = $request->get('name', $user->name);
            $user->email = $request->get('email', $user->email);
            $user->city = $request->get('city', $user->city);
            $user->gender = $request->get('gender', $user->gender);
            $user->birthday = $request->get('birthday', $user->birthday);
            $user->updated_by = $request->get("updated_by");
            $user->save();

            return $user;
        });

        $app->post('/get', function () {
            $users = User::all();
            foreach ($users as $key => $value) {
                if ($value->created_by != null) {
                    $users[$key]->created_by = PanelUser::find($value->created_by);
                }
                if ($value->updated_by != null) {
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

$app->group(['prefix' => 'surveys'], function () use ($app) {

    $app->post('/add', function (Request $request) {
        $object = new Survey();

        $object->name = $request->get("name");
        $object->description = $request->get("description");
        $object->is_active = $request->get("is_active", 0);
        $object->created_by = $request->get("created_by");
        $object->save();

        return $object;
    });
    $app->post('/edit', function (Request $request) {
        $object = Survey::find($request->get("id"));

        $object->name = $request->get("name");
        $object->description = $request->get("description");
        $object->updated_by = $request->get("updated_by");
        $object->is_active = $request->get("is_active", 0);
        $object->save();

        return $object;
    });
    $app->post('/get', function () {
        return Survey::all();
    });
    $app->post('/status', function (Request $request) {
        $survey = Survey::find($request->get('id'));
        $survey->is_active = $request->get('is_active');
        $survey->save();

        return $survey;
    });
    $app->post('/delete', function (Request $request) {
        return response()->json([
            "success" => Survey::find($request->get("id"))->delete()
        ]);
    });

});

$app->group(['prefix' => 'answers'], function () use ($app) {
    $app->post('/get', function (Request $request) {
        return Answer::where(
            "question_id", "=", $request->get("question_id")
        )->get();
    });
});

$app->group(['prefix' => 'visits'], function () use ($app) {
    $app->post('/get', function (Request $request) {

        return \Illuminate\Support\Facades\DB::table("visits")->select(
            [
                "visits.created_at",
                "visits.created_by",
                "branches.name as branch_name",
                "users.name as user_name",
                "users.phone as user_phone",
                "users.email as user_email",
                "users.city as user_city",
                "users.gender as user_gender",
                "users.birthday as user_birthday",
            ]
        )->join("users", "users.id", "=", "visits.user_id")
            ->join("panel_users", "panel_users.id", "=", "visits.created_by")
            ->join("branches", "branches.id", "=", "panel_users.branch_id")->get();

    });
});

$app->group(['prefix' => 'questions'], function () use ($app) {

    $app->post('/get', function (Request $request) {
        return Question::where(
            "survey_id", "=", $request->get("survey_id")
        )->get();
    });

    $app->post('/delete', function (Request $request) {
        return response()->json([
            "success" => Question::find($request->get("id"))->delete()
        ]);
    });

});

$app->group(['prefix' => 'question-answers'], function () use ($app) {
    $app->post('/add', function (Request $request) {
        $question = new Question();

        $question->survey_id = $request->get("survey_id");
        $question->type = $request->get("type");
        $question->title = $request->get("title");

        $question->save();

        if ($request->get('type') != 'TEXT') {
            foreach ($request->get('answers') as $item) {
                $answer = new Answer();
                $answer->question_id = $question->id;
                $answer->title = $item['body'];
                $answer->save();
            }
        }

        return $question;
    });
    $app->get('/excel', function (Request $request) {
        try {
            $results = \Illuminate\Support\Facades\DB::table('question_answer')
                ->select(
                    "surveys.name as Encuesta",
                    "questions.title as Pregunta",
                    "answers.title as Respuesta",
                    "questions.type as Tipo",
                    "question_answer.other as Otro"
                )->leftJoin("answers", "answers.id", "=", "question_answer.answer_id")
                ->leftJoin("questions", "questions.id", "=", "question_answer.question_id")
                ->leftJoin("surveys", "surveys.id", "=", "question_answer.survey_id")
                ->where("question_answer.survey_id", "=", $request->get("survey_id"))
                ->orderBy('question_answer.id', 'DESC')->get();
            $filename = $results[0]->Encuesta;
            $i = 0;
            header("Content-Type: application/xls;charset=utf-8");
            header("Content-Disposition: attachment; filename=$filename.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            foreach ($results as $result) {
                if ($i > 0) {
                    break;
                }
                foreach ($result as $key => $item) {
                    echo $key . "\t";
                    $i++;
                }
            }
            print("\n");
            foreach ($results as $row) {
                foreach ($row as $key => $item) {
                    echo $item . "\t";
                }
                print("\n");
            }
        } catch (exception $e) {
            echo "<strong style='font-size: 1.4em;font-family: sans-serif;'>SIN RESPUESTAS</strong><br/>";
            echo "<span style='font-size: 1.4em;font-family: sans-serif;color:darkred'>NO SE PUEDE GENERAR ARCHIVO</span>";
        }
    });

});


$app->group(['prefix' => 'coupons'], function () use ($app) {

    $app->post('/get', function (Request $request) {
        return Coupon::select(
            [
                'coupons.id',
                'coupons.name',
                'coupons.description',
                'branches.name as branch_name',
                'coupons.code',
                'coupons.required_number',
                'coupons.start',
                'coupons.end',
            ]
        )->leftJoin(
            "branches",
            "branches.id", "=", "coupons.branch_id")
            ->get();
    });

    $app->post('/delete', function (Request $request) {
        return response()->json([
            "success" => Coupon::find($request->get("id"))->delete()
        ]);
    });

    $app->post('/add', function (Request $request) {
        $object = new Coupon();

        $object->name = $request->get("name");
        $object->description = $request->get("description");
        $object->code = $request->get("code");
        $object->required_number = $request->get("required_number");
        $object->start = $request->get("start");
        $object->end = $request->get("end");
        $object->created_by = $request->get("created_by");
        $object->branch_id = $request->get("branch_id");
        $object->save();

        return $object;
    });
});