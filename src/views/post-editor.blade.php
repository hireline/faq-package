@extends('FaqPackage::master')
@section('head-resources')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.20.0/ui/trumbowyg.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.20.0/trumbowyg.min.js"></script>
@endsection
@section('content')
    @include('FaqPackage::components.navbar')
    <div class="container">
        <h2>{{ $post->id ? 'Editando' : 'Creando' }} post</h2>
        <form action="{{ $post->id ? route('posts.update', ['post_id' => $post->id]) : route('posts.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="input-field col s6">
                    <input id="title" type="text" class="validate" name="title" value="{{ $post->title }}" required>
                    <label for="title">Título del artículo</label>
                </div>
                <div class="input-field col s6">
                    <select name="category" id="category">
                        <option value="" disabled selected>Elige una opción</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if( $post->categories()->where('category_id', $category->id)->count() ) {{ 'selected' }} @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <label>Categoría del artículo</label>
                </div>
                @if(count($postForRole))
                <div class="input-field col s6">
                    <select name="roles[]" id="roles" multiple="multiple">
                        <option value="" disabled selected>Elige una opción</option>
                        @foreach($postForRole as $role)
                            <option value="{{ $role }}" @if( isset($post->roles[$role]) ) {{ 'selected' }} @endif>{{ $role }}</option>
                        @endforeach
                    </select>
                    <label>Roles</label>
                </div>
                @endif
                <div class="input-field col s12 center-align">
                    <a class="waves-effect waves-light btn orange" target="_blank" href="{{ route('resources.show') }}">Recursos</a>
                </div>
                <div class="input-field col s12">
                    <textarea id="post-content" name="body" class="materialize-textarea">{!! $post->body !!}</textarea>
                </div>
                <div class="col s12 center-align">
                    <button class="waves-effect waves-light btn orange" type="submit">
                        Guardar
                    </button>
                </div>
            </div>
        </form>

    </div>
    @section('body-scripts')
        @parent
        <script>
            $(document).ready(function(){
                $('select').formSelect();
            });
        </script>
        <script>
            $(document).ready(function() {
                $('textarea').trumbowyg({
                    imageWidthModalEdit: true
                });
            });
        </script>
    @endsection
@endsection