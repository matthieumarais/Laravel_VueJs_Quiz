<?php

namespace App\Http\Controllers;

use App\Prospect;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizPageController extends Controller
{
    public function show($uniqueToken)
    {
        $token = explode('__', $uniqueToken)[1];
        $idProspect = explode('__', $uniqueToken)[0];



        $infosQuiz = [];

        $queryTitle = DB::table('quizzes')
            ->select('title', 'id')
            ->where('token', '=', $token)
            ->first();

        $idQuiz = $queryTitle->id;

        $titleForm = $queryTitle->title;

        $queryQuestions = DB::table('quiz_questions')
            ->select('id', 'label', 'type')
            ->where('id_quiz', '=', $idQuiz)
            ->get();

        foreach ($queryQuestions as $key => $valueQuestion) {
            $infos = [];
            $queryTypes = DB::table('label_types')
                ->select('id_question', 'value')
                ->where('id_question', '=', $valueQuestion->id)
                ->get();
            $infos['id'] = $valueQuestion->id;
            $infos['label'] = $valueQuestion->label;
            $infos['type'] = $valueQuestion->type;

            if  ($valueQuestion->type != 'textarea') {
                $array = [];
                foreach ($queryTypes as $k => $queryType) {

                    $array[] = $queryType->value;

                }
                $infos['options'] = $array;
            }
            $infosQuiz[] = $infos;
        }

        $stateProspect = Prospect::where('id', $idProspect)
            ->select('state')
            ->first();


        return view('quizPage', [
            'infosQuiz' => json_encode($infosQuiz),
            'titleForm' => json_encode($titleForm),
            'idQuiz' => $idQuiz,
            'stateProspect' => $stateProspect->state
        ]);
    }

    public function store(Request $request)
    {
        DB::table('replies')
            ->updateOrInsert(
                ['id_quiz' => $request->id_quiz, 'id_question' => $request->id_question, 'id_prospect' => $request->id_prospect],
                ['value' => $request->value]
            );
    }
    public function findById($id, $prospect)
    {
       return Reply::where('id_question', $id)
            ->where('id_prospect', $prospect)
            ->select('value')
            ->get();
    }

}
