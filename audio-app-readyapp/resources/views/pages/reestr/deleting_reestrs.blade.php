@extends('layout.layout')

@section('styles')
    <style>
        th{
            align-items: center !important;
            vertical-align: middle !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.page')}}">@lang('text.bosh_sahifa')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('text.deleting_reestrs')</li>
    </ol>
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

    <div class="divider-text mg-b-20">@lang('text.deleting_reestrs')</div>

    <div class="form-settings max-width-100">
        <table class="table table-hover table-bordered">
            <thead class="bg-blue">
            <tr class="table-active">
                <th>№</th>
                <th>@lang('text.nomi')</th>
                <th>@lang('text.royhattan_otgan_raqami')</th>
                <th>@lang('text.geografik_obyekt_turi')</th>
                <th>@lang('text.geografik_obyekt_kodi')</th>
                <th>@lang('text.viloyat')</th>
                <th>@lang('text.tuman')</th>
                <th>@lang('text.shahar')</th>
                <th class="wd-15p">@lang('text.normativ_hujjati')</th>
                <th>@lang('text.mavjudligi')</th>
                @if(!$user->hasRole('observer'))
                    <th>@lang('text.korish')</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($reestrs as $key=>$item)
                <tr class="table-card">
                    <td>{{ $reestrs->firstItem() + $key }}</td>
                    <td>{{ $item->nameUz }}</td>
                    <td>{{ $item->register_number }}</td>
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
                    <td class="text-center"><div class="badge badge-{{ $item->isHave==1?'success':'danger' }}"><i class="fa fa-{{ $item->isHave==1?'check':'times' }}"></i></div></td>
                    @if(!$user->hasRole('observer'))
                        <td class="text-center">
                            <a href="{{ route('pages.reestr.view', $item->id) }}" title="Ko'rish" class="btn btn-sm">
                                <i data-feather="eye" class="svg-14"></i>
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $reestrs->appends(request()->query())->links() }}

    </div><!-- form-settings -->
@endsection

@section('scripts')

@endsection



