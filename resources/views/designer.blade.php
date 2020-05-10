@extends('layouts.app')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-6 d-flex justify-content-center">
                                    <img src="{{ Storage::url($designer->avatar) }}" class="img-fluid" alt="Responsive image">
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-6 d-flex justify-content-center">
                                    <h3 class="text-center pt-4 pb-4">{{ $designer->name }} {{ $designer->surname }} <span class="badge badge-primary">{{ $designer->typeDesign->design_name }}</span> </h3>
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row justify-content-center">
                                <input id="input-v" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $designer->rating }}">
                            </div>
                        </div>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <h3>Про дизайнера:</h3>
                                    <p class="pt-2 pb-2 text-justify">
                                        {{ $designer->description }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom-js')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script defer src="{{ asset('js/star-rating.js') }}"></script>
    <script>

        jQuery(document).ready(function () {
            $('#input-v').rating({
                displayOnly:true,
                showCaption:false
            });
        });

        // jQuery(document).ready(function () {
        //     $("#input-21f").rating({
        //         displayOnly:false,
        //         starCaptions: function (val) {
        //             if (val < 3) {
        //                 return val;
        //             } else {
        //                 return 'high';
        //             }
        //         },
        //         starCaptionClasses: function (val) {
        //             if (val < 3) {
        //                 return 'label label-danger';
        //             } else {
        //                 return 'label label-success';
        //             }
        //         },
        //         hoverOnClear: false
        //     });
        //     var $inp = $('#rating-input');

            // $inp.rating({
            //     min: 0,
            //     max: 5,
            //     step: 1,
            //     size: 'lg',
            //     showClear: false
            //     displayOnly:false,
            // });

            // $('#btn-rating-input').on('click', function () {
            //     $inp.rating('refresh', {
            //         showClear: true,
            //         disabled: !$inp.attr('disabled')
            //     });
            // });


            // $('.btn-danger').on('click', function () {
            //     $("#kartik").rating('destroy');
            // });

            // $('.btn-success').on('click', function () {
            //     $("#kartik").rating('create');
            // });

            // $inp.on('rating.change', function () {
            //     alert($('#rating-input').val());
            // });


        //     $('.rb-rating').rating({
        //         'showCaption': true,
        //         'stars': '3',
        //         'min': '0',
        //         'max': '3',
        //         'step': '1',
        //         'size': 'xs',
        //         'starCaptions': {0: 'status:nix', 1: 'status:wackelt', 2: 'status:geht', 3: 'status:laeuft'}
        //     });
        //     $("#input-21c").rating({
        //         min: 0, max: 8, step: 0.5, size: "xl", stars: "8"
        //     });
        // });
</script>
@endsection
