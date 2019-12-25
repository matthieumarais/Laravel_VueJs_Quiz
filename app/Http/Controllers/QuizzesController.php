<?php

namespace App\Http\Controllers;

use App\LabelType;
use App\Quiz;
use App\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class QuizzesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        return Quiz::all();
    }
    public function store(Request $request){

        $token = $this->creatToken();
        request()->validate([
            'title' => ['required'],
        ]);
        $request->request->add(['token' => $token]);

        return Quiz::create([
            'title' => request('title'),
            'token' => request('token')
        ]);
    }

    public function destroy($id)
    {
        LabelType::where('id_quiz', '=', $id)->delete();
        QuizQuestion::where('id_quiz', '=', $id)->delete();
        Quiz::destroy($id);

        return response(null, Response::HTTP_OK);
    }

    private function creatToken()
    {
        $var =  Str::random(32);
        return $var;
    }

}
