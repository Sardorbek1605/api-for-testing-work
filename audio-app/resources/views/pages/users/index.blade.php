@extends('layouts.admin_layout')

@section('styles')

@endsection

@section('content')
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Revenue by location</h4>
                        <div>
                            <i class="material-icons refresh-icon">refresh</i>
                            <i class="material-icons options-icon ml-2">more_vert</i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                    <div class="mdc-layout-grid__inner mt-2">
                        <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-12 mdc-layout-grid__cell--span-8-tablet">
                            <div class="table-responsive">
                                <table class="table dashboard-table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="flag-icon-container"><i
                                                    class="flag-icon flag-icon-us mr-2"></i></span>United
                                            States
                                        </td>
                                        <td>$1,671.10</td>
                                        <td class=" font-weight-medium"> 39%</td>
                                    </tr>
                                    <tr>
                                        <td><span class="flag-icon-container"><i
                                                    class="flag-icon flag-icon-ph mr-2"></i></span>Philippines
                                        </td>
                                        <td>$1,064.75</td>
                                        <td class=" font-weight-medium"> 30%</td>
                                    </tr>
                                    <tr>
                                        <td><span class="flag-icon-container"><i
                                                    class="flag-icon flag-icon-gb mr-2"></i></span>United
                                            Kingdom
                                        </td>
                                        <td>$1,055.98</td>
                                        <td class=" font-weight-medium"> 45%</td>
                                    </tr>
                                    <tr>
                                        <td><span class="flag-icon-container"><i
                                                    class="flag-icon flag-icon-ca mr-2"></i></span>Canada
                                        </td>
                                        <td>$1,045.49</td>
                                        <td class=" font-weight-medium"> 80%</td>
                                    </tr>
                                    <tr>
                                        <td><span class="flag-icon-container"><i
                                                    class="flag-icon flag-icon-fr mr-2"></i></span>France
                                        </td>
                                        <td>$2,050.93</td>
                                        <td class=" font-weight-medium"> 10%</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
