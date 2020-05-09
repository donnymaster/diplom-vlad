@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('create'))
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="alert alert-success text-center" role="alert">
                        {{ session('create') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Форма створення дизайнера</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('designers.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="title">Ім'я</label>
                            <input required type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="title" value="{{ old('name') }}">
                           
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">Прізвище</label>
                            <input required type="text" name="surname" class="form-control @error('surname') is-invalid @enderror" id="title" value="{{ old('surname') }}">
                           
                            @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Опис дизайнера</label>
                            <textarea required class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4">{{ old('description') }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Тип дизайну</label>
                            <select required name="design_type_id" class="form-control @error('design_type_id') is-invalid @enderror" id="exampleFormControlSelect1" value="{{ old('design_type_id') }}">
                              <option value="1">Поліграфічний дизайн</option>
                              <option value="2">Веб дизайн</option>
                            </select>
                            @error('design_type_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                         </div>                      
                        <div class="form-group">
                            <label for="customFile">Аватар</label>
                            <div class="custom-file">
                                <input required name="avatar-logo" type="file" accept="image/*" class="custom-file-input @error('avatar-logo') is-invalid @enderror" id="customFile">
                                <label class="custom-file-label" for="customFile">виберете файл</label>
                            </div>
                            <input class="custom-file-input @error('avatar-logo') is-invalid @enderror" hidden>
                            @error('avatar-logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    додати дизайнера
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
