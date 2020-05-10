@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header text-center">Форма зворотного зв'язку</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('feedbacks.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="title">Тема</label>
                                <input required type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email">Пошта</label>
                                <input required name="email" disabled type="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ Auth::user()->email }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Ваше повідомлення</label>
                                <textarea required class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4">{{ old('description') }}</textarea>
    
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                                                 
                            <div class="form-group">
                                <label for="customFile">Додаткові матеріали</label>
                                <div class="custom-file">
                                    <input name="attachment" type="file" class="custom-file-input @error('attachment') is-invalid @enderror" id="customFile">
                                    <label class="custom-file-label" for="customFile">виберете файл</label>
                                </div>
                                <input class="custom-file-input @error('attachment') is-invalid @enderror" hidden>
                                @error('attachment')
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
