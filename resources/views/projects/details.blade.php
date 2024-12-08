@extends('layouts.admin')

@section('content')
    @php
        $project_code = request()->route()->parameter('code');
        $project = App\Models\Project::where('code', $project_code)->first();
        $tab = request()->route()->parameter('tab') ?? 'dashboard';
    @endphp

    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <nav class="navbar navbar-expand-lg project-details">
                        <ul class="nav nav-underline">
                            <li class="nav-item">
                                <a class="nav-link @if ($tab == 'dashboard') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'dashboard']) }}">{{ get_phrase('Dashboard') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($tab == 'milestone') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'milestone']) }}">{{ get_phrase('Milestone') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($tab == 'task') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'task']) }}">{{ get_phrase('Task') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($tab == 'file') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'file']) }}">{{ get_phrase('File') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($tab == 'meeting') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'meeting']) }}">{{ get_phrase('Meeting') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($tab == 'gantt_chart') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'gantt_chart']) }}">{{ get_phrase('Gantt Chart') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($tab == 'invoice') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'invoice']) }}">{{ get_phrase('Invoice') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($tab == 'timesheet') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'timesheet']) }}">{{ get_phrase('Timesheet') }}
                                </a>
                            </li>
                        </ul>
                    </nav>

                    @include("projects.{$tab}.index")
                </div>
            </div>
        </div>
    </div>
@endsection
