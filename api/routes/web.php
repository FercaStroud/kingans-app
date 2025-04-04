<?php

use App\PanelUser;
use App\User;
use App\Branch;
use App\Survey;
use App\Question;
use App\News;
use App\QuestionAnswer;
use App\UserCoupon;
use App\Answer;
use App\Coupon;
use App\Visit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Str;

$app->get('/', function (Request $request) {
    //echo \Illuminate\Support\Str::random(8);
    //return Hash::make('DEMO');
    return response()->json(['success' => true]);
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
        $branch->wa_url = $request->get("wa_url");
        $branch->menu_url = $request->get("menu_url");
        $branch->instagram = $request->get("instagram");
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
        $branch->instagram = $request->get("instagram");
        $branch->svg = $fileName;
        $branch->wa_url = $request->get("wa_url");
        $branch->menu_url = $request->get("menu_url");
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
                return response()->json(['success' => false]);
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

        $app->post('/edit/password', function (Request $request) {
            $user = PanelUser::find($request->get("id"));

            $user->password = Hash::make($request->get('password'));
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
        $app->get('/excel', function (Request $request) {
            $results = \Illuminate\Support\Facades\DB::table('users')
                ->select(
                    "users.id as ID",
                    "users.name as NOMBRE",
                    "users.phone as TEL",
                    "users.email as EMAIL",
                    "users.city as CIUDAD",
                    "users.gender as GENERO",
                    "users.birthday as CUMPLEANOS",
                    "users.created_at as FECHACREACION"
                )
                ->orderBy('users.id', 'DESC')
                ->get();


            $filename = "Usuarios";
            $i = 0;

            header('HTTP/1.1 200 OK');
            header('Date: ' . date('D M j G:i:s T Y'));
            header('Last-Modified: ' . date('D M j G:i:s T Y'));
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
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


        });
        $app->post('/reset', function (Request $request) {
            $sanitizeEmail = function ($field) {
                $field = filter_var($field, FILTER_SANITIZE_EMAIL);
                if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
                    return true;
                } else {
                    return false;
                }
            };

            $user = User::where(
                'phone', '=', $request->get('phone')
            )->first();
            $pwd = Str::random(8);
            $to_email = $user->email;

            $subject = 'Kingans App- Restablecer Contraseña';
            $message = 'Hola, tu contraseña temporal es: ' . $pwd;
            $headers = 'From: noreply@kingans.com';

            $secure_check = $sanitizeEmail($to_email);
            if ($secure_check == false) {
                return response()->json(['success' => false]);

            } else { //send email
                if (mail($to_email, $subject, $message, $headers)) {
                    $user->password = Hash::make($pwd);
                    $user->save();

                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false]);
                }
            }


        });
        $app->post('/login', function (Request $request) {
            $user = User::where(
                'phone', '=', $request->get('phone')
            )->first();

            if (Hash::check($request->get('password'), $user->password)) {
                return $user;
            } else {
                return response()->json(['success' => false]);
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
            $user->updated_by = $request->get("updated_by");
            $user->save();

            return $user;
        });
        $app->post('/edit/password', function (Request $request) {
            $user = User::find($request->get("id"));

            $user->password = Hash::make($request->get('password'));
            $user->save();
            return $user;
        });
        $app->post('/edit/birthday', function (Request $request) {
            $user = User::find($request->get("id"));

            $user->birthday = $request->get('birthday');
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
        $app->post('/visit/log', function (Request $request) {
            $user = User::find($request->get("user_id"));

            $visit = Visit::where([
                "user_id" => $user->id,
                "checked" => 0
            ])->whereDate(
                'created_at',
                \Carbon\Carbon::today()
            )->first();

            if (is_object($visit)) {
                if ($visit->checked == 0) {
                    $visit->checked = 1;
                    $visit->save();
                }
            }

            return $visit;
        });
        $app->post('/visit-coupon', function (Request $request) {
            $user = User::find($request->get("user_id"));

            $visitCount = Visit::where(
                "user_id", "=", $request->get("user_id")
            )->get()->count();

            $coupon = null;
            $temp = 0;
            foreach (Coupon::where("required_number", "<=", $visitCount)->get() as $item) {
                if ($item->required_number > $temp) {
                    $coupon = $item;
                } else {
                    $temp = $item->required_number;
                }
            }

            return $coupon;
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
        return Survey::where("is_active", "=", "1")->get();
    });
    $app->post('/get/all', function () {
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
        if ($request->has("user_id")) {
            return \Illuminate\Support\Facades\DB::table("visits")->where(
                "user_id", "=", $request->get("user_id")
            )->get()->count();

        } else {
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
            )->leftJoin("users", "users.id", "=", "visits.user_id")
                ->leftJoin("panel_users", "panel_users.id", "=", "visits.created_by")
                ->leftJoin("branches", "branches.id", "=", "panel_users.branch_id")->get();
        }
    });
    $app->post('/add', function (Request $request) {

        $user = User::where(
            'phone', '=',
            $request->get('phone')
        )->first();

        $visit = Visit::where(
            "user_id",
            "=", $user->id
        )->whereDate(
            'created_at',
            \Carbon\Carbon::today()
        )->first();

        if (!is_object($visit)) {
            $visit = new Visit();
            $visit->user_id = $user->id;
            $visit->created_by = $request->get("created_by");
            $visit->save();
        } else {
            $visit = null;
        }

        return $visit;
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

    $app->post('/withAnswers', function (Request $request) {
        $surveyId = $request->get('id');
        $survey = Survey::where([
            'id' => $surveyId,
        ])->get();

        $response = [
            'survey_id' => $survey[0]->id,
            'name' => $survey[0]->name,
            'description' => $survey[0]->description,
            'questions' => []
        ];
        foreach (
            Question::where(
                'questions.survey_id', '=', $surveyId
            )->get() as $question
        ) {
            array_push($response['questions'],
                [
                    'question_id' => $question->id,
                    'title' => $question->title,
                    'type' => $question->type,
                    'vModel' => '*Selecciona una respuesta',
                    'answers' => \Illuminate\Support\Facades\DB::table('answers')
                        ->where(
                            'answers.question_id', '=', $question->id
                        )->get()
                ]
            );
        }
        return response()->json($response);
    });
});

$app->group(['prefix' => 'question-answers'], function () use ($app) {
    $app->group(['prefix' => 'app'], function () use ($app) {
        $app->post('/add', function (Request $request) {
            $questions = $request->get("questions");
            $surveyId = $request->get("survey_id");
            $ok = true;
            foreach ($questions as $question) {
                $ok = \Illuminate\Support\Facades\DB::table('question_answer')->insert([
                    'answer_id' => $question['vModel'],
                    'question_id' => $question['question_id'],
                    'survey_id' => $surveyId,
                    'other' => $question['vModel'],
                    'panel_user_created_by' => $request->get("panel_user_created_by", null),
                    'user_created_by' => $request->get("user_created_by", null),
                ]);
                if ($ok === false) {
                    return response()->json(['success' => false]);
                }
            }
            return response()->json(['success' => true]);
        });

    });

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
                    "question_answer.other as Otro",
                    "question_answer.created_at as Fecha",
                    "panel_users.username as 'Nombre Usuario Panel'",
                    "panel_users.name as 'Nombre Completo Usuario Panel'",
                    "users.name as 'Nombre Completo Usuario App'",
                    "users.phone as 'Usuario App Tel'"
                )->leftJoin("answers", "answers.id", "=", "question_answer.answer_id")
                ->leftJoin("questions", "questions.id", "=", "question_answer.question_id")
                ->leftJoin("surveys", "surveys.id", "=", "question_answer.survey_id")
                ->leftJoin("users", "users.id", "=", "question_answer.user_created_by")
                ->leftJoin("panel_users", "panel_users.id", "=", "question_answer.panel_user_created_by")
                ->where("question_answer.survey_id", "=", $request->get("survey_id"))
                ->orderBy('question_answer.id', 'DESC')->get();
            $filename = $results[0]->Encuesta;
            $i = 0;

            header('HTTP/1.1 200 OK');
            header('Date: ' . date('D M j G:i:s T Y'));
            header('Last-Modified: ' . date('D M j G:i:s T Y'));
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=$filename.xls");

            header("Pragma: no-cache");
            header("Expires: 0");

            foreach ($results as $result) {
                if ($i > 0) {
                    break;
                }
                foreach ($result as $key => $item) {
                    echo preg_replace('/[^A-Za-z0-9 ]/', '', $key) . "\t";
                    $i++;
                }
            }
            print("\n");
            foreach ($results as $row) {
                foreach ($row as $key => $item) {
                    echo preg_replace('/[^A-Za-z0-9 ]/', '', $item) . "\t";
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
    $app->post('/exchange', function (Request $request) {
        $betweenDates = function ($cmpDate, $startDate, $endDate) {
            return (date($cmpDate) >= date($startDate)) && (date($cmpDate) < date($endDate));
        };

        $user = User::where("phone", "=", $request->get("phone"))->first();
        $coupon = Coupon::where("code", "=", $request->get("code"))->first();

        //is date valid?
        $now = new DateTime('now');
        if ($betweenDates($now->format("Y-m-d"), $coupon->start, $coupon->end)) {
            //use cant repeat coupon
            if (is_object(
                UserCoupon::where([
                    "user_id" => $user->id, "coupon_id" => $coupon->id
                ])->first()
            )) {
                return response()->json([
                    "text" => "Un canje de código por usuario.",
                    "title" => "Código canjeado con anterioridad."
                ]);
            } else {
                //one at day
                if (is_object(
                    UserCoupon::where([
                        "user_id" => $user->id
                    ])->whereDate(
                        'created_at', \Carbon\Carbon::today()
                    )->first()
                )) {
                    return response()->json([
                        "text" => "Un canje al día por usuario.",
                        "title" => "El usuario ya ha canjeado con anterioridad."
                    ]);
                } else {
                    //can user get a gift?
                    $counter = Visit::where('user_id', '=', $user->id)->count();
                    if ($counter >= $coupon->required_number) {
                        $object = new UserCoupon();
                        $object->user_id = $user->id;
                        $object->coupon_id = $coupon->id;
                        $object->created_by = $request->get("created_by");
                        $object->save();

                        return $coupon;
                    } else { //false
                        return response()->json([
                            "text" => "El usuario no cuenta con los puntos requeridos.",
                            "title" => "Sin puntaje necesario."
                        ]);
                    }
                }
            }
        } else {
            return response()->json([
                "text" => "Error al canjear, cupón no válido.",
                "title" => "Cupón expirado."
            ]);
        }

    });
    $app->post('/exchanges', function () {
        return UserCoupon::select([
            "users.id as user_id",
            "users.name as user_name",
            "users.phone as user_phone",
            "users.email as user_email",
            "users.city as user_city",
            "users.gender as user_gender",
            "users.birthday as user_birthday",
            "coupons.code as coupon_code",
            "panel_users.name as created_by",
            "user_coupons.created_at"
        ])->leftJoin(
            "users", "users.id", "=", "user_coupons.user_id"
        )->join(
            "coupons", "coupons.id", "=", "user_coupons.coupon_id"
        )->join(
            "panel_users", "panel_users.id", "=", "user_coupons.created_by"
        )->get();
    });
    $app->post('/get', function (Request $request) {

        $coupons = Coupon::select(
            [
                'coupons.id',
                'coupons.name',
                'coupons.description',
                'branches.name as branch_name',
                'branches.id as branch_id',
                'coupons.code',
                'coupons.src',
                'coupons.required_number',
                'coupons.start',
                'coupons.end',
            ]
        )->leftJoin(
            "branches",
            "branches.id", "=", "coupons.branch_id")->get();

        if ($request->has("user_id")) {
            $userCoupons = UserCoupon::select([
                    'coupons.id',
                    'coupons.name',
                    'coupons.description',
                    'branches.name as branch_name',
                    'branches.id as branch_id',
                    'coupons.code',
                    'coupons.src',
                    'coupons.required_number',
                    'coupons.start',
                    'coupons.end',
                ]
            )->leftJoin("coupons", "coupons.id", "=", "user_coupons.coupon_id")
                ->leftJoin(
                    "branches",
                    "branches.id", "=", "coupons.branch_id")
                ->where([
                    ["user_coupons.user_id", "=", $request->get("user_id")],
                ])->whereNull("coupons.deleted_at")
                ->get();

            $i = 0;

            $coupons = $coupons->toArray();
            $userCoupons = $userCoupons->toArray();

            foreach ($coupons as $coupon){
                foreach ($userCoupons as $userCoupon) {
                    if($coupon === $userCoupon){
                        unset($coupons[$i]);
                    }
                }
                $i++;
            }


            return $coupons;
        } else {
            return $coupons;
        }
    });
    $app->post('/delete', function (Request $request) {
        return response()->json([
            "success" => Coupon::find($request->get("id"))->delete()
        ]);
    });
    $app->post('/add', function (Request $request) {
        $object = new Coupon();

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
        $fileName = $random_string(40, '', $request->file('src')->getClientOriginalExtension());
        $destinationPath = "images/coupons/";
        if ($request->file('src') != null) {
            $request->file('src')->move($destinationPath, $fileName);
        } else {
            return response()->json(['success' => false]);
        }

        $object->name = $request->get("name");
        $object->description = $request->get("description");
        $object->code = $request->get("code");
        $object->required_number = $request->get("required_number");
        $object->start = $request->get("start");
        $object->end = $request->get("end");
        $object->created_by = $request->get("created_by");
        $object->branch_id = $request->get("branch_id");
        $object->src = $fileName;
        $object->save();

        return $object;
    });
    $app->post('/edit', function (Request $request) {
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
        $destinationPath = "images/coupons/";

        $object = Coupon::find($request->get("id"));
        $fileName = $object->src;

        if ($request->file('src') !== null) {
            $fileName = $random_string(40, '', $request->file('src')->getClientOriginalExtension());
            $request->file('src')->move($destinationPath, $fileName);
        }

        $object->name = $request->get('name', $object->name);
        $object->branch_id = $request->get('branch_id', $object->branch_id);
        $object->description = $request->get('description', $object->description);
        $object->code = $request->get('code', $object->code);
        $object->required_number = $request->get('required_number', $object->required_number);
        $object->start = $request->get('start', $object->start);
        $object->end = $request->get('end', $object->end);
        $object->updated_by = $request->get("updated_by");
        $object->src = $fileName;
        $object->save();

        return $object;
    });
});

$app->group(['prefix' => 'news'], function () use ($app) {
    $app->post('/get', function (Request $request) {
        if ($request->has("branch_id")) {
            return News::where(function ($q) use ($request) {
                $q->where('branch_id', $request->get("branch_id"))
                    ->orWhere('branch_id', 0);
            })->orderBy("created_at", "desc")
                ->leftJoin('branches', 'branches.id', '=', 'news.branch_id')
                ->get();
        } else {
            return News::leftJoin('branches', 'branches.id', '=', 'news.branch_id')->get();
        }
    });
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
        $fileName = $random_string(40, '', $request->file('src')->getClientOriginalExtension());
        $destinationPath = "images/news/";
        if ($request->file('src') != null) {
            $request->file('src')->move($destinationPath, $fileName);
        } else {
            return response()->json(['success' => false]);
        }


        $item = new News();
        $item->branch_id = $request->get("branch_id", 0);
        $item->created_by = $request->get("user_id", 0);
        $item->title = $request->get("title", "SIN TÍTULO");
        $item->src = $fileName;
        $item->save();

        return $item;
    });
    $app->post('/delete', function (Request $request) {
        return response()->json([
            "success" => News::find($request->get("id"))->delete()
        ]);
    });
});
