<div class="row g-3">
    @foreach ($projects as $project)
        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
            <div class="grid-card">
                <!-- User Profile Section -->
                <div class="grid-header">
                    <div class="note">
                        <div class="logo me-2">
                            <!-- SVG Icon -->
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
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
                                    <linearGradient id="paint0_linear_121_1134" x1="13.9558" y1="16.8658"
                                        x2="0.624829" y2="3.5348" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#FF8145" />
                                        <stop offset="0.43" stop-color="#FF8952" />
                                        <stop offset="0.97" stop-color="#FFAD8A" />
                                    </linearGradient>
                                    <linearGradient id="paint1_linear_121_1134" x1="9.43401" y1="12.0646"
                                        x2="4.49413" y2="7.12468" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#FFDDCE" />
                                        <stop offset="0.52" stop-color="white" />
                                        <stop offset="1" stop-color="white" />
                                    </linearGradient>
                                    <linearGradient id="paint2_linear_121_1134" x1="13.0882" y1="17.7341"
                                        x2="8.98908" y2="13.6349" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#E95932" />
                                        <stop offset="1" stop-color="#F9712D" />
                                    </linearGradient>
                                    <linearGradient id="paint3_linear_121_1134" x1="11.875" y1="8.64156"
                                        x2="3.52569" y2="0.292797" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#F36062" />
                                        <stop offset="0.44" stop-color="#F3585A" />
                                        <stop offset="1" stop-color="#FF8C8B" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <span class="note-body">{{ $project->note }}</span>
                    </div>

                    <div>
                        <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                            <button class="btn ol-btn-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fi-rr-menu-dots-vertical"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item"
                                        onclick="rightCanvas('{{ route(get_current_user_role() . '.project.edit', $project->code) }}', 'Edit project')"
                                        href="#">{{ get_phrase('Edit') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        onclick="confirmModal('{{ route(get_current_user_role() . '.project.delete', $project->code) }}')"
                                        href="javascript:void(0)">{{ get_phrase('Delete') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route(get_current_user_role() . '.project.details', $project->code) }}">{{ get_phrase('view project') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Task Info Section -->
                <div class="grid-title">
                    <span>{{ $project->title }}</span>
                    <div>
                        <span>{{ $project->title }}</span>
                        <span>{{ $project->code }}</span>
                    </div>
                </div>

                <!-- Progress -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                    <div style="display: flex; align-items: center;">
                        <img src="avatar1.png" alt="Attendee 1"
                            style="width: 24px; height: 24px; border-radius: 50%; border: 2px solid #fff; margin-right: -8px;">
                        <img src="avatar2.png" alt="Attendee 2"
                            style="width: 24px; height: 24px; border-radius: 50%; border: 2px solid #fff; margin-right: -8px;">
                        <span style="margin-left: 12px; color: #6b7280;">+5</span>
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
                    <div class="bg-light rounded" style="height: 8px;">
                        <div class="bg-primary"
                            style="width: {{ $project->progress }}%; height: 100%; border-radius: 8px;"></div>
                    </div>
                </div>


                <!-- View Details Link -->
                <div style="margin-top: 12px;">
                    <a href="{{ route(get_current_user_role() . '.project.details', $project->code) }}">
                        <div class="d-inline">
                            <span>{{ get_phrase('View Details') }}</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.66666 11.3334L11.3333 4.66669M11.3333 4.66669H4.66666M11.3333 4.66669V11.3334"
                                    stroke="#6B708A" stroke-width="1.3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
