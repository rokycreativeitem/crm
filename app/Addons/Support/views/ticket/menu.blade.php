{{-- <li class="sidebar-first-li first-li-have-sub {{ request()->is('admin/addon/ticket') ? 'active showMenu' : '' }}">
    <a href="javascript:void(0);">
        <span>
            <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M4.6424 19.649C2.6924 19.649 1.0424 17.999 1.0424 16.049V10.9157C1.00073 8.48231 1.90073 6.19064 3.58407 4.47398C5.2674 2.76564 7.52573 1.81564 9.95907 1.81564C14.9257 1.81564 18.9591 5.85731 18.9591 10.8157V15.949C18.9591 17.9323 17.3424 19.549 15.3591 19.549C13.4091 19.549 11.7591 17.899 11.7591 15.949V13.6073C11.7591 12.399 12.7091 11.449 13.9174 11.449C15.1257 11.449 18.9591 12.399 18.9591 13.6073V16.1323C18.9591 16.474 18.6757 16.7573 18.3341 16.7573C17.9924 16.7573 17.7091 16.474 17.7091 16.1323V13.6073C17.7091 13.0407 14.3674 12.699 13.9174 12.699C13.3507 12.699 13.0091 13.1573 13.0091 13.6073V15.949C13.0091 17.224 14.0841 18.299 15.3591 18.299C16.6341 18.299 17.7091 17.224 17.7091 15.949V10.8157C17.7091 6.54064 14.2341 3.06564 9.95907 3.06564C7.8674 3.06564 5.92573 3.87398 4.47573 5.34898C3.02573 6.82398 2.25073 8.79898 2.2924 10.899V16.049C2.2924 17.324 3.3674 18.399 4.6424 18.399C5.9174 18.399 6.9924 17.324 6.9924 16.049V13.7073C6.9924 13.1407 6.53407 12.799 6.08407 12.799C5.5174 12.799 2.2924 13.2573 2.2924 13.7073V16.1407C2.2924 16.4823 2.00907 16.7657 1.6674 16.7657C1.32573 16.7657 1.0424 16.4823 1.0424 16.1407V13.7073C1.0424 12.499 4.87573 11.549 6.08407 11.549C7.2924 11.549 8.2424 12.499 8.2424 13.7073V16.049C8.2424 17.999 6.5924 19.649 4.6424 19.649Z"
                    fill="#99A1B7" />
            </svg>
        </span>
        <div class="text">
            <span>{{ get_phrase('Support') }}</span>
        </div>
    </a>
    <ul class="first-sub-menu">

        <li class="sidebar-second-li  {{ request()->is('admin/addon/ticket') ? 'active' : '' }}">
            <a href="{{ route('addon.ticket') }}">{{ get_phrase('Tickets') }}</a>
        </li>
        <li class="sidebar-second-li">
            <a href="">{{ get_phrase('FAQ') }}</a>
        </li>
        <li class="sidebar-second-li">
            <a href="">{{ get_phrase('Feedback') }}</a>
        </li>
        <li class="sidebar-second-li">
            <a href="">{{ get_phrase('Report') }}</a>
        </li>
        <li class="sidebar-second-li">
            <a href="">{{ get_phrase('Settings') }}</a>
        </li>
    </ul>
</li> --}}



@php $current_route = Route::currentRouteName(); @endphp

@if (has_permission([
        'addon.ticket',
        'addon.ticket.create',
        'addon.ticket.store',
        'addon.ticket.edit',
        'addon.ticket.update',
        'addon.ticket.delete',
        'addon.support.multi-delete',
    ]))
    <li class="sidebar-first-li first-li-have-sub @if (
        $current_route == get_current_user_role() . '.addon.ticket' ||
            $current_route == get_current_user_role() . '.addon.faq' ||
            $current_route == get_current_user_role() . '.addon.feedback' ||
            $current_route == get_current_user_role() . '.addon.report' ||
            $current_route == get_current_user_role() . '.addon.macro' ||
            $current_route == get_current_user_role() . '.addon.custom_fields' ||
            $current_route == get_current_user_role() . '.addon.ticket.category' ||
            $current_route == get_current_user_role() . '.addon.ticket.priority' ||
            $current_route == get_current_user_role() . '.addon.ticket_status' ||
            $current_route == get_current_user_role() . '.addon.ticket_settings' ||
            $current_route == get_current_user_role() . '.addon.automation_rules' ||
            $current_route == get_current_user_role() . '.addon.chatbot_settings') active showMenu @endif">
        <a href="javascript:void(0);">
            <span>
                <svg width="20" height="21" viewBox="0 0 20 21" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.6424 19.649C2.6924 19.649 1.0424 17.999 1.0424 16.049V10.9157C1.00073 8.48231 1.90073 6.19064 3.58407 4.47398C5.2674 2.76564 7.52573 1.81564 9.95907 1.81564C14.9257 1.81564 18.9591 5.85731 18.9591 10.8157V15.949C18.9591 17.9323 17.3424 19.549 15.3591 19.549C13.4091 19.549 11.7591 17.899 11.7591 15.949V13.6073C11.7591 12.399 12.7091 11.449 13.9174 11.449C15.1257 11.449 18.9591 12.399 18.9591 13.6073V16.1323C18.9591 16.474 18.6757 16.7573 18.3341 16.7573C17.9924 16.7573 17.7091 16.474 17.7091 16.1323V13.6073C17.7091 13.0407 14.3674 12.699 13.9174 12.699C13.3507 12.699 13.0091 13.1573 13.0091 13.6073V15.949C13.0091 17.224 14.0841 18.299 15.3591 18.299C16.6341 18.299 17.7091 17.224 17.7091 15.949V10.8157C17.7091 6.54064 14.2341 3.06564 9.95907 3.06564C7.8674 3.06564 5.92573 3.87398 4.47573 5.34898C3.02573 6.82398 2.25073 8.79898 2.2924 10.899V16.049C2.2924 17.324 3.3674 18.399 4.6424 18.399C5.9174 18.399 6.9924 17.324 6.9924 16.049V13.7073C6.9924 13.1407 6.53407 12.799 6.08407 12.799C5.5174 12.799 2.2924 13.2573 2.2924 13.7073V16.1407C2.2924 16.4823 2.00907 16.7657 1.6674 16.7657C1.32573 16.7657 1.0424 16.4823 1.0424 16.1407V13.7073C1.0424 12.499 4.87573 11.549 6.08407 11.549C7.2924 11.549 8.2424 12.499 8.2424 13.7073V16.049C8.2424 17.999 6.5924 19.649 4.6424 19.649Z"
                        fill="currentColor" />
                </svg>
            </span>
            <div class="text">
                <span>{{ get_phrase('Support') }}</span>
            </div>
        </a>
        <ul class="first-sub-menu">
            @if (has_permission('addon.ticket'))
                <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.ticket') active showMenu @endif">
                    <a href="{{ route(get_current_user_role() . '.addon.ticket') }}">{{ get_phrase('Tickets') }}</a>
                </li>
            @endif
            @if (has_permission('addon.faq'))
                <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.faq') active showMenu @endif">
                    <a href="{{ route(get_current_user_role() . '.addon.faq') }}">{{ get_phrase('FAQ') }}</a>
                </li>
            @endif
            @if (has_permission('addon.feedback'))
                <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.feedback') active showMenu @endif">
                    <a href="{{ route(get_current_user_role() . '.addon.feedback') }}">{{ get_phrase('Feedback') }}</a>
                </li>
            @endif
            @if (has_permission('addon.report'))
                <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.report') active showMenu @endif">
                    <a href="{{ route(get_current_user_role() . '.addon.report') }}">{{ get_phrase('Report') }}</a>
                </li>
            @endif

            @if (has_permission([
                    'addon.macro',
                    'addon.custom_fields',
                    'addon.ticket.category',
                    'addon.ticket.priority',
                    'addon.ticket_status',
                    'addon.ticket_settings',
                    'addon.automation_rules',
                    'chatbot_settings',
                ]))
                <li
                    class="sidebar-second-li second-li-have-sub @if (
                        $current_route == get_current_user_role() . '.addon.macro' ||
                            $current_route == get_current_user_role() . '.addon.custom_fields' ||
                            $current_route == get_current_user_role() . '.addon.ticket.category' ||
                            $current_route == get_current_user_role() . '.addon.ticket.priority' ||
                            $current_route == get_current_user_role() . '.addon.ticket_status' ||
                            $current_route == get_current_user_role() . '.addon.ticket_settings' ||
                            $current_route == get_current_user_role() . '.addon.automation_rules' ||
                            $current_route == get_current_user_role() . '.chatbot_settings') active showMenu @endif">
                    <a href="javascript:void(0);">{{ get_phrase('Support settings') }}</a>
                    <ul class="second-sub-menu">
                        @if (has_permission('addon.macro'))
                            <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.macro') active showMenu @endif">
                                <a
                                    href="{{ route(get_current_user_role() . '.addon.macro') }}">{{ get_phrase('Macro') }}</a>
                            </li>
                        @endif
                        @if (has_permission('addon.custom_fields'))
                            <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.custom_fields') active showMenu @endif">
                                <a
                                    href="{{ route(get_current_user_role() . '.addon.custom_fields') }}">{{ get_phrase('Custom fields') }}</a>
                            </li>
                        @endif
                        @if (has_permission('addon.ticket.category'))
                            <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.ticket.category') active showMenu @endif">
                                <a
                                    href="{{ route(get_current_user_role() . '.addon.ticket.category') }}">{{ get_phrase('Ticket categories') }}</a>
                            </li>
                        @endif
                        @if (has_permission('addon.ticket.priority'))
                            <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.ticket.priority') active showMenu @endif">
                                <a
                                    href="{{ route(get_current_user_role() . '.addon.ticket.priority') }}">{{ get_phrase('Ticket priorities') }}</a>
                            </li>
                        @endif
                        @if (has_permission('addon.ticket_status'))
                            <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.ticket_status') active showMenu @endif">
                                <a
                                    href="{{ route(get_current_user_role() . '.addon.ticket_status') }}">{{ get_phrase('Ticket status') }}</a>
                            </li>
                        @endif
                        @if (has_permission('addon.ticket_settings'))
                            <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.ticket_settings') active showMenu @endif">
                                <a
                                    href="{{ route(get_current_user_role() . '.addon.ticket_settings') }}">{{ get_phrase('Ticket settings') }}</a>
                            </li>
                        @endif
                        @if (has_permission('addon.automation_rules'))
                            <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.automation_rules') active showMenu @endif">
                                <a
                                    href="{{ route(get_current_user_role() . '.addon.automation_rules') }}">{{ get_phrase('Automation rules') }}</a>
                            </li>
                        @endif
                        @if (has_permission('addon.chatbot_settings'))
                            <li class="sidebar-second-li @if ($current_route == get_current_user_role() . '.addon.chatbot_settings') active showMenu @endif">
                                <a
                                    href="{{ route(get_current_user_role() . '.addon.chatbot_settings') }}">{{ get_phrase('Chatbot settings') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

        </ul>
    </li>
@endif
