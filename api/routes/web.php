<?php

use Illuminate\Http\Request;

/*$app->get('/', function (Request $request) {
    echo sha1("ObservatorioLaguna!?123");
    //echo sha1("1");
});*/

$app->get('/questions/get', function (Request $request) {
    return \Illuminate\Support\Facades\DB::table('app_questions')
        ->where("survey_id", "=", $request->get("id"))
        ->orderBy('id', 'DESC')->get();
});

$app->get('/excel', function (Request $request) {
    try {
        $results = \Illuminate\Support\Facades\DB::table('app_question_answer')
            ->select(
                "app_surveys.title as Encuesta",
                "app_questions.title as Pregunta",
                "app_answers.title as Respuesta",
                "app_questions.type as Tipo",
                "app_question_answer.other as Otro"
            )->leftJoin("app_answers", "app_answers.id", "=", "app_question_answer.answer_id")
            ->leftJoin("app_questions", "app_questions.id", "=", "app_question_answer.question_id")
            ->leftJoin("app_surveys", "app_surveys.id", "=", "app_question_answer.survey_id")
            ->where("app_question_answer.survey_id", "=", $request->get("id"))
            ->orderBy('app_question_answer.id', 'DESC')->get();

        $filename = $results[0]->Encuesta;
        $i = 0;
        header("Content-Type: application/xls");
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

$app->post('/login', function (Request $request) {
    $result = DB::table('app_users')->where(
        'username', '=', $request->get("username")
    )->where("password", '=', sha1($request->get("password")))->get();

    if (count($result) == 0) {
        return response()->json(['response' => 'false']);
    } else {
        return response()->json(['response' => 'true']);
    }
});

$app->get('/answers/get', function (Request $request) {
    return \Illuminate\Support\Facades\DB::table('app_answers')
        ->where("question_id", "=", $request->get("id"))
        ->orderBy('id', 'DESC')->get();
});

$app->post('/answers', function (Request $request) {
    $surveyId = $request->get('id');

    $survey = \Illuminate\Support\Facades\DB::table('app_surveys')
        ->where('id', '=', $surveyId)->get();

    $response = [
        'survey_id' => $survey[0]->id,
        'title' => $survey[0]->title,
        'description' => $survey[0]->description,
        'questions' => []
    ];

    foreach (\Illuminate\Support\Facades\DB::table('app_questions')
                 ->where('app_questions.survey_id', '=', $surveyId)->get() as $question) {
        array_push($response['questions'],
            [
                'question_id' => $question->id,
                'title' => $question->title,
                'type' => $question->type,
                'vModel' => '*Selecciona una respuesta',
                'answers' => \Illuminate\Support\Facades\DB::table('app_answers')
                    ->where('app_answers.question_id', '=', $question->id)->get()
            ]
        );
    }

    return response()->json($response);
});

$app->post('/answer/add', function (Request $request) {
    $questionId = \Illuminate\Support\Facades\DB::table('app_questions')->insertGetId([
        'survey_id' => $request->get("id", ''),
        'type' => $request->get("type", ''),
        'title' => $request->get("title", '')
    ]);

    if ($questionId > 0) {

        if ($request->get('type') != 'TEXT') {
            foreach ($request->get('answers') as $answer) {
                \Illuminate\Support\Facades\DB::table('app_answers')->insert([
                    'question_id' => $questionId,
                    'title' => $answer['body']
                ]);
            }
            return response()->json(['success' => true]);

        } else {
            return response()->json(['success' => true]);
        }

    } else {
        return response()->json(['success' => false]);
    }
});

$app->post('/questionanswer/add', function (Request $request) {
    $questions = $request->get("questions");
    $surveyId = $request->get("survey_id");

    $ok = true;
    foreach ($questions as $question) {
        $ok = \Illuminate\Support\Facades\DB::table('app_question_answer')->insert([
            'answer_id' => $question['vModel'],
            'question_id' => $question['question_id'],
            'survey_id' => $surveyId,
            'other' => $question['vModel'],
        ]);

        if($ok === false){
            return response()->json(['success' => false]);
        }
    }

    return response()->json(['success' => true]);
});

$app->post('/surveys', function () {
    return \Illuminate\Support\Facades\DB::table('app_surveys')
        ->orderBy('id', 'DESC')->get();
});

$app->post('/survey/add', function (Request $request) {
    if (\Illuminate\Support\Facades\DB::table('app_surveys')->insert([
        'title' => $request->get("title", ''),
        'description' => $request->get("description", ''),
    ])) {
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false]);
    }
});

$app->get('survey/status/', function (Request $request) {
    $status = $request->get("status");

    if (\Illuminate\Support\Facades\DB::table('app_surveys')->where("id", "=", $request->get("id"))
        ->update(['status' => $status])) {
        return response()->json(['success' => 'true']);
    } else {
        return response()->json(['success' => 'false']);
    }
});

$app->post('/survey/delete', function (Request $request) {
    return \Illuminate\Support\Facades\DB::table('app_surveys')
        ->where('id', '=', $request->get('id'))->delete();
});

$app->post('/documents', function () {
    return \Illuminate\Support\Facades\DB::table('app_documents')
        ->orderBy('id', 'DESC')->get();
});

$app->post('/documents/add', function (Request $request) {

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

    $fileName = $random_string(20, '', $request->file('pdfFile')->getClientOriginalExtension());
    $destinationPath = "public/";
    if ($request->file('pdfFile') != null) {
        $request->file('pdfFile')->move($destinationPath, $fileName);
    } else {
        return response()->json(['success' => false]);
    }

    if (\Illuminate\Support\Facades\DB::table('app_documents')->insert([
        'src' => $fileName,
        'title' => $request->get("title"),
    ])) {
        return response()->json(['success' => true]);
    }

});

$app->post('/documents/delete', function (Request $request) {
    return \Illuminate\Support\Facades\DB::table('app_documents')
        ->where('id', '=', $request->get('id'))->delete();
});

$app->post('/news', function () {
    return \Illuminate\Support\Facades\DB::table('app_news')
        ->orderBy('id', 'DESC')->get();
});

$app->post('/news/add', function (Request $request) {
    if (\Illuminate\Support\Facades\DB::table('app_news')->insert(
        ['text' => $request->get('text')]
    )) {
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false]);
    }
});

$app->post('/news/delete', function (Request $request) {
    return \Illuminate\Support\Facades\DB::table('app_news')
        ->where('id', '=', $request->get('id'))->delete();
});

$app->post('/posts', function (Request $request) {
    switch ($request->get('postType')) {
        case "BLOG":
            return \Illuminate\Support\Facades\DB::table('w47fa_posts')
                ->select(
                    "w47fa_posts.ID AS post_id",
                    "w47fa_users.display_name AS post_author",
                    "w47fa_posts.post_title",
                    "w47fa_posts.post_content",
                    "w47fa_posts.post_date",
                    "w47fa_posts.guid as post_url",
                    "w47fa_posts.post_type",
                    "w47fa_posts.post_mime_type"
                )->join("w47fa_users", "w47fa_posts.post_author", '=', "w47fa_users.ID")
                ->where("w47fa_posts.post_status", "LIKE", "publish")
                ->where("w47fa_posts.post_type", "LIKE", "post")
                ->orderBy('post_date', 'desc')->get();
            break;
        case 'PERCEPCION':
            return \Illuminate\Support\Facades\DB::table('w47fa_posts')
                ->select(
                    "w47fa_posts.ID AS post_id",
                    "w47fa_users.display_name AS post_author",
                    "w47fa_posts.post_title",
                    "w47fa_posts.post_content",
                    "w47fa_posts.post_date",
                    "w47fa_posts.guid as post_url",
                    "w47fa_posts.post_type",
                    "w47fa_posts.post_mime_type"
                )->join("w47fa_users", "w47fa_posts.post_author", '=', "w47fa_users.ID")
                ->where("w47fa_posts.post_type", "=", "attachment")
                ->where("w47fa_posts.post_title", "LIKE", '%percepcion%')
                ->orderBy('post_date', 'desc')->get();

            break;
        case 'INDICADORES':
            return \Illuminate\Support\Facades\DB::table('w47fa_posts')
                ->select(
                    "w47fa_posts.ID AS post_id",
                    "w47fa_users.display_name AS post_author",
                    "w47fa_posts.post_title",
                    "w47fa_posts.post_content",
                    "w47fa_posts.post_date",
                    "w47fa_posts.guid as post_url",
                    "w47fa_posts.post_type",
                    "w47fa_posts.post_mime_type"
                )->join("w47fa_users", "w47fa_posts.post_author", '=', "w47fa_users.ID")
                ->where("w47fa_posts.post_type", "=", "attachment")
                ->where("w47fa_posts.post_title", "LIKE", '%INDICADOR%')
                ->orderBy('post_date', 'desc')->get();

            break;
    }
});
