@extends('layout.layout')
@section('title')
    <title>Маъмурий ҳудудий тузилмаларни (объектларни) белгилаш тизими | Geonames</title>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.page')}}">Бош саҳифа</a></li>
        <li class="breadcrumb-item"><a href="{{route('pages.classifiers.index')}}">Классификаторлар</a></li>
        <li class="breadcrumb-item"><a href="{{route('pages.classifiers.soato')}}">Маъмурий ҳудудий тузилмаларни (объектларни) белгилаш
                тизими</a></li>
        <li class="breadcrumb-item active" aria-current="page">Маъмурий ҳудудий тузилмаларни (объектларни) белгилаш
            тизими ({!! $uz_district->uz_region->nameUz !!}  , {!! $uz_district->nameUz  !!})
        </li>
    </ol>
@endsection
@section('content')
    <div class="alert alert-success hidden" role="alert">
        Янги маълумотнома муваффақиятли қўшилди!
    </div>
    <div class="btn-group mr-2" role="group" aria-label="First group">
        <span class="btn bd-0-f"><i class="mg-r-15" data-feather="code"></i> Таснифлар</span>
        <span class="btn bd-0-f"> <i class="mg-r-15 " data-feather="git-commit"></i> Маълумотномалар</span>
    </div>
    <div class="divider-text mg-b-20">Маъмурий ҳудудий тузилмаларни (объектларни) белгилаш тизими</div>
    <div class="table-responsive">
        <table class="table fold-table">
            <thead class="thead-geonames">
            <tr>
                <th>Ҳудуд номи</th>
                <th>Почта индекси</th>
            </tr>
            </thead>
            <tbody>
            @foreach($uz_punkts as $item)
                <tr class="view">
                    <td>{{$item->name}}</td>
                    <td>{{$item->index}}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
    {{ $uz_punkts->links() }}

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
