@extends('layouts.driver')


@push('head_tags')
    <link rel='stylesheet' href="{{ asset('/assetss/css/pages/profile.css') }}" data-name="driver" />
    <style type="text/css">
        .card-body.call-history {
            unicode-bidi: bidi-override;
            direction: ltr;
            overflow: scroll;
            overflow-x: hidden !important;
            max-height: 408px;
        }

        .card-body.driver-locations {
            unicode-bidi: bidi-override;
            direction: ltr;
            overflow: scroll;
            overflow-x: hidden !important;
            max-height: 408px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('/assetss/vendor/libs/select2/select2.css') }} " />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/assetss/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endpush

@section('title', 'Profile')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">


        <h4 class="py-3 breadcrumb-wrapper mb-4">
        </h4>


        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    {{-- <div class="user-profile-header-banner ">
                        <img class="w-100" src="{{ asset('/assetss/img/pages/profile-banner.png') }}" alt="Banner image"
                            class="rounded-top">
                    </div> --}}
                    <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                            @isset($driver->photo->driversphoto)
                                <img src="data:image/png;base64,{{ chunk_split(base64_encode($driver->photo->driversphoto)) }}"
                                    alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded-3 user-profile-img" />
                            @endisset
                        </div>
                        <div class="flex-grow-1 mt-3 mt-sm-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4>{{ $driver->full_name }} <a href="{{route('edit_history')}}"><i class="fa fa-clock" title="Edit History"></i></a> </h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                        {{--  <li class="list-inline-item fw-semibold">
                                            <i class='bx bx-pen'></i> Driver
                                        </li> --}}

                                        <li class="list-inline-item fw-semibold w-100">
                                            <i class='bx bx-calendar-alt'></i> Joined on
                                            {{ isset($driver->signupdate) ? $driver->signupdate->toFormattedDateString() : '' }}
                                        </li>

                                        <li class="list-inline-item fw-semibold w-100">
                                            You are <span
                                                id="duty-status-text"><b>{{ $driver->dutystatus ? 'on' : 'off' }}</b></span>
                                            duty
                                            <label class="switch switch-lg switch-success">
                                                <input type="checkbox" class="switch-input" @checked($driver->dutystatus)
                                                    onchange="changeDutyStatus()" />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="bx bx-check"></i>
                                                        On Duty
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="bx bx-x"></i> Off duty
                                                    </span>
                                                </span>
                                            </label>


                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Header -->

        <!-- Navbar pills -->
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-sm-row mb-4">
                    {{-- <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class='bx bx-user'></i>
                            Profile</a></li> --}}
                    {{--   <li class="nav-item"><a class="nav-link" href="pages-profile-teams.html"><i class='bx bx-group'></i> Teams</a></li>
      <li class="nav-item"><a class="nav-link" href="pages-profile-projects.html"><i class='bx bx-grid-alt'></i> Projects</a></li>
      <li class="nav-item"><a class="nav-link" href="pages-profile-connections.html"><i class='bx bx-link-alt'></i> Connections</a></li> --}}
                </ul>
            </div>
        </div>
        <!--/ Navbar pills -->

        <!-- User Profile Content -->
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5 mb-3">
                <!-- Driver Messages -->
                <div class="card card-action mb-4">
                    <div class="card-header align-items-center">
                        <h5 class="card-action-title mb-0"><i
                                class='bx bx-list-ul bx-sm me-2'></i>{{ $driver->calls->count() ? 'Driver Messages' : 'No Messages Yet' }}
                        </h5>
                        {{-- Card Actions --}}
                        {{-- <div class="card-action-element btn-pinned">
                            <div class="dropdown">
                                <button type="button" class="btn dropdown-toggle hide-arrow p-0"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="bx bx-dots-vertical-rounded"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="javascript:void(0);">Share timeline</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-body driver-messages">

                        <div class="table-actions-jsn mb-2">
                            <div class="form-check mt-3">
                                <input class="form-check-input bg-primary-checkbox" type="checkbox" value=""
                                    id="defaultCheck1" onchange="toggleUnreadMessages()" />
                                <label class="form-check-label" for="defaultCheck1">
                                    Show only unread messages
                                </label>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Datetime</th>

                                        <th>Message</th>
                                    </tr>
                                </thead>
                                <tbody class="driver-messages-tbody">

                                    @foreach ($driver->messages as $driverMessage)
                                        <tr
                                            class="{{ $driverMessage->messagestatus ? 'seen-message' : 'table-danger unseen-message' }}">
                                            <td class="col-3 p-1">
                                                <div class="row">
                                                    <div>{{ $driverMessage->messagedatetime->toFormattedDateString() }}
                                                    </div>

                                                </div>
                                            </td>
                                            <td class="col-9">{{ $driverMessage->message->messagetext }}@if ($driverMessage->messagestatus == 0)
                                                    <div>
                                                        <button type="button" class="btn btn-icon me-2 btn-primary"
                                                            onclick="markMessageAsSeen(this, {{ $driverMessage->drivermessageid }})">
                                                            <span class="tf-icons bx bx-check"></span>
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>



                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- <ul class=" ms-2">
                            @foreach ($driver->messages as $message)
                            <li class="mb-3">
                                <div class="row">
                                    <div class="col-8">
                                        {{ $message->message->messagetext }}
                                    </div>
                                    <div class="col-2">
                                        {{ $message->messagedatetime->toDayDateTimeString() }}
                                    </div>
                                </div>
                            </li>
                            <hr>
                            @endforeach
                        </ul> --}}
                    </div>
                </div>
                <!--/ Driver Message End -->
                <!-- Driver Locations -->
                <div class="col-lg-12 ">
                    <div class="card card-action mb-4">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">{{ count($driver->locations) > 0 ? "Driver Locations" : "No Locations Yet" }}</h5>
                            <div class="card-action-element btn-pinned">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addLocationModal">
                                    Add Location
                                </button>
                                {{-- <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle hide-arrow p-0"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="bx bx-dots-vertical-rounded"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0);">Share connections</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                                    </ul>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body driver-locations">
                            <div class="form-check form-check-inline my-3 w-50">
                                @if ( count($driver->locations ) > 0)
                                <div class="row">
                                    <div class="col-6">

                                        <input class="form-check-input" type="checkbox" id="toggle-all-driver-locations" value="option1" />
                                        <label class="form-check-label" for="toggle-all-driver-locations">Select All</label>
                                    </div>
                                    <div class="col-6" id="delete-locations-container" style="display: none">
                                        <button type="button" class="btn btn-danger mb-3" onclick="confirmDeleteLocations()">Delete</button>
                                    </div>
                                </div>
                                @endif
                              </div>
                            
                            <ul class="list-unstyled mb-0" id="locationsList">

                                <form action="/jsn">
                                    @foreach ($driver->locations as $location)
                                        <li class="mb-3">
                                            <div class="d-flex align-items-start">
                                                <div class="d-flex align-items-start">
                                                    <div class="me-2"><input name="selectedLocations[]"
                                                            class="form-check-input" type="checkbox"
                                                            value="{{ $location->locationid }}"
                                                            onchange="onLocationCheckboxChange()"></div>
                                                    <div class="me-2">
                                                        <h6 class="mb-0">{{ $location->town }}, {{ $location->county }}
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <a target="_blank"
                                                        href="http://www.google.com/maps/place/{{ $location->latitude }},{{ $location->longitude }}"
                                                        class="btn btn-label-primary p-1 btn-sm"><i
                                                            class="bx bx-map"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </form>

                                {{-- <li class="text-center">
                                    <a href="javascript:;">View all teams</a>
                                </li> --}}

                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ Driver Locations -->

                <!-- Accordion -->
                <div class="accordion accordion-header-primary" id="user-details-parent">
                    <div class="accordion-item card">
                        <h2 class="accordion-header">
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#personal-info" aria-expanded="false">
                                Personal Info
                            </button>
                        </h2>

                        <div id="personal-info" class="accordion-collapse collapse"
                            data-bs-parent="#user-details-parent">
                            <div class="accordion-body">
                                <!-- About User -->
                                <div class="card mb-4 shadow-none">
                                    <div class="card-body p-0">
                                        <ul class="list-unstyled mb-4 mt-3">

                                            <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span
                                                    class="fw-semibold mx-2">Username:</span>
                                                <span>{{ $driver->username }}</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3"><i class="bx bx-phone"></i><span
                                                    class="fw-semibold mx-2">Contact:</span>
                                                <span>{{ $driver->phone }}</span>
                                            </li>

                                            <li class="d-flex align-items-center mb-3"><i class="bx bx-envelope"></i><span
                                                    class="fw-semibold mx-2">Email:</span>
                                                <span>{{ $driver->email }}</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span
                                                    class="fw-semibold mx-2">Business URL:</span>
                                                <span>{{ $driver->businessurl }}</span>
                                            </li>
                                        </ul>
                                        <h5>About</h5>
                                        <ul class="list-unstyled mb-4 mt-3">
                                            {{ $driver->description }}
                                        </ul>

                                        <h5>Vehicle Details</h5>

                                        <ul class="list-unstyled mb-4 mt-3">

                                            <li class="d-flex align-items-center mb-3"><i
                                                    class='bx bx-car'></i></i></i><span class="fw-semibold mx-2">4 Seater
                                                    Vehicle:</span>
                                                <span>{{ $driver->{"4seatervehicle"} ? 'Yes' : 'No' }}</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3"><i class='bx bx-car'></i></i><span
                                                    class="fw-semibold mx-2">8 Seater Vehicle:</span>
                                                <span>{{ $driver->{"8seatervehicle"} ? 'Yes' : 'No' }}</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3"><i class='bx bx-car'></i></i><span
                                                    class="fw-semibold mx-2">Estate Vehicle:</span>
                                                <span>{{ $driver->estatevehicle ? 'Yes' : 'No' }}</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3"><i class='bx bx-car'></i></i><span
                                                    class="fw-semibold mx-2">Courier Vehicle:</span>
                                                <span>{{ $driver->courier ? 'Yes' : 'No' }}</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3"><i class='bx bx-car'></i></i><span
                                                    class="fw-semibold mx-2">Easy Access Vehicle:</span>
                                                <span>{{ $driver->easyaccessvehicle ? 'Yes' : 'No' }}</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3"><i class='bx bx-car'></i></i><span
                                                    class="fw-semibold mx-2">AirPort Runs:</span>
                                                <span>{{ $driver->airportruns ? 'Yes' : 'No' }}</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3"><i class='bx bx-car'></i></i><span
                                                    class="fw-semibold mx-2">Wheel Chair Friendly:</span>
                                                <span>{{ $driver->wheelchairfriendly ? 'Yes' : 'No' }}</span>
                                            </li>

                                        </ul>

                                        {{-- <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                <li class="">
                    
              
                
              </ul> --}}
                                        {{--       <button type="button" class="">Primary</button> --}}

                                        <h5>Licence</h5>
                                        <div class="license-flash"></div>
                                        <ul class="list-unstyled mb-4 mt-3">
                                            <li class="d-flex align-items-center mb-3">

                                                <img style="width: 100%; height: auto"
                                                    src="data:image/png;base64,{{ chunk_split(base64_encode($driver->license->licensephoto)) }}"
                                                    alt="">
                                            </li>
                                            <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span
                                                    class="fw-semibold mx-2">Number:</span>
                                                <span>{{ $driver->licensenumber }}</span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span
                                                    class="fw-semibold mx-2">Expiry:</span>
                                                <span>{{ $driver->licenseexpiry->toFormattedDateString() }}</span>
                                            </li>
                                            <a href="javascript:void(0)"
                                                class="btn rounded-pill btn-primary license-edit-btn"
                                                data-driverid="{{ $driver->driverid }}"><small
                                                    class="list-inline-item fw-semibold">Edit Licence <i
                                                        class="bx bx-pen"></i></a></small>
                                        </ul>



                                    </div>
                                </div>
                                <!--/ About User -->
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item card">
                        <h2 class="accordion-header">
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#payment-history" aria-expanded="false">
                                {{ $driver->payments->count() ? 'Payment History' : 'No Payment History yet' }}
                            </button>
                        </h2>
                        <div id="payment-history" class="accordion-collapse collapse"
                            data-bs-parent="#user-details-parent">
                            <div class="accordion-body">

                                <!-- Payment History -->
                                <div class="card card-action mb-4 payment-history-mobile d-block  shadow-none">
                                    <div class="card-header align-items-center">

                                        {{--  <div class="card-action-element btn-pinned">
                            <div class="dropdown">
                                <button type="button" class="btn dropdown-toggle hide-arrow p-0"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="bx bx-dots-vertical-rounded"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="javascript:void(0);">Share teams</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                                </ul>
                            </div>
                        </div> --}}
                                    </div>
                                    <div class="card-body payment-history p-0">
                                        <ul class="list-unstyled mb-0">

                                            @foreach ($driver->payments as $payment)
                                                <li class="mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex align-items-start">
                                                            <div class="me-2">
                                                                <h6 class="mb-0">
                                                                    {{ $payment->paymentdatetime->toDayDateTimeString() }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <a href="javascript:;"><span
                                                                    class="badge bg-label-danger">{{ $payment->paymentamount }}</span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach





                                            {{--  <li class="text-center">
                                <a href="javascript:;">View all teams</a>
                            </li> --}}
                                        </ul>
                                    </div>
                                </div>
                                <!--/ Payment History -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Accordion end -->

            </div>


            <div class="col-xl-8 col-lg-7 col-md-7">

                <!-- Call History -->
                <div class="card card-action mb-4">
                    <div class="card-header align-items-center">
                        <h5 class="card-action-title mb-0"><i
                                class='bx bx-list-ul bx-sm me-2'></i>{{ $driver->calls->count() ? 'Call History' : 'No Calls Yet' }}
                        </h5>
                        {{-- Card Actions --}}
                        {{-- <div class="card-action-element btn-pinned">
                            <div class="dropdown">
                                <button type="button" class="btn dropdown-toggle hide-arrow p-0"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="bx bx-dots-vertical-rounded"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="javascript:void(0);">Share timeline</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-body call-history">
                        <ul class="timeline ms-2">
                            @foreach ($driver->calls as $call)
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point timeline-point-warning"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0">
                                                {{ isset($call->location->town) ? $call->location->town : '' }},
                                                {{ isset($call->location->county) ? $call->location->county : '' }}
                                            </h6>
                                            <small
                                                class="text-muted">{{ isset($call->datetime) ? $call->datetime->diffForHumans() : '' }}</small>
                                        </div>
                                        <p class="mb-2">
                                            {{ isset($call->datetime) ? $call->datetime->toDayDateTimeString() : '' }}</p>

                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!--/ Call History -->





                <!-- Projects table -->
                {{-- <div class="card">
                    <div class="card-datatable table-responsive">
                        <table class="datatables-projects border-top table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Leader</th>
                                    <th>Team</th>
                                    <th class="w-px-200">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div> --}}
                <!--/ Projects table -->
            </div>
        </div>
        <!--/ User Profile Content -->


    </div>
    <!-- / Content -->




    <!-- Add Location Modal -->
    <div class="modal fade" id="addLocationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Locations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('locations.store') }}" onsubmit="saveLocations()" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <div class="mb-3">
                                    <label for="select2Basic" class="form-label">Locations</label>
                                    <select id="selectNewLocation" class="select2 form-select form-select-lg"
                                        data-allow-clear="true" multiple>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" disabled id="saveLocationsButton">Save
                            Locations</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--/ Add Location Modal -->
@endsection


@push('body_scripts')
<script src="{{ asset('/assetss/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('/assetss/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function() {

            

            

            $('.license-edit-btn').on('click', function(e) {
                e.preventDefault();
                var driverid = $(this).data('driverid');
                var url = '{{ route('license.edit', 'tempid') }}';
                url = url.replace('tempid', driverid);
                $.ajax({
                    url: url,
                    type: "GET",
                    datatype: 'html',
                    data: {},
                    success: function(response) {
                        console.log(response);
                        $('#commonModal .modal-content').html(response);
                        $('#commonModal').modal('show');
                    },

                    error: function(err) {
                        console.log(err);
                    }
                });
            });

            $('body').on('change', '#licenseimage', function() {
                readURL(this);
            });

            $('body').on('submit', '#license-edit-form', function(e) {
                e.preventDefault();
                var $this = $(this);

                $.ajax({
                    url: $this.prop('action'),
                    method: $this.prop('method'),
                    dataType: 'json',
                    data: new FormData(this), //4
                    contentType: false,
                    cache: false,
                    processData: false,
                }).done(function(response) {
                    console.log(response);
                    $(".invalid-feedback").html('');
                    $(".invalid-feedback").css('display', 'none');
                    if (response.status == 1) {
                        //$(".closeModal").trigger('click');
                        Swal.fire({
                            html:'Application has been received, we will review it and your profile will be updated once it is approved internally.<br><br>You can track the pending application to get current status by <a href="{{route('edit_history')}}">clicking here</a>',
                            icon: 'success',
                            confirmButtonText: 'Close',
                        }).then((result) => {
                          
                          if (result.isConfirmed) {
                            //Swal.fire('Saved!', '', 'success')
                            $(".closeModal").trigger('click');
                          } else if (result.isDenied) {
                            $(".closeModal").trigger('click');
                          }
                        })
                    }
                    if (response.alert_class && response.alert_message) {
                        var alertdata = '<div class="alert ' + response.alert_class + '">' +
                            response.alert_message + '</div>';
                        $('.license-flash').html(alertdata);
                    }
                    if (response.status == 2) {

                        $.each(response.errors, function(key, error) {
                            $("#license-edit-form #" + key + "").css('display',
                                'inline-block');
                            $("#license-edit-form #" + key + "").html('<strong>' + error[
                                0] + '</strong>');
                        });
                    }
                });
            }); //update country

            //license-edit-form

        }); //ready
        function toggleUnreadMessages() {
            $('.driver-messages-tbody .seen-message').toggle()

        }

        function changeDutyStatus() {
            let dutyStatus = event.target.checked ? "on" : "off";
            $('#duty-status-text').text(dutyStatus);

            $.ajax({
                // url: "{{ route('change-duty-status') }}",
                url: "/change-duty-status",
                type: "get",
                data: {
                    action: dutyStatus,
                },
                success: function(response) {
                    console.log(response);
                },

                error: function(err) {
                    console.log(err);
                }
            })
        }

        function markMessageAsSeen(buttonElem, driverMessageId) {
            let url = "{{ route('messages.mark-as-seen', ['driver_message' => 'replaceMeWithId']) }}";
            url = url.replace('replaceMeWithId', driverMessageId);
            $.ajax({
                url,
                type: 'get',
                success: (response) => {
                    console.log('response>>', response);
                    let messageDiv = $(buttonElem).closest('.unseen-message');
                    messageDiv.removeClass('table-danger unseen-message');
                    messageDiv.addClass('seen-message');
                    buttonElem.remove();
                },
                error: (err) => console.log(err),
            })
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#licenseimage_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function parseLocationsForSelect2(locations) {
            let results = locations.data.map((location) => {
                return {
                    id: location.locationid,
                    text: location.town
                };
            });
            console.log('results', results);

            let more = locations.current_page < locations.last_page;

            return {
                results,
                pagination: {
                    more
                }
            };
        }



        function saveLocations() {
            event.preventDefault();

            let locationIds = $("#selectNewLocation").select2('data').map((option) => {
                return option.id;
            });

            let data = {
                locations: locationIds,
            };

            $.ajax({
                url: "{{ route('locations.store') }}",
                type: 'post',
                data,
                success: (response) => {
                    $("#addLocationModal").modal('hide')
                    window.location.reload();
                },
                error: (err) => console.log(err),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            // console.log('this is event: ', event);
        }


        function onLocationCheckboxChange() {
            let checkedLocations = $("input[name='selectedLocations[]']:checked");

            if (checkedLocations.length) {
                $("#delete-locations-container").show();
                return;
            }

            $("#delete-locations-container").hide();
            return;
        }
        

        function confirmDeleteLocations() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteDriverLocations();
                    
                }
            })
        }

        function deleteDriverLocations()
        {
            let checkedLocations = $("input[name='selectedLocations[]']:checked")
            let locationIds = [];
            checkedLocations.each( function(){
                locationIds.push($(this).val());
            }); 

            $.ajax({
                url: "{{ route('locations.delete') }}",
                type: 'post',
                data: { locations: locationIds},
                success: (response) => {
                    console.log(response);
                    Swal.fire({icon: 'success', title: "Locations Deleted"}).then( () => window.location.reload());
                    // window.location.reload();
                },
                error: (err) => console.log(err),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        }
        

        $(document).ready(() => {

            $("#selectNewLocation").select2({
                dropdownParent: $('#addLocationModal'),
                ajax: {
                    url: "{{ route('locations.list') }}",
                    data: function(params) {
                        var query = {
                            search: params.term,
                            page: params.page || 1
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: (data) => {
                        data = parseLocationsForSelect2(data);
                        return data;

                    },
                }
            });

            $('#selectNewLocation').on('change', function() {
                if ($(this).select2('data').length > 0) {
                    $('#saveLocationsButton').attr('disabled', false);
                    return;
                }
                $('#saveLocationsButton').attr('disabled', true);

            });

            $("#toggle-all-driver-locations").on('change', function(){

                let isChecked = $(this).is(":checked");
                $("input[name='selectedLocations[]']").prop('checked', isChecked);
                onLocationCheckboxChange();

            });



        });
    </script>

    
@endpush
