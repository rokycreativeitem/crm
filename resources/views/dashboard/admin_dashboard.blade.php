@extends('layouts.admin')
@push('title', get_phrase('Dashboard'))

@section('content')
    {{-- @php
        $project_id = project_id_by_code(request()->route()->parameter('code'));
        $project = App\Models\Project::where('id', $project_id)->first();
        $resent_projects = App\Models\Project::orderBy('id', 'DESC')->limit(4)->get();

    @endphp --}}
    <div class="admin-dashboard">
        <div class="row mt-4">
            <div class="col-sm-4">
                <div class="row">
                    <div class="dashboard-card">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.1" width="32" height="32" rx="16" fill="#605BFF" />
                            <path
                                d="M22.8173 12.235C22.1798 11.53 21.1148 11.1775 19.5698 11.1775H19.3898V11.1475C19.3898 9.8875 19.3898 8.3275 16.5698 8.3275H15.4298C12.6098 8.3275 12.6098 9.895 12.6098 11.1475V11.185H12.4298C10.8773 11.185 9.81978 11.5375 9.18228 12.2425C8.43978 13.0675 8.46228 14.1775 8.53728 14.935L8.54478 14.9875L8.59724 15.5383C8.6115 15.6881 8.69223 15.8234 8.81829 15.9056C9.00007 16.024 9.26513 16.1935 9.42978 16.285C9.53478 16.3525 9.64728 16.4125 9.75978 16.4725C11.0423 17.1775 12.4523 17.65 13.8848 17.8825C13.9523 18.5875 14.2598 19.4125 15.9023 19.4125C17.5448 19.4125 17.8673 18.595 17.9198 17.8675C19.4498 17.62 20.9273 17.0875 22.2623 16.3075C22.3073 16.285 22.3373 16.2625 22.3748 16.24C22.6568 16.0806 22.9487 15.8862 23.218 15.6935C23.3313 15.6124 23.4035 15.4862 23.4189 15.3477L23.4248 15.295L23.4623 14.9425C23.4698 14.8975 23.4698 14.86 23.4773 14.8075C23.5373 14.05 23.5223 13.015 22.8173 12.235ZM16.8173 17.3725C16.8173 18.1675 16.8173 18.2875 15.8948 18.2875C14.9723 18.2875 14.9723 18.145 14.9723 17.38V16.435H16.8173V17.3725ZM13.6823 11.1775V11.1475C13.6823 9.8725 13.6823 9.4 15.4298 9.4H16.5698C18.3173 9.4 18.3173 9.88 18.3173 11.1475V11.185H13.6823V11.1775Z"
                                fill="#605BFF" />
                            <path
                                d="M22.4541 17.3962C22.8084 17.2294 23.2152 17.5104 23.1798 17.9004L22.9309 20.6425C22.7734 22.1425 22.1584 23.6725 18.8584 23.6725H13.1434C9.84336 23.6725 9.22836 22.1425 9.07086 20.65L8.83515 18.0572C8.80011 17.6717 9.19785 17.3912 9.55114 17.5493C10.4131 17.935 11.7865 18.5216 12.6914 18.7696C12.8552 18.8145 12.9888 18.9329 13.0649 19.0848C13.5325 20.0187 14.508 20.515 15.9034 20.515C17.285 20.515 18.2722 19.9996 18.7417 19.0625C18.8179 18.9105 18.9513 18.7922 19.1151 18.747C20.0786 18.4812 21.548 17.8225 22.4541 17.3962Z"
                                fill="#605BFF" />
                        </svg>
                        {{-- <h3>{{ $total_projects }}</h3> --}}
                        <p>{{ get_phrase('Projects') }}</p>
                    </div>
                    <div class="dashboard-card">

                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.1" width="32" height="32" rx="16" fill="#FF8F6B" />
                            <path
                                d="M13.75 8.5C11.785 8.5 10.1875 10.0975 10.1875 12.0625C10.1875 13.99 11.695 15.55 13.66 15.6175C13.72 15.61 13.78 15.61 13.825 15.6175C13.84 15.6175 13.8475 15.6175 13.8625 15.6175C13.87 15.6175 13.87 15.6175 13.8775 15.6175C15.7975 15.55 17.305 13.99 17.3125 12.0625C17.3125 10.0975 15.715 8.5 13.75 8.5Z"
                                fill="#FF8F6B" />
                            <path
                                d="M17.5607 17.6125C15.4682 16.2175 12.0557 16.2175 9.9482 17.6125C8.9957 18.25 8.4707 19.1125 8.4707 20.035C8.4707 20.9575 8.9957 21.8125 9.9407 22.4425C10.9907 23.1475 12.3707 23.5 13.7507 23.5C15.1307 23.5 16.5107 23.1475 17.5607 22.4425C18.5057 21.805 19.0307 20.95 19.0307 20.02C19.0232 19.0975 18.5057 18.2425 17.5607 17.6125Z"
                                fill="#FF8F6B" />
                            <path
                                d="M21.992 12.505C22.112 13.96 21.077 15.235 19.6445 15.4075C19.637 15.4075 19.637 15.4075 19.6295 15.4075H19.607C19.562 15.4075 19.517 15.4075 19.4795 15.4225C18.752 15.46 18.0845 15.2275 17.582 14.8C18.3545 14.11 18.797 13.075 18.707 11.95C18.6545 11.3425 18.4445 10.7875 18.1295 10.315C18.4145 10.1725 18.7445 10.0825 19.082 10.0525C20.552 9.925 21.8645 11.02 21.992 12.505Z"
                                fill="#FF8F6B" />
                            <path
                                d="M23.4922 19.4425C23.4322 20.17 22.9672 20.8 22.1872 21.2275C21.4372 21.64 20.4922 21.835 19.5547 21.8125C20.0947 21.325 20.4097 20.7175 20.4697 20.0725C20.5447 19.1425 20.1022 18.25 19.2172 17.5375C18.7147 17.14 18.1297 16.825 17.4922 16.5925C19.1497 16.1125 21.2347 16.435 22.5172 17.47C23.2072 18.025 23.5597 18.7225 23.4922 19.4425Z"
                                fill="#FF8F6B" />
                        </svg>
                        {{-- <h3> {{ count(json_decode($project->staffs)) }}+ </h3> --}}
                        <p> {{ get_phrase('Staffs') }} </p>

                    </div>
                    <div class="dashboard-card">

                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.2793 1C7.3143 1 5.7168 2.5975 5.7168 4.5625C5.7168 6.49 7.2243 8.05 9.1893 8.1175C9.2493 8.11 9.3093 8.11 9.3543 8.1175C9.3693 8.1175 9.3768 8.1175 9.3918 8.1175C9.3993 8.1175 9.3993 8.1175 9.4068 8.1175C11.3268 8.05 12.8343 6.49 12.8418 4.5625C12.8418 2.5975 11.2443 1 9.2793 1Z"
                                fill="#5B93FF" />
                            <path
                                d="M13.09 10.1125C10.9975 8.7175 7.585 8.7175 5.4775 10.1125C4.525 10.75 4 11.6125 4 12.535C4 13.4575 4.525 14.3125 5.47 14.9425C6.52 15.6475 7.9 16 9.28 16C10.66 16 12.04 15.6475 13.09 14.9425C14.035 14.305 14.56 13.45 14.56 12.52C14.5525 11.5975 14.035 10.7425 13.09 10.1125Z"
                                fill="#5B93FF" />
                        </svg>

                        {{-- <h3> {{ count(json_decode($project->staffs)) }}+ </h3> --}}
                        <p> {{ get_phrase('Clients') }} </p>

                    </div>
                    <div class="dashboard-card">

                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.1" width="32" height="32" rx="16" fill="#FF8F6B" />
                            <path
                                d="M13.75 8.5C11.785 8.5 10.1875 10.0975 10.1875 12.0625C10.1875 13.99 11.695 15.55 13.66 15.6175C13.72 15.61 13.78 15.61 13.825 15.6175C13.84 15.6175 13.8475 15.6175 13.8625 15.6175C13.87 15.6175 13.87 15.6175 13.8775 15.6175C15.7975 15.55 17.305 13.99 17.3125 12.0625C17.3125 10.0975 15.715 8.5 13.75 8.5Z"
                                fill="#FF8F6B" />
                            <path
                                d="M17.5607 17.6125C15.4682 16.2175 12.0557 16.2175 9.9482 17.6125C8.9957 18.25 8.4707 19.1125 8.4707 20.035C8.4707 20.9575 8.9957 21.8125 9.9407 22.4425C10.9907 23.1475 12.3707 23.5 13.7507 23.5C15.1307 23.5 16.5107 23.1475 17.5607 22.4425C18.5057 21.805 19.0307 20.95 19.0307 20.02C19.0232 19.0975 18.5057 18.2425 17.5607 17.6125Z"
                                fill="#FF8F6B" />
                            <path
                                d="M21.992 12.505C22.112 13.96 21.077 15.235 19.6445 15.4075C19.637 15.4075 19.637 15.4075 19.6295 15.4075H19.607C19.562 15.4075 19.517 15.4075 19.4795 15.4225C18.752 15.46 18.0845 15.2275 17.582 14.8C18.3545 14.11 18.797 13.075 18.707 11.95C18.6545 11.3425 18.4445 10.7875 18.1295 10.315C18.4145 10.1725 18.7445 10.0825 19.082 10.0525C20.552 9.925 21.8645 11.02 21.992 12.505Z"
                                fill="#FF8F6B" />
                            <path
                                d="M23.4922 19.4425C23.4322 20.17 22.9672 20.8 22.1872 21.2275C21.4372 21.64 20.4922 21.835 19.5547 21.8125C20.0947 21.325 20.4097 20.7175 20.4697 20.0725C20.5447 19.1425 20.1022 18.25 19.2172 17.5375C18.7147 17.14 18.1297 16.825 17.4922 16.5925C19.1497 16.1125 21.2347 16.435 22.5172 17.47C23.2072 18.025 23.5597 18.7225 23.4922 19.4425Z"
                                fill="#FF8F6B" />
                        </svg>
                        {{-- <h3> {{ count(json_decode($project->staffs)) }}+ </h3> --}}
                        <p> {{ get_phrase('Staffs') }} </p>

                    </div>
                </div>
                <div class="row">
                    <div id="donut"></div>
                </div>
            </div>
            <div class="col-sm-8">
                <div id="bar-chart"></div>
            </div>

        </div>
        {{-- <div class="row">
            <div class="col-sm-8">
                <div class="dashboard-table">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4> Recent Project </h4>
                        <a href="" class="btn ol-btn-light view-btn"> View Project </a>
                    </div>
                    <table class="table mt-2">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Staffs</th>
                                <th scope="col">Progress</th>
                                <th scope="col" class="d-flex justify-content-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resent_projects as $key => $recent)
                                <tr>
                                    <th scope="row"> {{ $key + 1 }} </th>
                                    <td> {{ $recent->title }} </td>
                                    <td> {{ count(json_decode($recent->staffs)) }} </td>
                                    <td>
                                        <div class="d-flex align-items-start flex-column min-w-100px">
                                            <span class="p-2 pt-0 fs-12px">{{ $recent->progress }}%</span>
                                            <div class="progress ms-2">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $recent->progress }}%; " aria-valuenow="{{ $recent->progress }}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                                            <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="fi-rr-menu-dots-vertical"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href=""> Edit </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href=""> Delete </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
{{-- <script>
    "use strict";
    document.addEventListener('DOMContentLoaded', function() {

        let dataArr = @json($project_status).map(function(status) {

            return {
                x: status.title,
                y: status.amount
            };
        });

        var barOptions = {
            chart: {
                type: 'bar',
                height: 300,
                borderRadius: 5,
                fontFamily: 'Inter',
            },

            series: [{
                data: dataArr
            }],


            title: {
                text: 'Project Income Bar',
                align: 'left'
            }
        };

        var barChart = new ApexCharts(document.querySelector("#bar-chart"), barOptions);
        barChart.render();
    });

    document.addEventListener('DOMContentLoaded', function() {

        let dataArr = @json($project_status).map(function(status) {
            return {
                label: status.title,
                value: status.amount
            };
        });

        const labels = dataArr.map(item => item.label);
        const values = dataArr.map(item => item.value);

        var donutOptions = {
            chart: {
                type: 'donut',
                height: 400,
                fontFamily: 'Inter',
            },
            series: values,
            labels: labels,
            title: {
                text: 'Projects',
                align: 'left'
            },
            colors: [
                '#212534',
                '#4e97ff',
                '#4de78e'
            ],
            dataLabels: {
                enabled: false
            },
            responsive: [{
                options: {
                    chart: {
                        height: 288,
                    },
                    // legend: {
                    //     position: 'left'
                    // }
                }
            }]
        };

        var donutChart = new ApexCharts(document.querySelector("#donut"), donutOptions);
        donutChart.render();
    });
</script> --}}
