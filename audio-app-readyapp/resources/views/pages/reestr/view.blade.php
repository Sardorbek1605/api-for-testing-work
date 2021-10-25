@extends('layout.layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.page')}}">@lang('text.bosh_sahifa')</a></li>
        @if($reestr->isHave==1)
            <li class="breadcrumb-item"><a href="{{route('pages.reestr.index')}}">@lang('text.reestr')</a></li>
        @else
            <li class="breadcrumb-item"><a href="{{route('pages.reestr.index.deletings')}}">@lang('text.deleting_reestrs')</a></li>
        @endif

        <li class="breadcrumb-item active" aria-current="page">@lang('text.reestr_malumotini_korish')</li>
    </ol>
@endsection

@section('content')
    <div class="divider-text mg-b-20">@lang('text.reestr_malumotini_korish')</div>
    <div class="form-settings max-width-100">
        <table class="table table-hover table-bordered table-striped">
            <thead class="bg-blue">
                <tr>
                    <th colspan="2" class="text-center">{{ $reestr->normal_name }} @lang('text.malumotlari')</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>@lang('text.nomi')</b></td>
                    <td>{{ $reestr->normal_name??null }}</td>
                </tr>
                <tr>
                    <td><b>@lang('text.nomi_uz')</b></td>
                    <td>{{ $reestr->nameUz??null }}</td>
                </tr>
{{--                <tr>--}}
{{--                    <td><b>Номи Ру</b></td>--}}
{{--                    <td>{{ $reestr->nameRu??null }}</td>--}}
{{--                </tr>--}}
                <tr>
                    <td><b>@lang('text.kodi')</b></td>
                    <td>{{ $reestr->code??null }}</td>
                </tr>
                <tr>
                    <td><b>@lang('text.viloyat')</b></td>
                    <td>{{ $reestr->region->nameUz??null }}</td>
                </tr>
                <tr>
                    <td><b>@lang('text.tuman')</b></td>
                    <td>{{ $reestr->district->nameUz??null }}</td>
                </tr>
                <tr>
                    <td><b>@lang('text.geografik_obyekt_joylashgan_hudud')</b></td>
                    <td>{{ $reestr->territory??null }}</td>
                </tr>
                <tr>
                    <td><b>@lang('text.registratsiya_nomer')</b></td>
                    <td>{{ $reestr->register_number??null }}</td>
                </tr>
                <tr>
                    <td><b>@lang('text.geografik_obyekt_kodi')</b></td>
                    <td>{{ $reestr->geotype->geoobject_code->nameUz??null }}</td>
                </tr>
                <tr>
                    <td><b>@lang('text.geografik_obyekt_turi')</b></td>
                    <td>{{ $reestr->geotype->nameUz??null }}</td>
                </tr>
                <tr>
                    <td><b>@lang('text.registratsiya_vaqti')</b></td>
                    <td>{{ Carbon\Carbon::parse($reestr->reg_date)->format("d.m.Y") }}</td>
                </tr>
                <tr>
                    <td><b>@lang('text.normativ_hujjati')</b></td>
                    <td>{{ $reestr->normative_document->nameUz??null }}</td>
                </tr>
                <tr>
                    <td><b>@lang('text.normativ_hujjart_vaqti')</b></td>
                    @if($reestr->normative_document!=null)
                        <td>{{ Carbon\Carbon::parse($reestr->normative_document->created_at)->format("d.m.Y") }}</td>
                    @else
                        <td></td>
                    @endif
                </tr>
                <tr>
                    <td><b>@lang('text.izohlar')</b></td>
                    <td>{{ $reestr->comment??null }}</td>
                </tr>
                <tr>
                    <td><b>@lang('text.koordinatalar')</b></td>
                    <td>
                        @if($lat_arr!=null && $long_arr!=null)
                            <strong>@lang('text.kenglik'):</strong> {{ $lat_arr['deg'] }} grad, {{ $lat_arr['min'] }} min, {{ $lat_arr['sec'] }} sek
                            <br>
                            <strong>@lang('text.uzunlik'):</strong> {{ $long_arr['deg'] }} grad, {{ $long_arr['min'] }} min, {{ $long_arr['sec'] }} sek
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-hover table-bordered table-striped">
            <thead class="bg-blue">
                <tr>
                    <th colspan="10" class="text-center">{{ $reestr->normal_name }} @lang('text.tarixiy_nomlari')</th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('text.nomi_uz')</th>
                    <th>@lang('text.viloyat')</th>
                    <th>@lang('text.tuman')</th>
                    <th>@lang('text.registratsiya_nomer')</th>
                    <th>@lang('text.geografik_obyekt_kodi')</th>
                    <th>@lang('text.geografik_obyekt_turi')</th>
                    <th>@lang('text.normativ_hujjati')</th>
                    <th>@lang('text.koordinatalar')</th>
                    <th>@lang('text.ochirish')</th>
                </tr>
            </thead>
            <tbody>
            @foreach($old_reestrs as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nameUz }}</td>
                    <td>{{ $item->region->nameUz }}</td>
                    <td>{{ $item->district->nameUz }}</td>
                    <td>{{ $item->register_number }}</td>
                    <td>{{ $item->geotype->geoobject_code->nameUz }}</td>
                    <td>{{ $item->geotype->nameUz }}</td>
                    <td>{{ $item->normative_document->nameUz }}</td>
                    <td>{{ $item->coordinates }}</td>
                    <td class="text-center">
                        <a href="#deleteOldReestr{{ $item->id }}" data-toggle="modal" class="btn btn-sm">
                            <i data-feather="trash-2" class="svg-14"></i>
                        </a>
                    </td>
                    <div class="modal fade" id="deleteOldReestr{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5"
                         aria-hidden="true">
                        <form action="{{route('pages.reestr.delete.oldName', $item->id)}}" method="post">
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
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('text.bekor_qilish')</button>
                                        <button type="submit" class="btn btn-danger">@lang('text.ochirish')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')

@endsection



