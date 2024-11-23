@extends('dashboard.layouts.app')
@section('content')
    <!-- Main Content-->
                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">Profile</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
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
                        <form class="form-horizontal" data-select2-id="11" action="{{route('profile.update')}}" method="post">
                            @csrf
                            <div class="mb-4 main-content-label">Account</div>
                            <div class="form-group ">
                                <div class="row row-sm">
                                    <div class="col-md-3">
                                        <label class="form-label">Name</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" placeholder="Name"
                                               value="{{$user->username}}" required>
                                    </div>
                                    @error('name')
                                    <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row row-sm">
                                    <div class="col-md-3">
                                        <label class="form-label">Email</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email" placeholder="Email"
                                               value="{{$user->email}}" required>
                                    </div>
                                    @error('email')
                                    <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group " data-select2-id="108">
                                <div class="row" data-select2-id="107">
                                    <div class="col-md-3">
                                        <label class="form-label">Password</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="password" autocomplete="new-password">
                                    </div>
                                    @error('password')
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

    <!-- End Main Content-->

@endsection
