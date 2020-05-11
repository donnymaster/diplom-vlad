@extends('layouts.app')

@section('content')

@if (session('create'))
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-success text-center" role="alert">
                    {{ session('create') }}
                </div>
            </div>
        </div>
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Форма створення замовлення на дизайн</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('orders.store') }}" enctype="multipart/form-data">
                        @csrf
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
                        {{-- </div> --}}
                        <label for="design_performer">Виберете дизайнера<span class="text-danger" title="Почніть вводити ім'я дизайнера і внизу з'явиться список дизайнерів.">*</span></label>
                        <input required hidden name="design_performer_id" id="hidden_designer" type="number" autocomplete="off" value>
                        <div class="form-group">
                            <input class="typeahead form-control @error('design_performer_id') is-invalid @enderror" id="design_performer" type="text" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <input hidden class="@error('design_performer_id') is-invalid @enderror">
                            @error('design_performer_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">Назви проекту</label>
                            <input required type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}">
                           
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Опис проекту</label>
                            <textarea required class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4">{{ old('description') }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cost">Приблизний бюджет ($) <span class="text-danger" title="Після створення замовлення ви можете обговорити бюджет проекту з адміністратором.">*</span></label>
                            <input required type="number" name="cost" class="form-control  @error('cost') is-invalid @enderror" id="cost" value="{{ old('cost') }}">

                            @error('cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Додаткові матеріали</label>
                            <div class="custom-file">
                                <input name="attachment" type="file" class="custom-file-input @error('attachment') is-invalid @enderror" id="customFile">
                                <label class="custom-file-label" for="customFile">виберете файл</label>
                            </div>

                            @error('attachment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    зробити замовлення
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

@section('custom-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.2.1/bloodhound.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.2.1/typeahead.jquery.min.js"></script>
    <script>
        var path = "{{ route('get-designers-ajax') }}";
        var get_query = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace("name"),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: `${path}?query=`,
                prepare: function (query, settings) {   
                    var design_type = $('#exampleFormControlSelect1 option:checked').val();                
                    settings.url = this.url + query + '&type_disegn=' + design_type;
                    return settings;
            }
            }
        });

        $('#design_performer').typeahead(
        {
            minLength: 2,
            highlight: true
        },
        {
            name: 'countries',
            source: get_query,   // suggestion engine is passed as the source
            display: function(item) {        // display: 'name' will also work
                return item.name + ' ' + item.surname;
            },
            limit: 20,
            templates: {
                suggestion: function(item) {
                    return '<div class="designer_item cursor">'+ item.name + ' ' + item.surname +'</div>';
                },
                notFound: '<div class="designer_item no-cursor">Not Found</div>',
            }
        });

        $('#design_performer').bind('typeahead:select', function(ev, suggestion) {
            document.querySelector('#hidden_designer').setAttribute('value', suggestion.id);
        });
    </script>
@endsection
