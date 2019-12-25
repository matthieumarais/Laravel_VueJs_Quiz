<?php

namespace App\Http\Controllers;

use App\Prospect;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProspectController extends Controller
{
   public function index($id)
   {
       return Prospect::where('id_quiz', $id)
           ->select('id', 'mail')
            ->get();
   }

   public function store()
   {
       request()->validate([
           'id_quiz' => ['required'],
           'mail' => 'email'
       ]);

       $insertProspect = Prospect::create([
           'id_quiz' => request('id_quiz'),
           'state' => request('state'),
           'mail' => request('mail')
       ]);

       return $insertProspect->id;
   }

   public function update($idProspect)
   {
       Prospect::where('id', $idProspect)
           ->update(['state' => 1]);
   }

   public function destroy($id)
   {
       Prospect::destroy($id);

       return response(null, Response::HTTP_OK);
   }
}
