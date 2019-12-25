<?php

namespace App\Http\Controllers;

use App\LabelType;
use App\Prospect;
use App\Quiz;
use App\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    }

    public function show($id)
    {

        $infosQuiz = [];

        $queryTitle = DB::table('quizzes')
            ->select('quizzes.title')
            ->where('id', '=', $id)
            ->first();

        $titleForm = $queryTitle->title;

        $queryQuestions = DB::table('quiz_questions')
            ->select('id', 'label', 'type')
            ->where('id_quiz', '=', $id)
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

        $nbProspect = Prospect::where('id_quiz', $id)
            ->count();

        return view('edit', [
            'infosQuiz' => json_encode($infosQuiz),
            'titleForm' => json_encode($titleForm),
            'nbProspect' => $nbProspect
        ]);
    }

    public function findById($id)
    {
        return Quiz::where('id', $id)->get();
    }

    public function store(Request $request)
    {

        $values = $request->input('values');

        request()->validate([
            'label' => ['required'],
            'type' => ['required']
        ]);

        $insertQuestion = QuizQuestion::create([
            'id_quiz' => request('id_quiz'),
            'label' => request('label'),
            'type' => request('type')
        ]);

        $lastId = $insertQuestion->id;

        if (!empty($values)) {
            $request->request->add(['id_question' => $lastId]);

            foreach ($values as $value) {
                $request->request->add(['value' => $value['val']]);
                $insertType = LabelType::create([
                    'id_quiz' => request('id_quiz'),
                    'id_question' => request('id_question'),
                    'value' => request('value')
                ]);
            }
        }

        return $request;
    }

    public function creatAndUpdate(Request $request)
    {

        request()->validate([
            'label' => ['required'],
            'type' => ['required'],
            'options' => 'required_unless:type,!==,textarea'
        ]);

        $update = DB::table('quiz_questions')
            ->where('id', $request->id)
            ->update([
                'label' => $request->label,
                'type' => $request->type
            ]);

        LabelType::where('id_question', '=', $request->id)->delete();

        $options = $request->input('options');

        if (!empty($options)) {
            $request->request->add(['id_question' => $request->id]);

            foreach ($options as $key => $option) {

                $request->request->add(['value' => $option]);
                $insertType = LabelType::create([
                    'id_quiz' => request('idQuiz'),
                    'id_question' => request('id_question'),
                    'value' => request('value')
                ]);
            }
        }
        return $request;
    }

    public function destroy($id)
    {
        LabelType::where('id_question', '=', $id)->delete();
        QuizQuestion::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
