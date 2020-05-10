@extends('layouts.app')

@section('content')
<div class="container mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET">
                        <div class="form-row">
                          <div class="col-md-6 d-flex align-items-center">

                            <div class="custom-control custom-checkbox mr-3">
                                <input 
                                    {{ Request::query('pol-deginer') == 'on' ? 'checked' : null }}
                                name="pol-deginer" type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Поліграфічний дизайн</label>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input 
                                    {{ Request::query('web-designer') == 'on' ? 'checked' : null }}
                                name="web-designer" type="checkbox" class="custom-control-input" id="customCheck2">
                                <label class="custom-control-label" for="customCheck2">Веб дизайн</label>
                            </div>

                          </div>
                          <div class="col-md-5 d-flex justify-content-end">
                            <div class="form-group row" style="margin: 0">
                                <label for="inputPassword" class="col-form-label mr-3">Сортування</label>
                                <div>
                                    <select class="custom-select" name="sort">
                                        <option value="max-star"
                                        {{ Request::query('sort') == 'max-star' ? 'selected' : null }}
                                        >За рейтингом спочатку гірші</option>

                                        <option value="min-star"
                                        {{ Request::query('sort') == 'min-star' ? 'selected' : null }}
                                        >За рейтингом спочатку кращі</option>

                                        <option value="old-designer"
                                        {{ Request::query('sort') == 'old-designer' ? 'selected' : null }}
                                        >Спочатку нові</option>

                                        <option value="new-designer"
                                        {{ Request::query('sort') == 'new-designer' ? 'selected' : null }}
                                        >Спочатку старі</option>
                                      </select>
                                </div>
                              </div>
                          </div>
                          <div class="col-md-1 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">оновити</button>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card-columns">
                @forelse ($designers as $designer)
                    <div class="card">
                        <img class="card-img-top" src="{{ Storage::url($designer->avatar) }}" alt="designer">
                        <div class="card-body">
                        <a href="{{ route('designers.show', ['designer' => $designer->id]) }}">
                            <h5 class="card-title">{{ $designer->name }} {{ $designer->surname }}</h5>
                        </a>
                        <p class="card-text">{{ Str::limit($designer->description, 140) }}</p>
                        </div>
                    </div>
                @empty
                    
                @endforelse         
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            {{ $designers->onEachSide(3)->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
