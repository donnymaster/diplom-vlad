@extends('layouts.app')

@section('custom-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">Питання користувачів</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%" id="orders">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Користувач</th>
                                    <th>Тема</th>
                                    <th>Повідомлення</th>
                                    <th>Доп. матеріали</th>
                                    <th>Відповісти</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script defer src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $('#orders').DataTable({
                language: {
                "emptyTable": "Дані відсутні в таблиці",
                "loadingRecords": "Завантаження...",
                "processing": "Завантаження...",
                "search":         "Пошук:",
                "lengthMenu":     "Показати _MENU_ записів",
                "info":           "Показано _START_ до _END_ з _TOTAL_ записів",
                "zeroRecords":    "Не знайдено відповідних записів",
                "infoEmpty":      "Показано від 0 до 0 із 0 записів",
                "infoFiltered":   "(відфільтровано з _MAX_ всього записів)",
                "paginate": {
                    "first":      "Спочатку",
                    "last":       "Остання",
                    "next":       "Далі",
                    "previous":   "Попередній"
                }
                },
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: '{!! route('get-feedback') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user', name: 'user.name' , searchable: true},
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'attachment', name: 'attachment', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endsection
