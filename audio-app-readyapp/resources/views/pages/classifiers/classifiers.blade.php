@php $user = \Illuminate\Support\Facades\Auth::user() @endphp
@extends('layout.layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.page')}}">@lang('text.bosh_sahifa')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('text.klassifikatorlar')</li>
    </ol>
@endsection

@section('extra')
{{--    @if(!$user->hasRole('observer'))--}}
{{--        <div class="d-none d-sm-flex">--}}
{{--            <a class="btn btn-success  mg-sm-r-30" type="button" href="#add_tasnif" data-toggle="modal">--}}
{{--                <i data-feather="plus" class="svg-14"></i> Қўшиш--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    @endif--}}
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
    <div class="btn-group mr-2" role="group" aria-label="First group">
        <span class="btn bd-0-f"><i class="mg-r-15" data-feather="code"></i> @lang('text.tasniflar')</span>
        <span class="btn bd-0-f"> <i class="mg-r-15 " data-feather="git-commit"></i> @lang('text.malumotnomalar')</span>
    </div>
    <div class="divider-text mg-b-20">@lang('text.davlat_tasnifi_va_malumotnomalari')</div>
    <div class="form-settings max-width-100">
        <ul class="list-group">
            <li class="list-group-item d-flex align-items-center bd-0-f">
                <i class="wd-30 mg-r-15 mg-b-15" data-feather="code"></i>
                <div>
                    <a href="{{route('pages.classifiers.soato')}}" class="tx-gray-800">
                        <h6 class="tx-14 tx-dark tx-semibold mg-b-0" id="tasnif">
{{--                            <span class="short-name" id="short-name">МҲОБТ</span> |--}}
                            <span class="full-name" id="full-name">@lang('text.mamuriy_hududiy_tuzulmalar')</span>
                        </h6>
                        <span class="d-block tx-10 tx-color-04 mg-t-5">@lang('text.songi_yangilanish'): 07.02.2020</span>
                    </a>
                </div>
            </li>
            <li class="list-group-item d-flex align-items-center bd-0-f">
                <i class="wd-30 mg-r-15 mg-b-15" data-feather="code"></i>
                <div>
                    <a href="{{route('pages.classifiers.dbibt')}}" class="tx-gray-800">
                        <h6 class="tx-14 tx-dark tx-semibold mg-b-0">
{{--                            <span class="short-name" id="short-name">ДБИБТ</span> | --}}
                            <span class="full-name" id="full-name">@lang('text.davlat_va_xojalik_boshqaruvi')</span>
                        </h6>
                        <span class="d-block tx-10 tx-color-04 mg-t-5">@lang('text.songi_yangilanish'): 07.02.2020</span>
                    </a>
                </div>
            </li>
            <li class="list-group-item d-flex align-items-center bd-0-f">
                <i class="wd-30 mg-r-15 mg-b-15" data-feather="code"></i>
                <div>
                    <a href="{{route('pages.classifiers.geoobjectype')}}" class="tx-gray-800">
                        <h6 class="tx-14 tx-dark tx-semibold mg-b-0">
{{--                            <span class="short-name" id="short-name">ГОТБТ</span> | --}}
                            <span class="full-name" id="full-name">@lang('text.geografik_obyekt_turlarini__belgilash')</span></h6>
                        <span class="d-block tx-10 tx-color-04 mg-t-5">@lang('text.songi_yangilanish'): 07.02.2020</span>
                    </a>
                </div>
            </li>
            <li class="list-group-item d-flex align-items-center bd-0-f">
{{--                <i class="wd-30 mg-r-15 mg-b-15" data-feather="git-commit"></i>--}}
                <i class="wd-30 mg-r-15 mg-b-15" data-feather="code"></i>
                <div>
                    <a href="{{route('pages.classifiers.geoobjectcode')}}" class="tx-gray-800">
                        <h6 class="tx-14 tx-dark tx-semibold mg-b-0">
{{--                            <span class="short-name" id="short-name">ГОКБТ</span> | --}}
                            <span class="full-name" id="full-name">@lang('text.geografik_obyekt_kodlarini_belgilash')</span></h6>
                        <span class="d-block tx-10 tx-color-04 mg-t-5">@lang('text.songi_yangilanish'): 07.02.2020</span>
                    </a>
                </div>
            </li>
        </ul>
    </div><!-- form-settings -->



@endsection

@section('modal')
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


