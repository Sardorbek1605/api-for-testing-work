@extends('layout.layout')
@section('title')
    <title>Маъмурий ҳудудий тузилмаларни (объектларни) белгилаш тизими | Geonames</title>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.page')}}">@lang('text.bosh_sahifa')</a></li>
        <li class="breadcrumb-item"><a href="{{route('pages.classifiers.index')}}">@lang('text.klassifikatorlar')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('text.davlat_va_xojalik_boshqaruvi')
        </li>
    </ol>
@endsection
@section('content')
    <div class="alert alert-success hidden" role="alert">
        Янги маълумотнома муваффақиятли қўшилди!
    </div>
    <div class="btn-group mr-2" role="group" aria-label="First group">
        <span class="btn bd-0-f"><i class="mg-r-15" data-feather="code"></i> @lang('text.tasniflar')</span>
        <span class="btn bd-0-f"> <i class="mg-r-15 " data-feather="git-commit"></i> @lang('text.malumotnomalar')</span>
    </div>
    <div class="divider-text mg-b-20">@lang('text.davlat_va_xojalik_boshqaruvi')</div>
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
                                <tr>
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

    <div class="modal fade" id="add_tasnif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel4">Янги тасниф/маълумотнома қўшиш</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="form-group col-sm-8">
                            <label>Тўлиқ номи</label>
                            <input type="text" class="form-control">
                        </div><!-- col -->
                        <div class="form-group col-sm-4">
                            <label>Қисқартма номи</label>
                            <input type="text" class="form-control">
                        </div><!-- col -->
                        <div class=" col-sm-12 col-md-12">
                            <label>Тури</label>
                            <select class="custom-select form-control select2-no-search" required style="width: 100%;">
                                <option value="1">Тасниф</option>
                                <option value="2">Маълумотнома</option>
                            </select>
                        </div><!-- component-section -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Бекор қилиш</button>
                    <button type="button" class="btn btn-success">Сақлаш</button>
                </div>
            </div>
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
