@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">Форма відповіді на питання - {{ $feedback->title }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('feedback.answer') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="text" hidden name="id" value="{{ $feedback->id }}">
                            <div class="form-group">
                                <label for="feedback">Питання від {{ $feedback->user->name }} {{ $feedback->user->surname }}</label>
                                <textarea disabled class="form-control" id="feedback" rows="6">{{ $feedback->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="description">Ваша відповідь</label>
                                <textarea required class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="6">{{ old('description') }}</textarea>
    
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                                                 
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        надіслати повідомлення
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
