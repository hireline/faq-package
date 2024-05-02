@extends('FaqPackage::master')
@section('title')
    {{ $post->title }} - FAQ
@endsection
@section('meta-description')
    <meta name="description" content="{{ $post->meta_description }}">
@endsection
@section('head-styles')
    <style>
        body{
            background-color: #f3f5f7;
        }
    </style>
@endsection
@section('content')
    @include('FaqPackage::components.search-bar')
    <div class="container" style="width: 60%;">
        <div class="card-panel">
            <div class="container" style="width: 80%;">
                <div class="row">
                    <h3>{{ $post->title }}</h3>
                </div>
                <div class="row">
                    {!! $post->body !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('bottom-styles')
    @parent
    <style>
        input[type=search]:not(.browser-default):focus:not([readonly]){
            border-bottom: 1px solid #00abc6;
            -webkit-box-shadow: 0 1px 0 0 #00abc6;
            box-shadow: 0 1px 0 0 #00abc6;
        }
        .card-button:hover{
            -webkit-box-shadow: 0 3px 3px 0 rgba(0,0,0,0.14), 0 1px 7px 0 rgba(0,0,0,0.12), 0 3px 1px -1px rgba(0,0,0,0.2);
            box-shadow: 0 3px 3px 0 rgba(0,0,0,0.14), 0 1px 7px 0 rgba(0,0,0,0.12), 0 3px 1px -1px rgba(0,0,0,0.2);
        }
    </style>
@endsection