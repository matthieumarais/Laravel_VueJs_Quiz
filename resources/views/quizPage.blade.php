@extends('layouts.app')

@section('content')
    <div class="container">

        <quiz-page
            :data-id="{{$idQuiz}}"
            :data-infos="{{ $infosQuiz }}"
            :data-title="{{$titleForm}}"
            :data-state="{{$stateProspect}}"
        ></quiz-page>
    </div>
@endsection
