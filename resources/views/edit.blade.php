@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <edit
                :data-infos="{{ $infosQuiz }}"
                :data-title="{{$titleForm}}"
                :data-prospect="{{$nbProspect}}"
            ></edit>
        </div>
    </div>
@endsection
