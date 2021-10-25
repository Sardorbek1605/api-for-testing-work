@extends('layout.layout')
@section('title')
    <title>Маъмурий ҳудудий тузилмаларни (объектларни) тузатиш тизими | Geonames</title>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.page')}}">@lang('text.bosh_sahifa')</a></li>
        <li class="breadcrumb-item"><a href="{{route('pages.classifiers.index')}}">@lang('text.klassifikatorlar')</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('pages.classifiers.soato') }}">@lang('text.mamuriy_hududiy_tuzulmalar')</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            @lang('text.mamuriy_hududiy_tuzulmalar_tuzatish')
        </li>
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

    <div class="divider-text mg-b-20">@lang('text.mamuriy_hududiy_tuzulmalar_tuzatish')</div>


    <form action="{{ route('pages.classifiers.soato_edit.get') }}" method="get">
        @csrf
        <div class="row" id="app">
            <div class="col-md-12 d-flex">
                <div class="form-group col-sm-5">
                    <select name="region"
                            @change="GetDistricts"
                            class="custom-select form-control select2-no-search"
                            style="width: 100%;"
                            v-model="region">
                        <option value="" selected="">@lang('text.viloyat')</option>
                        @foreach($regions as $item)
                            <option value="{{$item->regionid}}">{{$item->nameUz}}</option>
                        @endforeach
                    </select>
                </div><!-- col -->
                <div class="form-group col-sm-5">
                    <select name="district"
                            class="custom-select form-control select2-no-search"
                            style="width: 100%;"
                            v-model="district">
                        <option value="" selected="">@lang('text.tuman')</option>
                        <option v-for="item in districts" :value="item.areaid">@{{ item.nameUz }}</option>
                    </select>
                </div><!-- col -->

                <div class="form-group col-sm-2">
                    <button type="submit" style="width: 100%" class="btn btn-success"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </form>




    @if($status==1 && $region!=null)
        <div class="form-settings max-width-100">
            <table class="table table-hover table-bordered">
                <thead class="bg-blue">
                    <tr class="table-active">
                        <th>@lang('text.viloyat')</th>
                        <th>@lang('text.soato')</th>
                        <th>@lang('text.taxrirlash')</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $region->nameUz }}</td>
                        <td>{{ $region->regionid }}</td>
                        <td>
                            <a href="#update_region{{$region->regionid}}" class="btn btn-sm" data-toggle="modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-edit svg-10">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <div class="modal fade" id="update_region{{$region->regionid}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <form action="{{ route('pages.classifiers.soato_edit.update', $region->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="soato" value="{{ $region->regionid }}">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel4">@lang('text.viloyatni_tahrirlash')</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i data-feather="x"></i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row-sm">
                                            <div class="form-group col-sm-12">
                                                <label>@lang('text.nomi_uz')</label>
                                                <input name="nameUz" type="text" class="form-control" value="{{ $region->nameUz }}">
                                            </div><!-- col -->
                                            <div class="form-group col-sm-12">
                                                <label>@lang('text.normativ_hujjati')</label>
                                                <select name="normative_document" class="custom-select form-control select2-no-search" style="width: 100%;" required>
                                                    <option value="" disabled selected="">@lang('text.normativ_hujjati')</option>
                                                    @foreach($normative_documents as $itemdoc)
                                                        <option {{ ($region->normative_document_id!=null?($region->normative_document_id==$itemdoc->id ? 'selected' : ''):'') }} value="{{$itemdoc->id}}">{{$itemdoc->nameUz}}</option>
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
                </tbody>
            </table>
        </div><!-- form-settings -->
    @elseif($status==2 && $district!=null)
        <div class="form-settings max-width-100">
            <table class="table table-hover table-bordered">
                <thead class="bg-blue">
                <tr class="table-active">
                    <th>@lang('text.tuman')</th>
                    <th>@lang('text.soato')</th>
                    <th>@lang('text.taxrirlash')</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $district->nameUz }}</td>
                    <td>{{ $district->areaid }}</td>
                    <td>
                        <a href="#update_district{{ $district->areaid }}" data-toggle="modal" class="btn btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-edit svg-10">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                    </td>
                </tr>
                <div class="modal fade" id="update_district{{ $district->areaid }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <form action="{{ route('pages.classifiers.soato_edit.update', $district->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="soato" value="{{ $district->areaid }}">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLabel4">@lang('text.tumanni_tahrirlash')</h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i data-feather="x"></i></span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row row-sm">
                                        <div class="form-group col-sm-4">
                                            <label>@lang('text.nomi_uz')</label>
                                            <input name="nameUz" type="text" class="form-control" value="{{ $district->nameUz }}">
                                        </div><!-- col -->
                                        <div class="form-group col-sm-4">
                                            <label>Русча номланиши</label>
                                            <input name="nameRu" type="text" class="form-control" value="{{ $district->nameRu }}">
                                        </div><!-- col -->
                                        <div class="form-group col-sm-4">
                                            <label>@lang('text.soato')</label>
                                            <input name="soato" type="number" class="form-control" value="{{ $district->areaid }}">
                                        </div><!-- col -->
                                        @php $old = \App\OldUzDistricts::where('district_id', $district->id)->orderBy('id', 'DESC')->first() @endphp
                                        <div class="form-group col-sm-4">
                                            <label>Tarixiy (avvalgi) Ўзбекча номи</label>
                                            <input type="text" name="oldNameUz" class="form-control" value="{{ $old->nameUz??null }}">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label>Tarixiy (avvalgi) Русча номи</label>
                                            <input type="text" name="oldNameRu" class="form-control" value="{{ $old->nameRu??null }}">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>@lang('text.viloyat')</label>
                                            <select name="region" class="custom-select form-control select2" style="width: 100%;" required>
                                                <option value="" disabled selected="">@lang('text.viloyat')</option>
                                                @foreach($regions as $item)
                                                    <option {{ ($district->regionid!=null?($district->regionid==$item->regionid ? 'selected' : ''):'') }} value="{{$item->regionid}}">{{$item->nameUz}}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- col -->
                                        <div class="form-group col-sm-6">
                                            <label>@lang('text.normativ_hujjati')</label>
                                            <select name="normative_document" class="custom-select form-control select2" style="width: 100%;" required>
                                                <option value="" disabled selected="">@lang('text.normativ_hujjati')</option>
                                                @foreach($normative_documents as $itemdoc)
                                                    <option {{ $district->normative_document_id==$itemdoc->id ? 'selected' : '' }} value="{{$itemdoc->id}}">{{$itemdoc->nameUz}}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- col -->
                                        <div class="form-group col-sm-12">
                                            <label>@lang('text.izohlar')</label>
                                            <textarea name="description" class="form-control">{{ $district->description }}</textarea>
                                        </div>
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
                </tbody>
            </table>
        </div><!-- form-settings -->
    @endif
@endsection
@section('scripts')
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
                        })
                        .catch(function (error) {
                            console.log(error);
                        })
                },
            },
            created() {
            },
            mounted() {
            }
        })
    </script>

    <script>
        (function() {
            $('.select2').select2();
        })();
    </script>

@endsection
