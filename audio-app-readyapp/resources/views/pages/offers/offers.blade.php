@extends('layout.layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.page')}}">@lang('text.bosh_sahifa')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('text.takliflar')</li>
    </ol>
@endsection

@section('extra')

@endsection

@section('styles')
    <style>
        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active-accordion, .accordion:hover {
            background-color: #ccc;
        }

        .accordion:after {
            content: '\002B';
            color: #777;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        .active-accordion:after {
            content: "\2212";
        }

        .panel {
            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }
    </style>
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

    <div class="divider-text mg-b-20">@lang('text.takliflar')</div>

    <form action="{{ route('pages.offers.index') }}" method="get">
        <div class="row justify-content-end">
            <div class="form-group col-sm-3">
                <select name="status" class="custom-select form-control select2-no-search">
                    <option value="" disabled selected>@lang('text.taklif_holati')</option>
                    <option value="0">Барчаси</option>
                    @foreach($statuses as $item)
                        <option value="{{ $item->id }}">{{ $item->status_name }}</option>
                    @endforeach
                </select>
            </div><!-- col -->
            <div class="form-group col-sm-1">
                <button class="btn btn-success"><i data-feather="search" class="svg-14 te"></i></button>
            </div><!-- col -->
        </div>
    </form>


    <div class="form-settings max-width-100">
        @if(!empty($offers))
            @foreach($offers as $key=>$item)
                <button class="accordion mb-3">{{ $offers->firstItem() + $key }}. {{ $item->user->full_name??"" }}
                    <span class="badge badge-pill {{ $item->status_id==1?'badge-info':($item->status_id==2?'badge-success':'badge-danger') }} ml-3">{{ $item->status->status_name }}</span>
                </button>
                <div class="panel">
                    <h5>@lang('text.reestr'): </h5>
                    <p>{{ $item->reestr->nameUz??"" }}</p>
                    <p>{{ $item->reestr->region->nameUz??"" }}, {{ $item->reestr->district->nameUz??"" }}</p>
                    <hr>
                    <h5>@lang('text.taklif'): </h5>
                    <p>{{ $item->offer??"" }}</p>
                    <hr>
                    <h5>@lang('text.taklif_uchun_asos_boladigan_hujjat'): </h5>
                    <p>{{ $item->document??"" }}</p>
                    <hr>
                    <h5>@lang('text.xujjat'): </h5>
                    <p>
                    @if(!empty($item->file))
                        <form action="{{ route('pages.offers.get-pdf', $item->id) }}" method="post">
                            @csrf
                            <button class="btn btn-sm te" type="submit">
                                <i data-feather="file-text" class="svg-14 te"></i><span> {{ $item->file_name }}</span>
                            </button>
                        </form>
                    @else
                        <button class="btn btn-sm te" type="button">
                            <i data-feather="file-text" class="svg-14 te"></i><span> @lang('text.hujjat_biriktirilmagan')</span>
                        </button>
                        @endif
                        </p>
                        @if(!$user->hasRole('observer'))
                            @if($item->status_id==1)
                                <hr>
                                <a href="#accet{{$item->id}}" class="btn btn-success" data-toggle="modal" type="submit" id="accept" >
                                    <i data-feather="check" class="svg-14 te"></i>@lang('text.qabul_qilindi')
                                </a>
                                <a href="#reject{{$item->id}}" class="btn btn-danger" data-toggle="modal" type="submit" id="reject" >
                                    <i data-feather="x" class="svg-14 te"></i>@lang('text.rad_etildi')
                                </a>
                                <div class="modal fade" id="accet{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
                                    <form action="{{ route('pages.offers.status-accept') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $item->id }}" name="offer_id">
                                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="exampleModalLabel5">@lang('text.qabul_qilindi')</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"><i data-feather="x"></i></span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="mg-b-0">@lang('text.siz_haqiqatdan_taklifni_qabul_qlasizmi')</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">@lang('text.qabul_qilindi')</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('text.bekor_qilish')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal fade" id="reject{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
                                    <form action="{{ route('pages.offers.status-reject') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $item->id }}" name="offer_id">
                                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="exampleModalLabel5">@lang('text.rad_etildi')</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"><i data-feather="x"></i></span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="mg-b-0">@lang('text.siz_haqiqatdan_taklifni_rad_qlasizmi')</p>
                                                    <hr>
                                                    <label for="reject_data">@lang('text.rad_qilish_sababi'): </label>
                                                    <textarea type="text" class="form-control" name="reject_data" id="reject_data" placeholder="Рад қилиш сабабини кўрсатинг" required></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">@lang('text.rad_etildi')</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('text.bekor_qilish')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endif
                        <hr>
                </div>
            @endforeach
            {{ $offers->links() }}
        @endif
    </div><!-- form-settings -->
@endsection

@section('scripts')
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active-accordion");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>
@endsection



