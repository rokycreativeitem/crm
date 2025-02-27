@push('title', get_phrase('Dashboard'))
@php
    $project_id = project_id_by_code(request()->route()->parameter('code'));
    $timesheets = App\Models\Timesheet::where('project_id', $project_id)->get();
    $total_tasks = App\Models\Task::where('project_id', $project_id)->count();
    $total_milestone = App\Models\Milestone::where('project_id', $project_id)->count();
    $total_meeting = App\Models\Meeting::where('project_id', $project_id)->count();
    $project = App\Models\Project::where('id', $project_id)->first();
    $resent_projects = App\Models\Project::orderBy('id', 'DESC')->limit(4)->get();
@endphp

<div class="project-dashboard">
    <div class="row mt-4">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-6">
                    <div id="donut"></div>
                    {{-- <div class="row">
                        <div class="col-sm-3">

                        </div>
                    </div> --}}
                </div>
                <div class="col-sm-6">
                    <div id="bar-chart"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="dashboard-card">

                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.1" width="32" height="32" rx="16" fill="#5B93FF" />
                            <path d="M18.8498 8.6575C18.5423 8.35 18.0098 8.56 18.0098 8.9875V11.605C18.0098 12.7 18.9398 13.6075 20.0723 13.6075C20.7848 13.615 21.7748 13.615 22.6223 13.615C23.0498 13.615 23.2748 13.1125 22.9748 12.8125C21.8948 11.725 19.9598 9.7675 18.8498 8.6575Z"
                                fill="#5B93FF" />
                            <path
                                d="M22.375 14.6425H20.2075C18.43 14.6425 16.9825 13.195 16.9825 11.4175V9.25C16.9825 8.8375 16.645 8.5 16.2325 8.5H13.0525C10.7425 8.5 8.875 10 8.875 12.6775V19.3225C8.875 22 10.7425 23.5 13.0525 23.5H18.9475C21.2575 23.5 23.125 22 23.125 19.3225V15.3925C23.125 14.98 22.7875 14.6425 22.375 14.6425ZM15.625 20.3125H12.625C12.3175 20.3125 12.0625 20.0575 12.0625 19.75C12.0625 19.4425 12.3175 19.1875 12.625 19.1875H15.625C15.9325 19.1875 16.1875 19.4425 16.1875 19.75C16.1875 20.0575 15.9325 20.3125 15.625 20.3125ZM17.125 17.3125H12.625C12.3175 17.3125 12.0625 17.0575 12.0625 16.75C12.0625 16.4425 12.3175 16.1875 12.625 16.1875H17.125C17.4325 16.1875 17.6875 16.4425 17.6875 16.75C17.6875 17.0575 17.4325 17.3125 17.125 17.3125Z"
                                fill="#5B93FF" />
                        </svg>

                        <h3> {{ $total_tasks }}+ </h3>
                        <p> {{ get_phrase('total task') }} </p>

                    </div>
                </div>
                <div class="col-sm-3">
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
                        <h3> {{ count(json_decode($project->staffs)) }}+ </h3>
                        <p> {{ get_phrase('Team Members') }} </p>

                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="dashboard-card">

                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.2" width="32" height="32" rx="16" fill="#FFD66B" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M19.6977 12.25C19.7216 12.1968 19.7328 12.1389 19.7304 12.0807H19.75C19.6661 10.0794 18.0137 8.5 16.0037 8.5C13.9937 8.5 12.3413 10.0794 12.2574 12.0807C12.2475 12.1367 12.2475 12.194 12.2574 12.25L12.1988 12.25C11.2377 12.25 10.2103 12.8845 9.91198 14.5901L9.32868 19.2361C8.85143 22.6472 10.608 23.5 12.9014 23.5H19.1189C21.4057 23.5 23.1092 22.2652 22.6849 19.2361L22.1083 14.5901C21.757 12.9322 20.7627 12.25 19.8148 12.25L19.6977 12.25ZM18.6199 12.25C18.599 12.196 18.588 12.1386 18.5872 12.0807C18.5872 10.6426 17.4174 9.47679 15.9743 9.47679C14.5312 9.47679 13.3614 10.6426 13.3614 12.0807C13.3713 12.1367 13.3713 12.194 13.3614 12.25H18.6199ZM13.823 16.1114C13.4569 16.1114 13.1602 15.806 13.1602 15.4292C13.1602 15.0524 13.4569 14.747 13.823 14.747C14.1891 14.747 14.4858 15.0524 14.4858 15.4292C14.4858 15.806 14.1891 16.1114 13.823 16.1114ZM17.502 15.4292C17.502 15.806 17.7987 16.1114 18.1648 16.1114C18.5309 16.1114 18.8276 15.806 18.8276 15.4292C18.8276 15.0524 18.5309 14.747 18.1648 14.747C17.7987 14.747 17.502 15.0524 17.502 15.4292Z"
                                fill="#FFC327" />
                        </svg>

                        <h3> {{ $total_milestone }}+ </h3>
                        <p> {{ get_phrase('Total Milestones') }} </p>

                    </div>
                </div>
                <div class="col-sm-3">
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

                        <h3> {{ $total_meeting }}+ </h3>
                        <p> {{ get_phrase('Total Meeting') }} </p>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <h4 class="title fs-16px"> {{ get_phrase('Team Timesheet') }} </h4>
            <table class="table project-dashboard-table">
                <thead>
                    <tr class="fs-14px">
                        <th scope="col"> {{ get_phrase('Member') }} </th>
                        <th scope="col" class="text-center"> {{ get_phrase('Task') }} </th>
                        <th scope="col" class="text-center"> {{ get_phrase('Hours') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timesheets as $time)
                        @php
                            $team_member = App\Models\User::where('id', $time->staff)->first();
                        @endphp
                        <tr>
                            <th>
                                <div class="d-flex align-items-center">
                                    <img src="{{ get_image($team_member->photo, '') }}" class="rounded-circle" width="30px" height="30px" alt="">
                                    <p class="ps-2">
                                        <span class="name d-block fw-bold"> {{ $team_member->name }} </span>
                                        <span class="designation"> Lorem ipsum dolor sit. </span>
                                    </p>
                                </div>
                            </th>
                            <td class="text-center">
                                @php
                                    $team_id = '"' . $team_member->id . '"';
                                    echo App\Models\Task::where('project_id', $project_id)
                                        ->where('team', 'like', '%' . $team_id . '%')
                                        ->count();
                                @endphp
                            </td>
                            <td class="text-center">
                                @php
                                    if ($time->timestamp_start && $time->timestamp_end) {
                                        $hours = round((strtotime($time->timestamp_end) - strtotime($time->timestamp_start)) / 3600, 2);
                                        echo $hours . ' ' . get_phrase('hours');
                                    } else {
                                        echo get_phrase('0 hour');
                                    }
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-8">
            <div class="dashboard-table">
                <div class="d-flex align-items-center justify-content-between">
                    <h4> {{get_phrase('Recent Project')}} </h4>
                    <a href="{{ route(get_current_user_role() . '.projects', ['layout' => get_settings('list_view_type') ?? 'list']) }}" class="btn ol-btn-light view-btn"> {{get_phrase('View Project')}} </a>
                </div>
                <table class="table mt-2">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{get_phrase('Title')}}</th>
                            <th scope="col">{{get_phrase('Client')}}</th>
                            <th scope="col">{{get_phrase('Status')}}</th>
                            <th scope="col">{{get_phrase('Progress')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resent_projects as $key => $recent)
                        @php
                            if($key == 5) {
                                continue;
                            }
                        @endphp
                            <tr>
                                <th scope="row"> {{ $key + 1 }} </th>
                                <td>
                                    <a href="{{route(get_current_user_role() . '.project.details', $recent->code)}}">{{$recent->title}}</a>
                                </td>
                                <td> {{ $recent->user?->name }} </td>
                                <td>
                                    @php
                                        $task        = $recent->status;
                                        $statusLabel = '';
                                        if ($task == 'in_progress') {
                                            $statusLabel = '<span class="in_progress">' . get_phrase('In Progress') . '</span>';
                                        } elseif ($task == 'not_started') {
                                            $statusLabel = '<span class="not_started">' . get_phrase('Not Started') . '</span>';
                                        } elseif ($task == 'completed') {
                                            $statusLabel = '<span class="completed">' . get_phrase('Completed') . '</span>';
                                        }
                                        echo $statusLabel;
                                    @endphp     
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2 min-w-100px">
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $recent->progress }}%; " aria-valuenow="{{ $recent->progress }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span class="fs-12px">{{ $recent->progress }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="grid-card">
                <!-- User Profile Section -->
                <div class="grid-header pb-3">
                    <div class="note">
                        <div class="logo me-2">
                            <!-- SVG Icon -->
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.1827 17.6395C14.873 15.9492 15.2375 14.5581 15.2405 14.5558C15.3386 13.217 15.4127 11.5773 15.4021 10.6101C15.4198 9.00912 15.2052 5.56203 15.0317 4.69423C14.756 3.27023 13.4543 1.89269 12.0332 1.57814C11.1707 1.40176 9.30342 1.22538 7.70128 1.22008C6.09914 1.21479 4.23243 1.39647 3.36992 1.57814C1.95004 1.89269 0.648343 3.26965 0.371423 4.69423C0.197981 5.56203 -0.016618 9.00912 0.00102021 10.6101C-0.016618 12.2111 0.197981 15.6587 0.371423 16.5265C0.647168 17.9505 1.94887 19.3275 3.36992 19.6426C4.23243 19.8219 6.09973 19.9954 7.70128 20.0001C8.42974 20.0001 9.21229 19.9619 9.93076 19.9048C9.94369 19.8996 11.4982 19.3234 13.1827 17.6395Z"
                                    fill="url(#paint0_linear_121_1134)" />
                                <path
                                    d="M8.52329 12.6648H3.93323C3.83267 12.6677 3.73257 12.6503 3.63885 12.6137C3.54512 12.5772 3.45967 12.5222 3.38755 12.4521C3.31543 12.382 3.2581 12.2981 3.21895 12.2054C3.17981 12.1127 3.15964 12.0132 3.15964 11.9126C3.15964 11.812 3.17981 11.7124 3.21895 11.6197C3.2581 11.5271 3.31543 11.4432 3.38755 11.373C3.45967 11.3029 3.54512 11.248 3.63885 11.2114C3.73257 11.1749 3.83267 11.1575 3.93323 11.1603H8.52329C8.71916 11.1658 8.90518 11.2474 9.04178 11.3879C9.17839 11.5284 9.25482 11.7166 9.25482 11.9126C9.25482 12.1085 9.17839 12.2967 9.04178 12.4372C8.90518 12.5777 8.71916 12.6594 8.52329 12.6648ZM11.4689 9.50172H3.93323C3.83267 9.50453 3.73257 9.48715 3.63885 9.45061C3.54512 9.41407 3.45967 9.35911 3.38755 9.28898C3.31543 9.21885 3.2581 9.13497 3.21895 9.0423C3.17981 8.94963 3.15964 8.85005 3.15964 8.74945C3.15964 8.64885 3.17981 8.54928 3.21895 8.45661C3.2581 8.36394 3.31543 8.28006 3.38755 8.20992C3.45967 8.13979 3.54512 8.08483 3.63885 8.04829C3.73257 8.01175 3.83267 7.99437 3.93323 7.99718H11.4677C11.5683 7.99437 11.6684 8.01175 11.7621 8.04829C11.8558 8.08483 11.9413 8.13979 12.0134 8.20992C12.0855 8.28006 12.1428 8.36394 12.182 8.45661C12.2211 8.54928 12.2413 8.64885 12.2413 8.74945C12.2413 8.85005 12.2211 8.94963 12.182 9.0423C12.1428 9.13497 12.0855 9.21885 12.0134 9.28898C11.9413 9.35911 11.8558 9.41407 11.7621 9.45061C11.6684 9.48715 11.5683 9.50453 11.4677 9.50172H11.4689Z"
                                    fill="url(#paint1_linear_121_1134)" />
                                <path
                                    d="M9.92978 19.9047C9.95036 18.9464 9.96858 17.7499 9.9821 16.8316C9.9874 16.4759 9.9921 16.1572 9.99621 15.9026C10.0041 15.5591 10.1445 15.2318 10.3881 14.9894C10.6317 14.747 10.9596 14.6082 11.3032 14.6021L12.7731 14.5851C13.6262 14.5757 14.5245 14.5657 15.2371 14.5557C15.2371 14.5557 14.8732 15.9473 13.1793 17.6394C11.4855 19.3315 9.92978 19.9047 9.92978 19.9047Z"
                                    fill="url(#paint2_linear_121_1134)" />
                                <path
                                    d="M15.0293 4.69412C14.7536 3.27013 13.4519 1.89258 12.0308 1.57803H12.0226V0.754916C12.0226 0.555324 11.9433 0.363906 11.8022 0.222773C11.6611 0.0816395 11.4696 0.00235182 11.27 0.00235182C11.0705 0.00235182 10.879 0.0816395 10.7379 0.222773C10.5968 0.363906 10.5175 0.555324 10.5175 0.754916V1.37049C9.88251 1.30758 9.1611 1.25819 8.45146 1.23585V0.752565C8.44598 0.556691 8.36432 0.370677 8.22384 0.234069C8.08336 0.097461 7.89514 0.0210327 7.69919 0.0210327C7.50324 0.0210327 7.31501 0.097461 7.17453 0.234069C7.03405 0.370677 6.95239 0.556691 6.94692 0.752565V1.2335C6.23727 1.25584 5.51587 1.30523 4.88089 1.36814V0.752565C4.88089 0.552972 4.80161 0.361555 4.66047 0.220421C4.51934 0.0792881 4.32792 0 4.12833 0C3.92874 0 3.73732 0.0792881 3.59619 0.220421C3.45505 0.361555 3.37576 0.552972 3.37576 0.752565V1.57568H3.36753C1.94766 1.89023 0.645956 3.26719 0.369036 4.69177C0.337287 4.84875 0.30495 5.08981 0.272614 5.38848C2.08112 5.24326 4.94616 5.09039 7.69654 5.08745C10.4469 5.08451 13.3161 5.24326 15.1234 5.38848C15.0934 5.09216 15.0611 4.85051 15.0293 4.69412Z"
                                    fill="url(#paint3_linear_121_1134)" />
                                <defs>
                                    <linearGradient id="paint0_linear_121_1134" x1="13.9558" y1="16.8658" x2="0.624829" y2="3.5348" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#FF8145" />
                                        <stop offset="0.43" stop-color="#FF8952" />
                                        <stop offset="0.97" stop-color="#FFAD8A" />
                                    </linearGradient>
                                    <linearGradient id="paint1_linear_121_1134" x1="9.43401" y1="12.0646" x2="4.49413" y2="7.12468" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#FFDDCE" />
                                        <stop offset="0.52" stop-color="white" />
                                        <stop offset="1" stop-color="white" />
                                    </linearGradient>
                                    <linearGradient id="paint2_linear_121_1134" x1="13.0882" y1="17.7341" x2="8.98908" y2="13.6349" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#E95932" />
                                        <stop offset="1" stop-color="#F9712D" />
                                    </linearGradient>
                                    <linearGradient id="paint3_linear_121_1134" x1="11.875" y1="8.64156" x2="3.52569" y2="0.292797" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#F36062" />
                                        <stop offset="0.44" stop-color="#F3585A" />
                                        <stop offset="1" stop-color="#FF8C8B" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <span class="note-body">{{ substr_replace($project->note,'...',20) }}</span>
                    </div>

                    <div>
                        <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                            <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fi-rr-menu-dots-vertical"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" onclick="rightCanvas('{{ route(get_current_user_role() . '.project.edit', $project->code) }}', 'Edit project')" href="#">{{ get_phrase('Edit') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" onclick="confirmModal('{{ route(get_current_user_role() . '.project.delete', $project->code) }}')" href="javascript:void(0)">{{ get_phrase('Delete') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route(get_current_user_role() . '.project.details', $project->code) }}">{{ get_phrase('view project') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Task Info Section -->
                <div class="grid-title pb-2">
                    <span class="fs-14px">{{ $project->title }}</span>
                    <div class="fs-12px pt-2">
                        <span>{{ $project->user->name }}</span>
                        <span class="code">{{ $project->code }}</span>
                    </div>
                </div>

                <!-- Progress -->
                <div class="grid-progress">
                    <div class="d-flex align-items-center">
                        @foreach (json_decode($project->staffs) as $key => $staff)
                            @php
                                if ($key > 2) {
                                    break;
                                }
                            @endphp
                            <img src="{{ get_image(App\models\User::where('id', $staff)->first()->photo) }}" alt="Attendee 1">
                        @endforeach
                        @if (count(json_decode($project->staffs)) > 3)
                            <span class="project-count">+{{ count(json_decode($project->staffs)) - 3 }}</span>
                        @endif
                    </div>
                    <div>
                        @if ($project->status == 'in_progress')
                            <span class="in_progress ">{{ get_phrase('In Progress') }}</span>
                        @elseif($project->status == 'not_started')
                            <span class="not_started">{{ get_phrase('Not Started') }}</span>
                        @elseif($project->status == 'completed')
                            <span class="completed">{{ get_phrase('Completed') }}</span>
                        @endif
                    </div>
                </div>

                <div class="mt-4"> <!-- Changed to mt-4 for better Bootstrap spacing -->
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">{{ get_phrase('Progress') }}</span>
                        <span class="text-muted">{{ $project->progress }}%</span>
                    </div>
                    <div class="bg-light rounded overflew-hidden" style="height: 8px;">
                        <div class="bg-primary" style="width: {{ $project->progress }}%; height: 100%; border-radius: 8px;"></div>
                    </div>
                </div>


                <!-- View Details Link -->
                <div class="mt-4">
                    <a href="{{ route(get_current_user_role() . '.project.details', $project->code) }}">
                        <div class="d-inline">
                            <span>{{ get_phrase('View Details') }}</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.66666 11.3334L11.3333 4.66669M11.3333 4.66669H4.66666M11.3333 4.66669V11.3334" stroke="#6B708A" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
                name: '{{get_phrase('Total Task In This Project')}}',
                data: dataArr
            }],


            title: {
                text: '{{get_phrase('Project Task Bar')}}',
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
                text: 'Projects Overview',
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
</script>
