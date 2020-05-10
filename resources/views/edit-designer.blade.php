@extends('layouts.app')

@section('content')
@if (session('update'))
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-success text-center" role="alert">
                    {{ session('update') }}
                </div>
            </div>
        </div>
    </div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Форма оновлення дизайнера {{  $designer->name }}  {{  $designer->surname }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('designers.update', ['designer' => $designer->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="title">Ім'я</label>
                            <input required type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="title" value="{{ $designer->name }}">
                           
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">Прізвище</label>
                            <input required type="text" name="surname" class="form-control @error('surname') is-invalid @enderror" id="title" value="{{ $designer->surname }}">
                           
                            @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Опис дизайнера</label>
                            <textarea required class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4">{{ $designer->description }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Тип дизайну</label>
                            <select required name="design_type_id" class="form-control @error('design_type_id') is-invalid @enderror" id="exampleFormControlSelect1" value="{{ old('design_type_id') }}">
                              <option value="1" 
                                {{ $designer->design_type_id == 1 ? 'selected' : null }}
                              >Поліграфічний дизайн</option>
                              <option value="2"
                                {{ $designer->design_type_id == 2 ? 'selected' : null }}
                              >Веб дизайн</option>
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
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="customFile">Поточний аватар</label>
                        </div>
                        <div class="form-group">
                            @if ($designer->avatar === "")
                                <button disabled href="#" target="_blank" class="btn btn-info">відкрити в новому вікні</button>
                            @else
                                <a href="{{ Storage::url($designer->avatar) }}" target="_blank" class="btn btn-info">відкрити в новому вікні</a>
                            @endif
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    оновити дизайнера
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
