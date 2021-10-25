@extends('layout.layout')

@section('styles')
    <style>
        th {
            align-items: center !important;
            vertical-align: middle !important;
        }
    </style>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.page')}}">@lang('text.bosh_sahifa')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('text.reestr')</li>
    </ol>
@endsection

@section('extra')
    @if(!$user->hasRole('observer'))
        <div class="d-none d-sm-flex">
            <a class="btn btn-success  mg-sm-r-30" type="button" href="{{route('pages.reestr.create')}}">
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
    <div class="divider-text mg-b-20">@lang('text.reestr')</div>

    <form>
        <div class="row" id="app">
            <div class="col-md-12 d-flex">
                <div class="form-group col-sm-2">
                    <select name="region"
                            id="region"
                            @change="GetDistricts"
                            class="custom-select form-control select2-no-search"
                            style="width: 100%;"
                            v-model="region"
                    >
                        <option value="" selected="">@lang('text.viloyat')</option>
                        @foreach($regions as $item)
                            <option value="{{$item->regionid}}">{{$item->nameUz}}</option>
                        @endforeach
                    </select>
                </div><!-- col -->
                <div class="form-group col-sm-2">
                    <select name="district[]"
                            multiple
                            data-live-search="true"
                            id="district"
                            title="Туман"
                            class="form-control selectpicker"
                            style="width: 100%; "
                        {{--                            v-model="district"--}}
                    >
                        {{--                        <option v-for="item in districts" :value="item.areaid" :id="item.id" >@{{ item.nameUz }}</option>--}}
                    </select>
                </div><!-- col -->
                <div class="form-group col-sm-2">
                    <input type="text" name="name" class="form-control" placeholder="Номи"
                           value="{{ $allRequests->name??'' }}">
                </div>
                <div class="form-group col-sm-2">
                    <input type="text" name="register_number" class="form-control" placeholder="Рўйҳатдан ўтган рақами"
                           value="{{ $allRequests->register_number??'' }}">
                </div>
                <div class="form-group col-sm-2">
                    <select name="geoobject_type[]" class="form-control selectpicker" data-live-search="true"
                            title="Географик объект тури" multiple="multiple">
                        @foreach($geoobject_types as $item)
                            @if(!empty($allRequests->geoobject_type))
                                <option value="{{ $item->id }}" @foreach($allRequests->geoobject_type as $i) @if($item->id==$i) selected @endif @endforeach>{{ $item->nameUz }}</option>
                            @else
                                <option value="{{ $item->id }}">{{ $item->nameUz }}</option>
                            @endif
                        @endforeach
                    </select>
                </div><!-- col -->
                <div class="form-group col-sm-1 text-center">
                    <button type="submit" class="btn btn-success" style="width: 100%"><i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="form-group col-sm-1 text-center">
                    <a href="{{ route('pages.reestr.index') }}" class="btn btn-white" style="width: 100%"><i
                            data-feather="refresh-cw" class="svg-12"></i></a>
                </div>
            </div>
        </div>
    </form>

    <div class="form-settings max-width-100">
        <table class="table table-hover table-bordered">
            <thead class="bg-blue">
            <tr class="table-active">
                <th>№</th>
                {{--                <th>Код</th>--}}
                <th>@lang('text.nomi')</th>
                <th>@lang('text.royhattan_otgan_raqami')</th>
                {{--                <th>Адрес</th>--}}
                <th>@lang('text.geografik_obyekt_turi')</th>
                <th>@lang('text.geografik_obyekt_kodi')</th>
                <th>@lang('text.viloyat')</th>
                <th>@lang('text.tuman')</th>
                <th>@lang('text.shahar')</th>
                <th class="wd-15p">@lang('text.normativ_hujjati')</th>
                <th>@lang('text.mavjudligi')</th>
                @if(!$user->hasRole('observer'))
                    <th>@lang('text.korish')</th>
                    <th>@lang('text.togirlash')</th>
                    <th>@lang('text.tarixiy_nom_kiritish')</th>
                    <th>@lang('text.ochirish')</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($reestrs as $key=>$item)
                <tr class="table-card">
                    <td>{{ $reestrs->firstItem() + $key }}</td>
                    {{--                    <td>{{ $item->code }}</td>--}}
                    <td>{{ $item->nameUz }}</td>
                    <td>{{ $item->register_number }}</td>
                    {{--                    <td>{{ $item->address }}</td>--}}
                    <td>{{ $item->geotype->nameUz }}</td>
                    <td>{{ $item->geotype->geoobject_code->nameUz }}</td>
                    <td>{{ $item->region->nameUz }}</td>
                    @if($item->district)
                        <td>{{ $item->district->nameUz }}</td>
                    @else
                        <td></td>
                    @endif
                    @if($item->punkt)
                        <td>{{ $item->punkt->nameUz }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{$item->normative_document!=null?$item->normative_document->nameUz:''}}</td>
                    <td class="text-center">
                        <div class="badge badge-{{ $item->isHave==1?'success':'danger' }}"><i
                                class="fa fa-{{ $item->isHave==1?'check':'times' }}"></i></div>
                    </td>
                    @if(!$user->hasRole('observer'))
                        <td class="text-center">
                            <a href="{{ route('pages.reestr.view', $item->id) }}" title="Ko'rish" class="btn btn-sm">
                                <i data-feather="eye" class="svg-14"></i>
                            </a>
                            {{--                            <a href="#" class="btn btn-smmg-l-2" data-toggle="modal">--}}
                            {{--                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"--}}
                            {{--                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"--}}
                            {{--                                     stroke-linejoin="round" class="feather feather-trash-2 svg-10">--}}
                            {{--                                    <polyline points="3 6 5 6 21 6"></polyline>--}}
                            {{--                                    <path--}}
                            {{--                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>--}}
                            {{--                                    <line x1="10" y1="11" x2="10" y2="17"></line>--}}
                            {{--                                    <line x1="14" y1="11" x2="14" y2="17"></line>--}}
                            {{--                                </svg>--}}
                            {{--                            </a>--}}
                        </td>
                        <td class="text-center">
                            <a href="{{route('pages.reestr.edit',[$item->id, 'page'=>$reestrs->currentPage()])}}"
                               title="To'g'irlash" class="btn btn-sm">
                                {{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"--}}
                                {{--                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"--}}
                                {{--                                         stroke-linejoin="round" class="feather feather-edit svg-10">--}}
                                {{--                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>--}}
                                {{--                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>--}}
                                {{--                                    </svg>--}}
                                <i data-feather="edit" class="svg-14"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pages.reestr.add.oldName', [$item->id, 'page'=>$reestrs->currentPage()]) }}"
                               title="Eski nomni kiritish" class="btn btn-sm">
                                {{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"--}}
                                {{--                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"--}}
                                {{--                                         stroke-linejoin="round" class="feather feather-edit svg-10">--}}
                                {{--                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>--}}
                                {{--                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>--}}
                                {{--                                    </svg>--}}
                                <i data-feather="edit" class="svg-14"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="#deleteReestr{{ $item->id }}" data-toggle="modal" class="btn btn-sm">
                                <i data-feather="trash-2" class="svg-14"></i>
                            </a>
                        </td>
                        <div class="modal fade" id="deleteReestr{{ $item->id }}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel5"
                             aria-hidden="true">
                            <form action="{{route('pages.reestr.delete', $item->id)}}" method="post">
                                @csrf
                                @method('PUT')
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
                                            <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">@lang('text.bekor_qilish')</button>
                                            <button type="submit" class="btn btn-danger">@lang('text.ochirish')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                </tr>

            @endforeach
            </tbody>

        </table>
        {{ $reestrs->appends(request()->query())->links() }}

    </div><!-- form-settings -->
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.selectpicker').selectpicker();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function ($) {
            var req = [];
            @if(!empty($allRequests->district))
                req = [@foreach($allRequests->district as $item) {!! $item !!}, @endforeach];
                console.log(req)
            @endif

            $('#region').change(function () {
                req = [];
                var reg = $(this).val();
                if (reg) {
                    $.ajax({
                        type: "get",
                        url: "{{ route('pages.reestr.GetDistricts') }}/?regionid=" + reg,
                        success: function (res) {
                            $("#district").empty();
                            // $("#district").append('<option>--Select Area--</option>');
                            if (res) {
                                $.each(res, function (key, value) {
                                    $('#district').append($("<option/>", {
                                        value: value.areaid,
                                        text: value.nameUz
                                    }));
                                });
                                $('.selectpicker').selectpicker('refresh');
                            }
                        }
                    });
                }
            });
           if(req.length != 0) {
                function inArray(needle, haystack) {
                    var length = haystack.length;
                    for(var i = 0; i < length; i++) {
                        if(haystack[i] == needle) return true;
                    }
                    return false;
                }

                var reg = $("#region").val();
                if (reg) {
                    $.ajax({
                        type: "get",
                        url: "{{ route('pages.reestr.GetDistricts') }}/?regionid=" + reg,
                        success: function (res) {
                            $("#district").empty();
                            // $("#district").append('<option>--Select Area--</option>');
                            if (res) {
                                $.each(res, function (key, value) {
                                    $('#district').append($("<option/>", {
                                        value: value.areaid,
                                        text: value.nameUz,
                                        selected: inArray(value.areaid, req)?'selected':($.removeAttr('selected'))
                                    }));
                                });
                                $('.selectpicker').selectpicker('refresh');
                            }
                        }
                    });
                }
            }
        });
    </script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                region: '',
                district: '',
                districts: [],
            },
            methods: {
                GetDistricts: function () {
                    axios.get('{{route('pages.reestr.GetDistricts')}}', {
                        params: {
                            regionid: app.region
                        }
                    })
                        .then(function (response) {
                            app.districts = response.data;
                            $(document).ready(function () {
                                $('.select2').select2({
                                    placeholder: 'Select an option'
                                });
                                $('.selectpicker').selectpicker('refresh');
                            });
                        })
                        .catch(function (error) {
                            console.log(error);
                        })
                },
            },
            created() {
            },
            mounted() {
                this.region = @json($allRequests->region??'');
                @if (!empty($allRequests->district))
                    @foreach($allRequests->district as $item)
                if (this.district === {{ $item }}) {
                    this.district = @json($allRequests->district);
                }
                @endforeach
                @endif
            }
        })
    </script>
    <script>
        // $(document).ready(function() {
        //     var option = $
        // });
    </script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: '@lang('text.geografik_obyekt_turi')',
                tags: true,
                tokenSeparators: [',', ' ']
            });
        });
    </script>
@endsection



