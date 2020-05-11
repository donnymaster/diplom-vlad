@extends('layouts.app')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('content')
<div class="container">
    <h2 class="p-3 text-center">Проект {{ $order->title }} 
            @if (is_null($order_completed))
            <span class="badge badge-info" style="font-size: 16px;vertical-align: text-top;">проект не завершений</span>
            @else
            <span class="badge badge-info" style="font-size: 16px;vertical-align: text-top;">проект завершений</span>
            @endif
    </h2>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                @if (Auth::user()->role->role_name == 'admin')
                                    <form method="POST" action="{{ route('orders.update', ['order' => $order->id]) }}" enctype="multipart/form-data">                           
                                @else
                                    <form id="order">                                
                                @endif
                                    @csrf @method('put')
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Тип дизайну</label>
                                        <select required name="design_type_id" class="form-control @error('design_type_id') is-invalid @enderror" id="exampleFormControlSelect1" value="{{ old('design_type_id') }}">
                                            <option value="1" 
                                                {{ $order->design_type_id == 1 ? 'selected' : null }}
                                            >Поліграфічний дизайн</option>
                                            <option value="2"
                                                {{ $order->design_type_id == 2 ? 'selected' : null }}
                                            >Веб дизайн</option>
                                        </select>
                                        @error('design_type_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                     </div>
                                     @if (Auth::user()->role->role_name == 'admin')
                                        <label for="design_performer">Виберете дизайнера</label>
                                        <input required hidden name="design_performer_id" id="hidden_designer" type="number" autocomplete="off" value="{{ $order->design_performer_id }}">
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
                                     @endif

                                    <div class="form-group">
                                        <label>Поточний дизайнер: <a href="{{ route('designers.show', ['designer' => $order->design_performer_id]) }}" target="_blank">{{ $order->designer->name }} {{ $order->designer->name }}</a></label>
                                    </div>
            
                                    <div class="form-group">
                                        <label for="title">Назви проекту</label>
                                        <input required type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ $order->title }}">
                                       
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Опис проекту</label>
                                        <textarea required class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4">{{ $order->description }}</textarea>
            
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="cost">Бюджет ($)</label>
                                        <input required type="number" name="cost" class="form-control  @error('cost') is-invalid @enderror" id="cost" value="{{ $order->cost }}">
            
                                        @error('cost')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="customFile">Додаткові матеріали</label>
                                    </div>
                                    <div class="form-group">
                                        <a href="{{ Storage::url($order->attachment) }}" target="_blank" class="btn btn-info">відкрити в новому вікні</a>
                                    </div>
                                    @if (Auth::user()->role->role_name == 'admin')
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
                                                    оновити
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                            <div class="col-md-5">                                                                                                                                  
                                <div class="container bootstrap snippet">
                                    <div class="row">
                                        <div class="col-md-12 col-md-offset-12">
                                            <div class="portlet portlet-default">
                                                <div class="portlet-heading">
                                                    <div class="portlet-title">
                                                        @if (Auth::user()->role->role_name == 'user')
                                                            <h4><i class="fa fa-circle text-green"></i>Чат з адміністратором</h4>
                                                        @else
                                                            <h4><i class="fa fa-circle text-green"></i>Чат із замовником</h4>
                                                        @endif
                                                    </div>                
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div id="chat" class="panel-collapse collapse in show">
                                                {{-- <div> --}}
                                                    <div id="wrapped-messages" class="portlet-body chat-widget" style="overflow-y: auto; width: auto; height: 300px;">                                                    
                                                    
                                                    </div>
                                                </div>
                                                    <div class="portlet-footer">
                                                        @if (is_null($order_completed))
                                                            <form role="form">
                                                                <div class="form-group">
                                                                    <textarea id="user-message" class="form-control" placeholder="Введіть повідомлення ..."></textarea>
                                                                </div>
                                                                <div class="form-group d-flex justify-content-end">
                                                                    <button type="button" id="send-message" class="btn btn-primary pull-right">Надіслати</button>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.col-md-4 -->
                                    </div>
                                </div> 
                                {{-- вывод самой выполненной работы --}}
                                @if (!is_null($order_completed))
                                <div class="container">
                                    <hr>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-6">
                                            <h1 class="text-center">Виконана робота</h1>
                                            <form class="d-flex justify-content-center">
                                                <div class="form-group">
                                                    <label for="description">Матеріали виконаної роботи</label>
                                                    <a href="{{ Storage::url($order_completed->attachment) }}" target="_blank" class="btn btn-info">відкрити в новому вікні</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif 
                                @if (Auth::user()->role->role_name == 'user')
                                    @if (!is_null($order_completed))
                                        @if (is_null($order_completed->rating))
                                            <div class="container">
                                                <hr>
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-md-6">
                                                        <h4 class="text-center">Поставте оцінку роботі від 1 до 5</h4>
                                                        <form action="{{ route('rating-order') }}" method="POST">
                                                            @csrf
                                                            <input type="number" hidden name="order_id" value="{{$order->id}}">
                                                            <div class="form-group">
                                                                <input step="0.1" min="0.1" max="5" name="rating" value="0.1" type="number" class="form-control" id="validationTooltip01" required>
                                                            </div>
                                                            <div class="form-group d-flex justify-content-center">
                                                                <button type="submit" class="btn btn-primary pull-right">Надіслати</button>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif                                                 
                            </div>                
                        </div>
                    </div>
                    @if (Auth::user()->role->role_name == 'admin')
                    @if (is_null($order_completed))
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6">
                                <h1 class="text-center">Закрити замовлення</h1>
                                <form action="{{ route('order-end') }}" enctype="multipart/form-data" method="POST">
                                    <input type="number" hidden name="order_id" value="{{ $order->id }}">
                                    <input type="number" hidden name="design_performer" value="{{ $order->design_performer_id }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="description">Матеріали виконаної роботи</label>
                                        <div class="custom-file">
                                            <input required name="attachment" type="file" class="custom-file-input @error('attachment') is-invalid @enderror" id="customFile">
                                            <label class="custom-file-label" for="customFile">виберете файл</label>
                                        </div>
            
                                        @error('attachment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary m-3">
                                                    надіслати
                                                </button>
                                            </div>
                                        </div>
                                    </div>
            
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
                </div>
            </div>
        </div>
    </div>
</div>

<input hidden id="user_id" value="{{ Auth::user()->id }}">
<input hidden id="broadcast_order_id" value="{{ $order->broadcast_identifier }}">
<input hidden id="user_name" value="{{ Auth::user()->name }}">
<input hidden id="user_surname" value="{{ Auth::user()->surname }}">

@endsection

    @section('chat-js')
        <script>
            window.addEventListener('load', function() {
                var user_id = $('#user_id').val();
                var broadcast_order_id = $('#broadcast_order_id').val();

                axios.get(`/messages?id=${broadcast_order_id}`).then(response => {
                    if(response){
                        render_message(response.data, '#wrapped-messages');
                        scroll_bottom('#wrapped-messages');
                    }
                });

            function render_message(data, el)
            {
                data.forEach(function(item){
                    var str_item =  `
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="media">                                   
                                <div class="media-body">
                                    <h4 class="media-heading">${item.user.name} ${item.user.surname}</h4>
                                    <p>${item.message}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    `;
                    $(el).append(str_item);
                });
            }

            function scroll_bottom(el)
            {
                var div = $(el);
                div.scrollTop(div.prop('scrollHeight'));
            }

            // отправка сообщения
            $('#send-message').on('click', function(){

                var text = $('#user-message').val();

                console.log(text);
                if(text == "") { return; }

                var message = {
                    user_id: user_id,
                    message: text,
                    broadcast_identifier: broadcast_order_id
                };
                axios.post('/messages', message).then(response => {
                    console.log(response.data);
                });

                var user_name = $('#user_name').val();
                var user_surname = $('#user_surname').val();
                
                var str_item =  `
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="media">                                   
                                <div class="media-body">
                                    <h4 class="media-heading">${user_name} ${user_surname}</h4>
                                    <p>${text}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    `;
                $('#wrapped-messages').append(str_item);
                scroll_bottom('#wrapped-messages');
                $('#user-message').val("");
            });

            // слушатель
            Echo.private(`chat.${broadcast_order_id}`)
            .listen('MessageSent', (e) => {
                render_mesage(e);
            });

            function render_mesage(data)
            {
                var str_item =  `
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="media">                                   
                                <div class="media-body">
                                    <h4 class="media-heading">${data.user.name} ${data.user.surname}</h4>
                                    <p>${data.message.message}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    `;
                $('#wrapped-messages').append(str_item);
                scroll_bottom('#wrapped-messages');
            }
        });
        </script>
    @endsection


@if (Auth::user()->role->role_name == 'user')
    @section('custom-js')
        <script>
            window.addEventListener('load', function() {

                $("#order :input").attr("disabled", true);
            })
        </script>
    @endsection

@else

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

@endif
