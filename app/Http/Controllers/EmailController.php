<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Prospect;
use App\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store($id)
    {

        $token = Quiz::where('id', $id)
            ->select('token')
            ->first();

        $prospects = Prospect::where('id_quiz', $id)
            ->select('id', 'mail')
            ->get();

        foreach ($prospects as $prospect)
        {
            $uniqueToken = $this->buildUniqueToken($token->token, $prospect->id);
            \Mail::to($prospect->mail)->send(new SendMail($uniqueToken));
        }
    }

    private function buildUniqueToken($token, $id)
    {
        return $id . '__' .$token;
    }
}
