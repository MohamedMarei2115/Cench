@extends('dashboard.layouts.app')
@section('content')
    <!-- Main Content-->
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">General Settings</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active" aria-current="page">General Settings</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Well done!</strong> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mg-b-0" role="alert">
            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Oh snap!</strong> {{ session('error') }}
        </div>
    @endif
    <div class="main-content-body tab-pane p-4 border-top-0" id="settings">
        <div class="card-body border" data-select2-id="12">
            <form class="form-horizontal" data-select2-id="11" action="{{route('general.store')}}" method="post">
                @csrf
                @php
                    $easy = \App\Models\GenralSetting::where('key','easy_level_points')->first();
                    $medium = \App\Models\GenralSetting::where('key','medium_level_points')->first();
                    $hard = \App\Models\GenralSetting::where('key','hard_level_points')->first();
                    $complete = \App\Models\GenralSetting::where('key','complete_task_in_time')->first();
                    $createCard = \App\Models\GenralSetting::where('key','create_new_card')->first();

                @endphp
                <div class="mb-4 main-content-label">Points</div>
                <div class="form-group ">
                    <div class="row row-sm">
                        <div class="col-md-3">
                            <label class="form-label">Easy Level</label>
                        </div>
                        <div class="col-md-9">
                            <input type="number" min="1" step="1" class="form-control" name="easy_level_points"
                                   placeholder="Easy Level Points"
                                   value="{{isset($easy) ? $easy->value : ''}}" required>
                        </div>
                        @error('easy_level_points')
                        <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row row-sm">
                        <div class="col-md-3">
                            <label class="form-label">Medium Level</label>
                        </div>
                        <div class="col-md-9">
                            <input type="number" min="1" step="1" class="form-control" name="medium_level_points"
                                   placeholder="Medium Level Points"
                                   value="{{isset($medium) ? $medium->value : ''}}" required>
                        </div>
                        @error('medium_level_points')
                        <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group " data-select2-id="108">
                    <div class="row row-sm">
                        <div class="col-md-3">
                            <label class="form-label">Hard Level</label>
                        </div>
                        <div class="col-md-9">
                            <input type="number" min="1" step="1" class="form-control" name="hard_level_points"
                                   placeholder="Hard Level Points"
                                   value="{{isset($hard) ? $hard->value : ''}}" required>
                        </div>
                        @error('hard_level_points')
                        <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group " data-select2-id="108">
                    <div class="row row-sm">
                        <div class="col-md-3">
                            <label class="form-label">Complete Task In Time</label>
                        </div>
                        <div class="col-md-9">
                            <input type="number" min="1" step="1" class="form-control" name="complete_task_in_time"
                                   placeholder="Complete Task In Time Points"
                                   value="{{isset($complete) ? $complete->value : ''}}" required>
                        </div>
                        @error('complete_task_in_time')
                        <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group " data-select2-id="108">
                    <div class="row row-sm">
                        <div class="col-md-3">
                            <label class="form-label">Create New Card</label>
                        </div>
                        <div class="col-md-9">
                            <input type="number" min="1" step="1" class="form-control" name="create_new_card"
                                   placeholder="Create New Card Points"
                                   value="{{isset($createCard) ? $createCard->value : ''}}" required>
                        </div>
                        @error('create_new_card')
                        <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="btn-list">
                    <button type="submit" class="btn ripple btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>


    <div class="main-content-body tab-pane p-4 border-top-0" id="settings">
        <div class="card-body border" data-select2-id="12">
            <form class="form-horizontal" data-select2-id="11" action="{{route('general.store')}}" method="post">
                @csrf
                @php
                    $AppWeekStartDay = \App\Models\GenralSetting::where('key','app_week_start_day')->first();
                    $weekStartDay = \App\Models\GenralSetting::where('key','week_start_day')->first();
                    //$hard = \App\Models\GenralSetting::where('key','hard_level_points')->first();
                    //$complete = \App\Models\GenralSetting::where('key','complete_task_in_time')->first();
                    //$createCard = \App\Models\GenralSetting::where('key','create_new_card')->first();

                @endphp
                <div class="mb-4 main-content-label">Rank Start Days</div>
                <div class="form-group ">
                    <div class="row row-sm">
                        <div class="col-md-3">
                            <label class="form-label">App Week Rank Start Day</label>
                        </div>
                        <div class="col-md-9">
                            <select id="type" name="app_week_start_day" required
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                                <option value="saturday" {{ isset($AppWeekStartDay) && $AppWeekStartDay->value == 'saturday' ? 'selected' : '' }}>Saturday</option>
                                <option value="sunday" {{ isset($AppWeekStartDay) && $AppWeekStartDay->value == 'sunday' ? 'selected' : '' }}>Sunday</option>
                                <option value="monday" {{ isset($AppWeekStartDay) && $AppWeekStartDay->value == 'monday' ? 'selected' : '' }}>Monday</option>
                                <option value="tuesday" {{ isset($AppWeekStartDay) && $AppWeekStartDay->value == 'tuesday' ? 'selected' : '' }}>Tuesday</option>
                                <option value="wednesday" {{ isset($AppWeekStartDay) && $AppWeekStartDay->value == 'wednesday' ? 'selected' : '' }}>Wednesday</option>
                                <option value="thursday" {{ isset($AppWeekStartDay) && $AppWeekStartDay->value == 'thursday' ? 'selected' : '' }}>Thursday</option>
                                <option value="friday" {{ isset($AppWeekStartDay) && $AppWeekStartDay->value == 'friday' ? 'selected' : '' }}>Friday</option>
                            </select>
{{--                            <input type="number" min="1" step="1" class="form-control" name="easy_level_points"--}}
{{--                                   placeholder="Easy Level Points"--}}
{{--                                   value="{{isset($easy) ? $easy->value : ''}}" required>--}}
                        </div>
                </div>
                    <br>
                <div class="form-group ">
                    <div class="row row-sm">
                        <div class="col-md-3">
                            <label class="form-label">Week Rank Start Day</label>
                        </div>
                        <div class="col-md-9">
                            <select id="type" name="week_start_day" required
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                                <option value="saturday" {{ isset($weekStartDay) && $weekStartDay->value == 'saturday' ? 'selected' : '' }}>Saturday</option>
                                <option value="sunday" {{ isset($weekStartDay) && $weekStartDay->value == 'sunday' ? 'selected' : '' }}>Sunday</option>
                                <option value="monday" {{ isset($weekStartDay) && $weekStartDay->value == 'monday' ? 'selected' : '' }}>Monday</option>
                                <option value="tuesday" {{ isset($weekStartDay) && $weekStartDay->value == 'tuesday' ? 'selected' : '' }}>Tuesday</option>
                                <option value="wednesday" {{ isset($weekStartDay) && $weekStartDay->value == 'wednesday' ? 'selected' : '' }}>Wednesday</option>
                                <option value="thursday" {{ isset($weekStartDay) && $weekStartDay->value == 'thursday' ? 'selected' : '' }}>Thursday</option>
                                <option value="friday" {{ isset($weekStartDay) && $weekStartDay->value == 'friday' ? 'selected' : '' }}>Friday</option>
                            </select>
                            {{--                            <input type="number" min="1" step="1" class="form-control" name="easy_level_points"--}}
                            {{--                                   placeholder="Easy Level Points"--}}
                            {{--                                   value="{{isset($easy) ? $easy->value : ''}}" required>--}}
                        </div>
                    </div>
                </div>
                <div class="btn-list">
                    <button type="submit" class="btn ripple btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- End Main Content-->

@endsection
