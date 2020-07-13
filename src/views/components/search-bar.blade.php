<div class="row">
    <div class="col s2 right-align" style="width:20%">
        <p style="font-size:1.45rem; margin: 1.5rem 0 0 0; font-weight:100;">
            Estamos aquí para ayudarte
        </p>
    </div>
    <div class="col s7" style="width:60%;">
        <form action="{{ route('posts.search') }}" method="GET">
            <div class="input-field search">
                <span id="search" class="material-icons">search</span>
                {{-- <span class="fas fa-search"></span> --}}
                <input id="query" type="text" name="q" value="{{request('q')}}" placeholder="Busca respuestas..." autocomplete="off" autofocus style="height:4rem;">
            </div>
        </form>
    </div>
</div>