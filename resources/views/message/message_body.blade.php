<div class="messenger-area">
    <div class="messenger-header d-flex align-items-center justify-content-between">
        <div class="user-wrap d-flex align-items-center">
            <div class="profile">
                <img src="{{ get_image($thread_details->user->photo) }}" alt="">
            </div>
            <div class="name-status">
                <h6 class="name">{{ $thread_details->user->name }}</h6>
                <!-- for offline just remove active class  -->
                <p class="status active">
                    <span class="now">Active</span>
                    <span class="was">Offile</span>
                </p>
            </div>
        </div>
        <div class="messenger-call-search d-flex align-items-center">
            <a href="#" class="call">
                <span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21.97 18.33C21.97 18.69 21.89 19.06 21.72 19.42C21.55 19.78 21.33 20.12 21.04 20.44C20.55 20.98 20.01 21.37 19.4 21.62C18.8 21.87 18.15 22 17.45 22C16.43 22 15.34 21.76 14.19 21.27C13.04 20.78 11.89 20.12 10.75 19.29C9.6 18.45 8.51 17.52 7.47 16.49C6.44 15.45 5.51 14.36 4.68 13.22C3.86 12.08 3.2 10.94 2.72 9.81C2.24 8.67 2 7.58 2 6.54C2 5.86 2.12 5.21 2.36 4.61C2.6 4 2.98 3.44 3.51 2.94C4.15 2.31 4.85 2 5.59 2C5.87 2 6.15 2.06 6.4 2.18C6.66 2.3 6.89 2.48 7.07 2.74L9.39 6.01C9.57 6.26 9.7 6.49 9.79 6.71C9.88 6.92 9.93 7.13 9.93 7.32C9.93 7.56 9.86 7.8 9.72 8.03C9.59 8.26 9.4 8.5 9.16 8.74L8.4 9.53C8.29 9.64 8.24 9.77 8.24 9.93C8.24 10.01 8.25 10.08 8.27 10.16C8.3 10.24 8.33 10.3 8.35 10.36C8.53 10.69 8.84 11.12 9.28 11.64C9.73 12.16 10.21 12.69 10.73 13.22C11.27 13.75 11.79 14.24 12.32 14.69C12.84 15.13 13.27 15.43 13.61 15.61C13.66 15.63 13.72 15.66 13.79 15.69C13.87 15.72 13.95 15.73 14.04 15.73C14.21 15.73 14.34 15.67 14.45 15.56L15.21 14.81C15.46 14.56 15.7 14.37 15.93 14.25C16.16 14.11 16.39 14.04 16.64 14.04C16.83 14.04 17.03 14.08 17.25 14.17C17.47 14.26 17.7 14.39 17.95 14.56L21.26 16.91C21.52 17.09 21.7 17.3 21.81 17.55C21.91 17.8 21.97 18.05 21.97 18.33Z"
                            stroke="#6D718C" stroke-width="1.5" stroke-miterlimit="10" />
                    </svg>
                </span>
            </a>
            <a href="#" class="call">
                <span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.53 20.42H6.21C3.05 20.42 2 18.32 2 16.21V7.78999C2 4.62999 3.05 3.57999 6.21 3.57999H12.53C15.69 3.57999 16.74 4.62999 16.74 7.78999V16.21C16.74 19.37 15.68 20.42 12.53 20.42Z" stroke="#6D718C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M19.5183 17.0999L16.7383 15.1499V8.83989L19.5183 6.88989C20.8783 5.93989 21.9983 6.51989 21.9983 8.18989V15.8099C21.9983 17.4799 20.8783 18.0599 19.5183 17.0999Z" stroke="#6D718C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </a>
            <form action="">
                <div class="messenger-search">
                    <label>
                        <input type="search" class="form-control" placeholder="Search …" title="Search for:">
                    </label>
                    <button type="submit" hidden=""></button>
                </div>
            </form>
        </div>
    </div>
    <ul class="messenger-body" id="scrollAbleContent">
        @php
            $my_data = auth()->user();
        @endphp
        @if ($thread_details->messages->isEmpty())
            <div class="no-message card-centered-section">
                <div class="card-middle-banner">
                    <img src="{{ get_image('assets/images/icons/no-message.svg') }}" alt="">
                </div>
            </div>
        @else
            @foreach ($thread_details->messages as $message)
                @if ($message->sender_id == $my_data->id)
                    <li>
                        <div class="single-message recipient-user">
                            <div class="user-wrap mb-3 d-flex align-items-center">
                                <div class="name-time d-flex flex-wrap flex-column">
                                    <h6 class="name">{{ $my_data->name }}</h6>
                                    <p class="time">{{ timeAgo($message->created_at) }}</p>
                                </div>
                                <div class="profile">
                                    <img src="{{ get_image($my_data->photo) }}" alt="">
                                </div>
                            </div>
                            <p class="message">{{ $message->message }}</p>
                        </div>
                    </li>
                @else
                    <li>
                        <div class="single-message">
                            <div class="user-wrap mb-3 d-flex align-items-center">
                                <div class="profile">
                                    <img src="{{ get_image($thread_details->user->photo) }}" alt="">
                                </div>
                                <div class="name-time d-flex flex-wrap flex-column">
                                    <h6 class="name">{{ $thread_details->user->name }}</h6>
                                    <p class="time">{{ timeAgo($message->created_at) }}</p>
                                </div>
                            </div>
                            <p class="message">{{ $message->message }}</p>
                        </div>
                    </li>
                @endif
            @endforeach
        @endif

    </ul>
    <div class="messenger-footer">
        <form action="{{ route(get_current_user_role() . '.message.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="sender_id" value="{{ $my_data->id }}">
            <input type="hidden" name="receiver_id" value="{{ $thread_details->user->id }}">
            <input type="hidden" name="thread_id" value="{{ $thread_details->id }}">

            <div class="messenger-footer-inner d-flex align-items-center">
                <input type="search" name="message" class="form-control form-control-message" placeholder="Type your message here...">
                
                <button type="submit" class="btn ol-btn-primary d-flex align-items-center cg-10px">
                    <span>
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.785 5.79323L14.5675 3.19906C18.06 2.0349 19.9575 3.94156 18.8025 7.43406L16.2083 15.2166C14.4667 20.4507 11.6067 20.4507 9.865 15.2166L9.095 12.9066L6.785 12.1366C1.55083 10.3949 1.55083 7.54406 6.785 5.79323Z" stroke="white" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9.26562 12.5125L12.5473 9.22168" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span>{{ get_phrase('Sent') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    "use strict";

    let divElement = document.getElementById('scrollAbleContent');
    // Scroll to the bottom of the div
    divElement.scrollTop = divElement.scrollHeight;
</script>
