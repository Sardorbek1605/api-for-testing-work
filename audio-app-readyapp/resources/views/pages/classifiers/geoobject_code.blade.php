@extends('layout.layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.page')}}">@lang('text.bosh_sahifa')</a></li>
        <li class="breadcrumb-item"><a href="{{route('pages.classifiers.index')}}">@lang('text.klassifikatorlar')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('text.geografik_obyekt_kodlarini_belgilash')</li>
    </ol>
@endsection

@section('extra')
    @if(!$user->hasRole('observer'))
    <div class="d-none d-sm-flex">
        <a class="btn btn-success  mg-sm-r-30" type="button" href="#add_geo_code" data-toggle="modal">
            <i data-feather="plus" class="svg-14"></i> @lang('text.qoshish')
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

    <div class="col-md-12">
        <table class="table table-bordered table-hover">
            <thead class="bg-blue">
            <tr class="table-active">
                <th class="wd-5p">@lang('text.id')</th>
                <th class="wd-10p">@lang('text.ozbekcha')</th>
                <th class="wd-10p">@lang('text.ruscha')</th>
                <th class="wd-10p">@lang('text.inglizcha')</th>
                <th class="wd-10p">@lang('text.geografik_shifri')</th>
                <th class="wd-10p">@lang('text.normativ_hujjati')</th>
                @if(!$user->hasRole('observer'))
                <th class="wd-10p">@lang('text.xarakat')</th>
                @endif
            </tr>
            </thead>
            <tbody>
                @foreach($geocodes as $key => $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td data-name="NameUzb">{{$item->nameUz}}</td>
                        <td data-name="NameRus">{{$item->nameRu}}</td>
                        <td data-name="NameEng">{{$item->nameEn}}</td>
                        <td data-name="enum_GeoObjectCode.Code">{{$item->code}}</td>
                        <td>{{ $item->documentName }}</td>
                        @if(!$user->hasRole('observer'))
                        <td>
                            <a href="#update_geo_code2{{$item->id}}"
                               class="btn btn-smmg-l-2"
                               data-toggle="modal"
                               data-id="{{ $item->id }}"
                               data-uz="{{ $item->nameUz }}"
                               data-ru="{{ $item->nameRu }}"
                               data-ka="{{ $item->nameKa }}"
                               data-en="{{ $item->nameEn }}"
                               data-code="{{ $item->code }}">
                                <i data-feather="edit" class="svg-10"></i>
                            </a>
                            <a href="#delete_geo_code{{$item->id}}" data-toggle="modal" class="btn btn-sm"><i data-feather="trash-2" class="svg-10"></i></a>
                        </td>
                        @endif
                    </tr>
                    <div class="modal fade" id="update_geo_code2{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <form action="{{route('pages.classifiers.geoobjectcode.update', $item->id)}}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel4">@lang('text.obyekt_kodini_taxrirlash')</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i data-feather="x"></i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row-sm">
                                            <div class="form-group col-sm-12">
                                                <label>@lang('text.ozbekcha')</label>
                                                <input id="nameUz" name="nameUz" type="text" class="form-control" value="{{$item->nameUz}}">
                                            </div><!-- col -->
                                            <div class="form-group col-sm-12">
                                                <label>@lang('text.ruscha')</label>
                                                <input id="nameRu" name="nameRu" type="text" class="form-control" value="{{$item->nameRu}}">
                                            </div><!-- col -->
                                            <div class="form-group col-sm-12">
                                                <label>@lang('text.inglizcha')</label>
                                                <input id="nameEn" name="nameEn" type="text" class="form-control" value="{{$item->nameEn}}">
                                            </div><!-- col -->
                                            <div class="form-group col-sm-12">
                                                <label>@lang('text.shartli_birlik_belgisi'):</label>
                                                <input id="code" name="code" type="text" class="form-control" value="{{$item->code}}">
                                            </div><!-- col -->
                                            <div class="form-group col-sm-12">
                                                <label>@lang('text.normativ_hujjati')</label>
                                                <select name="normative_document" class="custom-select form-control select2" style="width: 100%;" required>
                                                    <option value="{{ $item->normative_document_id }}" selected="selected">{{ $item->documentName }}</option>
                                                    @foreach($normative_documents as $itemdoc)
                                                        <option value="{{$itemdoc->id}}">{{$itemdoc->nameUz}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- col -->

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">@lang('text.bekor_qilish')</button>
                                        <button type="submit" class="btn btn-success">@lang('text.saqlash')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="delete_geo_code{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
                        <form action="{{route('pages.classifiers.geoobjectcode.delete', $item->id)}}" method="post">
                            @csrf
                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel5">@lang('text.ochirish')</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i data-feather="x"></i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mg-b-0">@lang('text.siz_haqiqatdan_ushbu_malumotni_ochirasizmi')</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('text.bekor_qilish')</button>
                                        <button type="submit" class="btn btn-danger">@lang('text.saqlash')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </tbody>
        </table>
        {{ $geocodes->links() }}
    </div>

    <div class="modal fade" id="add_geo_code" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('pages.classifiers.geoobjectcode.store')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel4">@lang('text.obyekt_kodini_qoshish')</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i data-feather="x"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row row-sm">
                            <div class="form-group col-sm-12">
                                <label>@lang('text.ozbekcha')</label>
                                <input name="nameUz" type="text" class="form-control">
                            </div><!-- col -->
                            <div class="form-group col-sm-12">
                                <label>@lang('text.ruscha')</label>
                                <input name="nameRu" type="text" class="form-control">
                            </div><!-- col -->
                            <div class="form-group col-sm-12">
                                <label>@lang('text.inglizcha')</label>
                                <input name="nameEn" type="text" class="form-control">
                            </div><!-- col -->

                            <div class="form-group col-sm-12">
                                <label>@lang('text.shartli_birlik_belgisi'):</label>
                                <input name="code" type="text" class="form-control">
                            </div><!-- col -->
                            <div class="form-group col-sm-12">
                                <label>@lang('text.normativ_hujjati')</label>
                                <select name="normative_document"  class="custom-select form-control select2" style="width: 100%;" required>
                                    <option value="" disabled selected="">@lang('text.normativ_hujjati')</option>
                                    @foreach($normative_documents as $item)
                                        <option value="{{$item->id}}">{{$item->nameUz}}</option>
                                    @endforeach
                                </select>
                            </div><!-- col -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">@lang('text.bekor_qilish')</button>
                        <button type="submit" class="btn btn-success">@lang('text.saqlash')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{{--    <div class="modal fade" id="update_geo_code" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <form action="{{route('pages.classifiers.geoobjectcode.update')}}" method="post">--}}
{{--                    @csrf--}}
{{--                    <div class="modal-header">--}}
{{--                        <h6 class="modal-title" id="exampleModalLabel4">Янги географик объект коди қўшиш</h6>--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                            <span aria-hidden="true"><i data-feather="x"></i></span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="row row-sm">--}}
{{--                            <input id="id" name="id" type="hidden" class="form-control">--}}
{{--                            <div class="form-group col-sm-12">--}}
{{--                                <label>Ўзбекча номланиши</label>--}}
{{--                                <input id="nameUz" name="nameUz" type="text" class="form-control">--}}
{{--                            </div><!-- col -->--}}
{{--                            <div class="form-group col-sm-12">--}}
{{--                                <label>Қарақалпақша номланиши</label>--}}
{{--                                <input id="nameKa" name="nameKa" type="text" class="form-control">--}}
{{--                            </div><!-- col -->--}}
{{--                            <div class="form-group col-sm-12">--}}
{{--                                <label>Русча номланиши</label>--}}
{{--                                <input id="nameRu" name="nameRu" type="text" class="form-control">--}}
{{--                            </div><!-- col -->--}}
{{--                            <div class="form-group col-sm-12">--}}
{{--                                <label>Инглизча номланиши</label>--}}
{{--                                <input id="nameEn" name="nameEn" type="text" class="form-control">--}}
{{--                            </div><!-- col -->--}}
{{--                            <div class="form-group col-sm-12">--}}
{{--                                <label>Шартли бирлик белгиси:</label>--}}
{{--                                <input id="code" name="code" type="text" class="form-control">--}}
{{--                            </div><!-- col -->--}}
{{--                            <div class="form-group col-sm-12">--}}
{{--                                <label>Норматив Ҳужжати</label>--}}
{{--                                <select name="normative_document" class="custom-select form-control select2-no-search" style="width: 100%;" required>--}}
{{--                                    <option value="" disabled selected="">Норматив Ҳужжати</option>--}}
{{--                                    @foreach($normative_documents as $item)--}}
{{--                                        <option value="{{$item->id}}">{{$item->nameUz}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div><!-- col -->--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="button" class="btn btn-light" data-dismiss="modal">Бекор қилиш</button>--}}
{{--                        <button type="submit" class="btn btn-success">Сақлаш</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection


@section('scripts')
    <script src="{{asset('assets/js/vue.js')}}"></script>
    <script src="{{asset('assets/js/axios.min.js')}}"></script>

    <script>
        $(document).on("click", ".open_update_geo_code", function () {
            var id = $(this).data('id');
            $(".modal-body #id").val( id );
            var nameUz = $(this).data('uz');
                $(".modal-body #nameUz").val( nameUz );
            var nameRu = $(this).data('ru');
            $(".modal-body #nameRu").val( nameRu );
            var nameKa = $(this).data('ka');
                $(".modal-body #nameKa").val( nameKa );
            var nameEn = $(this).data('en');
                $(".modal-body #nameEn").val( nameEn );
            var code = $(this).data('code');
                $(".modal-body #code").val( code );

            // var doc = $(this).data('doc');
            // var option_doc = $('#option_doc').value;
            // for (let i = 0; i < option_doc.length; i++) {
            //     if(doc === option_doc[i]){
            //         $("#option_doc").setAttribute("selected");
            //     }
            // }


        });
    </script>

    <script>
        // Adding placeholder for search input
        (function($) {

            'use strict'

            var Defaults = $.fn.select2.amd.require('select2/defaults');

            $.extend(Defaults.defaults, {
                searchInputPlaceholder: ''
            });

            var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');

            var _renderSearchDropdown = SearchDropdown.prototype.render;

            SearchDropdown.prototype.render = function(decorated) {

                // invoke parent method
                var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));

                this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));

                return $rendered;
            };

        })(window.jQuery);


        $(function() {

            'use strict'

            // The code below is for demo purposes only.
            // For you to not be confused, please refer to
            // Off-Canvas starter template in Collections

            $('.off-canvas-menu').on('click', function(e) {
                e.preventDefault();
                var target = $(this).attr('href');
                $(target).addClass('show');
            });


            $('.off-canvas .close').on('click', function(e) {
                e.preventDefault();
                $(this).closest('.off-canvas').removeClass('show');
            })

            $(document).on('click touchstart', function(e) {
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

            $('#example1').DataTable({
                responsive: false,
                language: {
                    searchPlaceholder: 'Излаш...',
                    sSearch: '',
                    lengthMenu: '_MENU_ тани кўрсатиш',
                }
            });

            $('#modal6').on('show.bs.modal', function(event) {

                var animation = $(event.relatedTarget).data('animation');
                $(this).addClass(animation);
            })

            // hide modal with effect
            $('#modal6').on('hidden.bs.modal', function(e) {
                $(this).removeClass(function(index, className) {
                    return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
                });
            });

            // Select2
            $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });


        })

    </script>
@endsection
