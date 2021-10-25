@extends('layout.layout')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.page')}}">@lang('text.bosh_sahifa')</a></li>
        <li class="breadcrumb-item"><a href="{{route('pages.reestr.index')}}">@lang('text.reestr')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('text.reestrga_malumot_qoshish')</li>
    </ol>
@endsection

@section('styles')
    <style>
        .isHave-checkbox{
            width: 35px;
            height: 35px;
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
    <div class="divider-text mg-b-20">@lang('text.reestrga_malumot_qoshish')</div>
    <div class="form-settings max-width-100" id="app">
        <form action="{{route('pages.reestr.store')}}" method="post">
            <div class="row row-sm">
                @csrf
                <div class="form-group col-sm-6">
                    <label>@lang('text.normativ_hujjati')</label>
                    <select name="normative_document"  class="custom-select form-control select2" style="width: 100%;" required>
                        <option value="" disabled selected="">@lang('text.normativ_hujjati')</option>
                        @foreach($normative_documents as $item)
                            <option value="{{$item->id}}">{{$item->nameUz}}</option>
                        @endforeach
                    </select>
                </div><!-- col -->
                <div class="form-group col-sm-4">
                    <label>@lang('text.nomi')</label>
                    <input name="name" value="{{ old('name')}}"  type="text" class="form-control" placeholder="@lang('text.nomi')">
                </div><!-- col -->
                <div class="form-group col-sm-2">
                    <label>@lang('text.mavjudligi')</label>
                    <div>
                        <input type="checkbox" class="isHave-checkbox" name="isHave" value="1" checked>
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <label>@lang('text.nomi_uz')</label>
                    <input name="name_uz" value="{{ old('name_uz')}}" type="text" class="form-control" placeholder="@lang('text.nomi_uz')">
                </div><!-- col -->
{{--                <div class="form-group col-sm-4">--}}
{{--                    <label>Номи Ру</label>--}}
{{--                    <input name="name_ru" value="{{ old('name_ru')}}" type="text" class="form-control" placeholder="Номи">--}}
{{--                </div><!-- col -->--}}
{{--                <div class="form-group col-sm-3">--}}
{{--                    <label>Адрес</label>--}}
{{--                    <input name="address" value="{{ old('address')}}"  type="text" class="form-control" placeholder="Адрес">--}}
{{--                </div><!-- col -->--}}
{{--                <div class="form-group col-sm-3">--}}
{{--                    <label>Рўйхатдан ўтган рақами</label>--}}
{{--                    <input name="register_number" value="{{ old('register_number')}}"  type="text" class="form-control" placeholder="Рўйхатдан ўтган рақами">--}}
{{--                </div><!-- col -->--}}
                <div class="form-group col-sm-4">
                    <label>@lang('text.geografik_obyekt_guruhi')</label>
                    <select name="geocode"
                            class="custom-select form-control"
                            @change="GetGeoType"
                            style="width: 100%;"
                            v-model="geocode">
                        <option value="" disabled selected="">@lang('text.geografik_obyekt_guruhi')</option>
                        @foreach($geocodes as $item)
                            <option value="{{$item->id}}">{{$item->nameUz}}</option>
                        @endforeach
                    </select>
                </div><!-- col -->
                <div class="form-group col-sm-4">
                    <label>@lang('text.geografik_obyekt_turi')</label>
                    <select name="geotype"
                            class="custom-select form-control"
                            style="width: 100%;"
                            v-model="geotype">
                        <option value="" disabled selected="">@lang('text.geografik_obyekt_turi')</option>
                        <option v-for="item in geotypes" :value="item.id">@{{ item.nameUz }}</option>
                    </select>
                </div><!-- col -->
                <div class="form-group col-sm-4">
                    <label>@lang('text.viloyat')</label>
                    <select name="region"
                            class="custom-select form-control"
                            @change="GetDistricts"
                            style="width: 100%;"
                            v-model="region">
                        <option value="" disabled selected="">@lang('text.viloyat')</option>
                        @foreach($regions as $item)
                            <option value="{{$item->regionid}}">{{$item->nameUz}}</option>
                        @endforeach
                    </select>
                </div><!-- col -->
                <div class="form-group col-sm-4">
                    <label>@lang('text.tuman')</label>
                    <select name="district"
                            class="custom-select form-control"
                            @change="GetPunkts"
                            style="width: 100%;"
                            v-model="district">
                        <option value="" disabled selected="">@lang('text.tuman')</option>
                        <option v-for="item in districts" :value="item.areaid">@{{ item.nameUz }}</option>
                    </select>
                </div><!-- col -->
                <div class="form-group col-sm-4">
                    <label>@lang('text.shahar')</label>
                    <select name="punkt" class="custom-select form-control"
                            style="width: 100%;"
                            v-model="punkt">
                        <option disabled>@lang('text.shahar')</option>
                        <option v-for="item in punkts" :value="item.cityid">@{{ item.nameUz }}</option>
                    </select>
                </div><!-- col -->
{{--                <div class="form-group col-sm-4">--}}
{{--                    <label>Эски пункт</label>--}}
{{--                    <select name="punkt_old" class="custom-select form-control select2-no-search"--}}
{{--                            style="width: 100%;"--}}
{{--                            v-model="oldpunkt">--}}
{{--                        <option value="" disabled selected="">Эски пункт</option>--}}
{{--                        <option v-for="item in oldpunkts" :value="item.id">@{{ item.name }}</option>--}}
{{--                    </select>--}}
{{--                </div><!-- col -->--}}
                <div class="form-group col-sm-4">
                    <label>@lang('text.royhatdan_otgan_sanasi')</label>
                    <input name="reg_date" class="form-control date-withicon" readonly id="datepicker" placeholder="Select Date">
                </div><!-- col -->
                <div class="form-group col-sm-8">
                    <label>@lang('text.geografik_obyekt_joylashgan_hudud')</label>
                    <input name="territory" type="text" class="form-control" placeholder="@lang('text.geografik_obyekt_joylashgan_hudud')">
                </div><!-- col -->
                <div class="form-group col-sm-12">
                    <label>@lang('text.izohlar')</label>
                    <textarea name="comment" type="text" class="form-control" placeholder="Изоҳлар"></textarea>
                </div><!-- col -->
                <!-- Longitude and Lotitudes -->
                <div class="form-group col-sm-12">
                    <label>@lang('text.kenglik')</label>
                    <div class="row d-flex">
                        <div class="form-group col-sm-3">
                            <input name="grad-lat" value="0" type="number" class="form-control" placeholder="grad" >
                        </div>
                        <div class="form-group col-sm-3">
                            <input name="min-lat" value="0" type="number" class="form-control" placeholder="min" >
                        </div>
                        <div class="form-group col-sm-3">
                            <input name="sec-lat" value="0" type="number" class="form-control" placeholder="sec" >
                        </div>
                    </div>
                </div><!-- col -->
                <div class="form-group col-sm-12">
                    <label>@lang('text.uzunlik')</label>
                    <div class="row d-flex">
                        <div class="form-group col-sm-3">
                            <input name="grad-long" value="0" type="number" class="form-control" placeholder="grad" >
                        </div>
                        <div class="form-group col-sm-3">
                            <input name="min-long" value="0" type="number" class="form-control" placeholder="min" >
                        </div>
                        <div class="form-group col-sm-3">
                            <input name="sec-long" value="0" type="number" class="form-control" placeholder="sec" >
                        </div>
                    </div>
                </div><!-- col -->


{{--                <div class="form-group d-none d-sm-flex">--}}
{{--                    <button type="submit" class="btn btn-success  mg-sm-r-30" type="button">--}}
{{--                        <i data-feather="plus" class="svg-14"></i> Қўшиш--}}
{{--                    </button>--}}
{{--                </div>--}}
            </div><!-- form-row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success  mg-sm-r-30" type="button">
                            <i data-feather="plus" class="svg-14"></i> @lang('text.qoshish')
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- form-settings -->
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                geotype: '',
                geocode: '',
                geotypes: [],
                region: '',
                district: '',
                districts: [],
                punkts: [],
                punkt: "@lang('text.shahar')",
                oldpunkts: [],
                oldpunkt:'',
            },
            methods: {
                GetGeoType: function () {
                    axios.get('{{route('pages.reestr.GetGeoType')}}', {
                        params: {
                            id: app.geocode
                        }
                    })
                    .then(function (response) {
                        app.geotypes = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

                },
                GetDistricts: function () {
                    axios.get('{{route('pages.reestr.GetDistricts')}}', {
                        params: {
                            regionid: app.region
                        }
                    })
                    .then(function (response) {
                        app.districts = response.data;
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
                },
                GetPunkts: function () {
                    axios.get('{{route('pages.reestr.GetPunkts')}}', {
                        params: {
                            areaid: app.district
                        }
                    })
                    .then(function (response) {
                        app.punkts = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

                    axios.get('{{route('pages.reestr.GetOldPunkts')}}', {
                        params: {
                            areaid: app.district
                        }
                    })
                    .then(function (response) {
                        app.oldpunkts = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
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
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                autoclose: true,
                dateFormat: 'dd.mm.yy',
            });
        } );
    </script>
@endsection



