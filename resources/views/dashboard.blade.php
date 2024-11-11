@extends('layouts.admin')
@push('title', get_phrase('Dashboard'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="ol-card radius-8px">
                <div class="ol-card-body my-3 py-4 px-20px">
                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                        <h4 class="title fs-16px">
                            <i class="fi-rr-settings-sliders me-2"></i>
                            <span>{{ get_phrase('Dashboard') }}</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
