@extends('layout.layout')
@section('title')
    <title>Маъмурий ҳудудий тузилмаларни (объектларни) белгилаш тизими | Geonames</title>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.page')}}">@lang('text.bosh_sahifa')</a></li>
        <li class="breadcrumb-item"><a href="{{route('pages.classifiers.index')}}">@lang('text.klassifikatorlar')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('text.mamuriy_hududiy_tuzulmalar')
        </li>
    </ol>
@endsection
@section('extra')
    @if(!$user->hasRole('observer'))
        <div class="d-none d-sm-flex">
            <a class="btn btn-success  mg-sm-r-30" type="button" href="{{ route('pages.classifiers.soato_edit') }}">
                <i data-feather="check" class="svg-14"></i> @lang('text.taxrirlash')
            </a>
            <a class="btn btn-success  mg-sm-r-30" type="button" href="#add_district" data-toggle="modal">
                <i data-feather="plus" class="svg-14"></i> @lang('text.tuman_qoshish')
            </a>
        </div>
    @endif
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif

    <div class="alert alert-success hidden" role="alert">
        Янги маълумотнома муваффақиятли қўшилди!
    </div>
    <div class="btn-group mr-2" role="group" aria-label="First group">
        <span class="btn bd-0-f"><i class="mg-r-15" data-feather="code"></i> @lang('text.tasniflar')</span>
        <span class="btn bd-0-f"> <i class="mg-r-15 " data-feather="git-commit"></i> @lang('text.malumotnomalar')</span>
    </div>
    <div class="divider-text mg-b-20">@lang('text.mamuriy_hududiy_tuzulmalar')</div>
    <div class="table-responsive">
        <table class="table fold-table">
            <thead class="bg-blue">
            <tr>
                <th>@lang('text.xudud_nomi')</th>
                <th>@lang('text.kod')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($uz_regions as $item)
                <tr class="view">
                    <td>{{$item->nameUz}}</td>
                    <td>{{$item->regionid}}</td>
                </tr>
                    <tr class="fold">
                        <td>
                            <table class="table">
                                <tbody>
                                @foreach($item->uz_districts as $district)
{{--                                    <tr class="view" onclick="window.location.href='{{route('pages.classifiers.soato.punkt',$district->areaid)}}'">--}}
                                    <tr class="view">
                                        <td>{{$district->nameUz}}</td>
                                        <td>{{$district->areaid}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="add_district" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <form action="{{ route('pages.classifiers.soato.add_district') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel4">Янги туман қўшиш</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i data-feather="x"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row row-sm">
                            <div class=" col-sm-12 col-md-4">
                                <label>Вилоят</label>
                                <select class="custom-select form-control select2" name="region" required style="width: 100%;">
                                    <option value=""></option>
                                    @foreach($uz_regions as $item)
                                        <option value="{{ $item->regionid }}">{{ $item->nameUz }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Ўзбекча номи</label>
                                <input type="text" name="nameUz" class="form-control">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Русча номи</label>
                                <input type="text" name="nameRu" class="form-control">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Tarixiy (avvalgi) Ўзбекча номи</label>
                                <input type="text" name="oldNameUz" class="form-control">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Tarixiy (avvalgi) Русча номи</label>
                                <input type="text" name="oldNameRu" class="form-control">
                            </div>
                            <div class=" col-sm-12 col-md-4">
                                <label>Норматив ҳужжати</label>
                                <select class="custom-select form-control select2" name="normative_document" required style="width: 100%;">
                                    <option value=""></option>
                                    @foreach($normative_documents as $item)
                                        <option value="{{ $item->id }}">{{ $item->nameUz }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Соатоси</label>
                                <input type="number" name="soato" class="form-control">
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Коди</label>
                                <input type="number" name="code" class="form-control">
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Изоҳ</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Бекор қилиш</button>
                        <button type="submit" class="btn btn-success">Сақлаш</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        // Adding placeholder for search input
        (function ($) {

            'use strict'

            var Defaults = $.fn.select2.amd.require('select2/defaults');

            $.extend(Defaults.defaults, {
                searchInputPlaceholder: ''
            });

            var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');

            var _renderSearchDropdown = SearchDropdown.prototype.render;

            SearchDropdown.prototype.render = function (decorated) {

                // invoke parent method
                var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));

                this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));

                return $rendered;
            };

        })(window.jQuery);

        $(function () {

            'use strict'

            // The code below is for demo purposes only.
            // For you to not be confused, please refer to
            // Off-Canvas starter template in Collections

            $('.off-canvas-menu').on('click', function (e) {
                e.preventDefault();
                var target = $(this).attr('href');
                $(target).addClass('show');
            });


            $('.off-canvas .close').on('click', function (e) {
                e.preventDefault();
                $(this).closest('.off-canvas').removeClass('show');
            })

            $(document).on('click touchstart', function (e) {
                e.stopPropagation();

                // closing of sidebar menu when clicking outside of it
                if (!$(e.target).closest('.off-canvas-menu').length) {
                    var offCanvas = $(e.target).closest('.off-canvas').length;
                    if (!offCanvas) {
                        $('.off-canvas.show').removeClass('show');
                    }
                }
            });

            // Basic with search
            $('.select2').select2({
                placeholder: 'Танланг',
                searchInputPlaceholder: 'Излаш'
            });

            // Disable search
            $('.select2-no-search').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Танланг'
            });

            // Clearable selection
            $('.select2-clear').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Танланг',
                allowClear: true
            });

            // Limit selection
            $('.select2-limit').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Танланг',
                maximumSelectionLength: 2
            });

            $('#datepicker4').datepicker();

            $('#example2').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Излаш...',
                    sSearch: '',
                    lengthMenu: '_MENU_ тани кўрсатиш',
                }
            });


            $('#modal6').on('show.bs.modal', function (event) {

                var animation = $(event.relatedTarget).data('animation');
                $(this).addClass(animation);
            })

            // hide modal with effect
            $('#modal6').on('hidden.bs.modal', function (e) {
                $(this).removeClass(function (index, className) {
                    return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
                });
            });

            // Select2
            $('.dataTables_length select').select2({minimumResultsForSearch: Infinity});


        })

    </script>
@endsection
