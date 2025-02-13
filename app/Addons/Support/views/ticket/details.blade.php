@extends('layouts.admin')
@push('title', get_phrase('Projects'))
@section('content')
    <div class="messenger-area">
        <div class="messenger-header d-flex align-items-center justify-content-between">
            <div class="user-wrap d-flex align-items-center">
                <div class="name-status">
                    <h6 class="name">{{ $ticket_details->subject }}</h6>
                    <!-- for offline just remove active class  -->
                    <p class="">
                        @if ($ticket_details->status == 'in_progress')
                            <span class="in_progress">{{ get_phrase('In progress') }}</span>
                        @elseif ($ticket_details->status == 'not_started')
                            <span class="not_started">{{ get_phrase('Not started') }}</span>
                        @elseif ($ticket_details->status == 'completed')
                            <span class="completed">{{ get_phrase('Completed') }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <ul class="messenger-body" id="scrollAbleContent">
            @php
                $my_data = auth()->user();
            @endphp
            @if (count($messages) < 0)
                <div class="no-message card-centered-section">
                    <div class="card-middle-banner">
                        <img src="{{ get_image('assets/images/icons/no-message.svg') }}" alt="">
                    </div>
                </div>
            @else
                @foreach ($messages as $message)
                    @if ($message->sender_id == $my_data->id)
                        <li>
                            <div class="single-message recipient-user">
                                <div class="user-wrap mb-3 d-flex align-items-center">
                                    <div class="name-time  align-items-center flex-wrap">
                                        <h6 class="name">{{ $my_data->name }}</h6>
                                        <p class="time">{{ timeAgo($message->created_at) }}</p>
                                    </div>
                                    <div class="profile">
                                        <img src="{{ get_image($my_data->photo) }}" alt="">
                                    </div>
                                </div>
                                @if (!empty($message->message))
                                    <p class="message">{{ $message->message }}</p>
                                @endif
                                @if (!empty($message->file))
                                    <div class="my-2 gallery">
                                        @php
                                            $files = json_decode($message->file, true);
                                        @endphp

                                        @if (!empty($files) && is_array($files))
                                            @foreach ($files as $file)
                                                <a href="{{ get_image($file) }}" class="popup-image">
                                                    <img src="{{ get_image($file) }}" class="rounded-3 m-2" width="300"
                                                        alt="Uploaded Image">
                                                </a>
                                            @endforeach
                                        @else
                                            <p>No files available</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </li>
                    @else
                        <li>
                            <div class="single-message">
                                <div class="user-wrap mb-3 d-flex align-items-center">
                                    <div class="profile">
                                        <img src="{{ get_image($message->user->photo) }}" alt="">
                                    </div>
                                    <div class="name-time align-items-center flex-wrap">
                                        <h6 class="name">{{ $message->user->name }}</h6>
                                        <p class="time">{{ timeAgo($message->created_at) }}</p>
                                    </div>
                                </div>
                                @if (!empty($message->message))
                                    <p class="message">{{ $message->message }}</p>
                                @endif
                                @if (!empty($message->file))
                                    <div class="my-2 gallery">
                                        @php
                                            $files = json_decode($message->file, true);
                                        @endphp

                                        @if (!empty($files) && is_array($files))
                                            @foreach ($files as $file)
                                                <a href="{{ get_image($file) }}" class="popup-image">
                                                    <img src="{{ get_image($file) }}" class="rounded-3 m-2" width="300"
                                                        alt="Uploaded Image">
                                                </a>
                                            @endforeach
                                        @else
                                            <p>No files available</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
        <div class="messenger-footer">
            <form action="{{ route(get_current_user_role() . '.addon.ticket.message.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="sender_id" value="{{ $my_data->id }}">
                <input type="hidden" name="receiver_id" value="{{ $ticket_details->client_id }}">
                <input type="hidden" name="ticket_thread_code" value="{{ $ticket_details->code }}">

                <div class="messenger-footer-inner d-flex align-items-center">
                    <input type="search" name="message" class="form-control form-control-message"
                        placeholder="Type your message here...">
                    <label for="formFile" class="form-label form-label-fileinput">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"
                                    stroke="#6D718C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M9 10C10.1046 10 11 9.10457 11 8C11 6.89543 10.1046 6 9 6C7.89543 6 7 6.89543 7 8C7 9.10457 7.89543 10 9 10Z"
                                    stroke="#6D718C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M2.67188 18.9501L7.60187 15.6401C8.39187 15.1101 9.53187 15.1701 10.2419 15.7801L10.5719 16.0701C11.3519 16.7401 12.6119 16.7401 13.3919 16.0701L17.5519 12.5001C18.3319 11.8301 19.5919 11.8301 20.3719 12.5001L22.0019 13.9001"
                                    stroke="#6D718C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <input class="form-control" type="file" id="formFile" name="ticket_file[]" multiple hidden>
                    </label>
                    <button type="submit" class="btn ol-btn-primary d-flex align-items-center cg-10px">
                        <span>
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.785 5.79323L14.5675 3.19906C18.06 2.0349 19.9575 3.94156 18.8025 7.43406L16.2083 15.2166C14.4667 20.4507 11.6067 20.4507 9.865 15.2166L9.095 12.9066L6.785 12.1366C1.55083 10.3949 1.55083 7.54406 6.785 5.79323Z"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9.26562 12.5125L12.5473 9.22168" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span>{{ get_phrase('Sent') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";

        let divElement = document.getElementById('scrollAbleContent');
        // Scroll to the bottom of the div
        divElement.scrollTop = divElement.scrollHeight;
    </script>
    <script>
        $(document).ready(function() {
            $('.gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                }
            });
        });
    </script>
@endpush
