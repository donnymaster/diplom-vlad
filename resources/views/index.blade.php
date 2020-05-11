@extends('layouts.app')

@php
    $is_not_top_main = true;
@endphp

@section('content')
    <section class="jumbotron text-center">
      <div class="container">
        <h1 class="jumbotron-heading"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Система надання послуг в дизайні</font></font></h1>
        <p class="lead text-muted"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Ми раді вас повідомити що ми відкрилися. Ви можете пройти реєстрацію у нас в системі і вибрати дизайнера і зробити замовлення вказавши по якому виду дизайну ваше замовлення. Після створення замовлення ви в реальному часі зможете спілкуватися з адміністрацією, обговорювати подробиці вашого замовлення.</font></font></p>
        <p>
          <a href="{{ route('register') }}" class="btn btn-primary my-2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Реєстрація</font></font></a>
          <a href="#designers" class="btn btn-secondary my-2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Наші дизайнери</font></font></a>
        </p>
      </div>
    </section>

    <div class="album bg-light">
        <div id="designers"></div>
        <div class="container">
            <h2 class="pb-4 text-center">
                Дизайнери
            </h2>
        </div>
      <div class="container">

          <div class="row row-cols-1 row-cols-md-3">
           
            @forelse ($designers as $designer)
            <div class="col mb-4">
                <div class="card h-100">
                  <img src="{{ Storage::url($designer->avatar) }}" class="card-img-top" alt="{{ $designer->name }}">
                  <div class="card-body">
                      <a href="{{ route('designers.show', ['designer' => $designer->id]) }}" class="card-title">{{ $designer->name }} {{ $designer->surname }}</a>
                      <p class="card-text">{{ Str::limit($designer->description, 140) }}</p>
                  </div>
                </div>
            </div>
           @empty
            <h2 class="pb-4 text-center">
                Дизайнери відсутні
            </h2>
           @endforelse   
          </div>

          @if ($designers->count() != 0)
            <div class="d-flex justify-content-end">
                <a href="{{ route('designers.index') }}" class="pb-4 text-end">
                    всі дизайнери
                </a>
            </div>
          @else
              
          @endif


      </div>
    </div>
@endsection
