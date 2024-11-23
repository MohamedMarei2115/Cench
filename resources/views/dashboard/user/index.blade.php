@extends('dashboard.layouts.app')
@section('content')

    @error('email')
    <div class="alert alert-danger mg-b-0" role="alert">
        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>!خطأ </strong>الاميل يجب الا يكون مكرر
    </div>
    @enderror

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>!احسنت </strong> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mg-b-0" role="alert">
            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>!للاسف </strong> {{ session('error') }}
        </div>
    @endif
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div>
                        <h6 class="main-content-label mb-1">المستخدمين</h6>
                        <a class="btn ripple btn-primary float-end mb-2" data-bs-target="#addUser"
                           data-bs-toggle="modal" href="">اضافة مستخدم جديدة</a>
                    </div>
                    <div class="table-responsive">
                        <table id="example3" class="table table-striped table-bordered text-nowrap">
                            <thead>
                            <tr>
                                <th>كود</th>
                                <th>الاسم</th>
                                <th>الاميل</th>
                                <th>البلد المسؤل عنها</th>
                                <th>الوظيفة</th>
                                <th>الحالة</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @if($user->country_code == null)

                                        @else
                                            {{$user->country->name}}
                                        @endif

                                    </td>
                                    <td>
                                        @if($user->role_id == 0)
                                            <span style="color: green">مدير</span>
                                        @else
                                            <span style="color: red"> موظف</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->status == 1)
                                            <span style="color: green"> مفعل</span>
                                        @else
                                            <span style="color: red"> غير مفعل</span>
                                        @endif
                                    </td>
                                    <td class="d-flex">
                                        <a class="btn btn-success btn-with-icon me-2" data-bs-target="#editPage"
                                           data-bs-toggle="modal" data-id="{{$user->id}}"
                                           data-name="{{$user->name}}" data-email="{{$user->email}}"
                                           data-country="{{$user->country_code}}"
                                           data-status="{{$user->status}}"
                                           data-role="{{$user->role_id}}"
                                           data-countries="{{$countries}}"
                                           href=""><i class="fe fe-edit"></i>تعديل</a>

                                        <a class="btn btn-danger btn-with-icon me-2" data-bs-target="#deletePage"
                                           data-bs-toggle="modal" data-id="{{$user->id}}"
                                           data-name="{{$user->name}}"
                                           href=""><i class="fe fe-delete"></i>حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->


    <div class="modal" id="addUser" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">اضافة مستخدم جديدة</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('user.add')}}" class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <label for="name_create" class="mg-b-10">الاسم</label>
                        <input type="text" class="form-control" id="name_create" name="name" placeholder="الاسم" required>
                        <br>
                        <label for="email_create" class="mg-b-10">الاميل</label>
                        <input type="email" class="form-control" id="email_create" name="email" placeholder="كود الدولة"
                               required>
                        <br>
                        <label for="country_code_create" class="mg-b-10">الدولة المسؤل عنها</label>
                        <div class="form-group  select2-lg">
                            <select id="country_code_create" name="country_code" required
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                                @foreach($countries as $country)
                                    <option value="{{$country->code}}">{{$country->name}}</option>
                                @endforeach
                                    <option value='0'>الكل</option>
                            </select>
                        </div>
                        <br>
                        <label for="roll_id_create" class="mg-b-10">الوظيفة</label>
                        <div class="form-group  select2-lg">
                            <select id="roll_id_create" name="role_id" required
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                                <option value="1">موظف</option>
                                <option value="0">مدير</option>
                            </select>
                        </div>
                        <br>
                        <label for="password_create" class="mg-b-10">الباسورد</label>
                        <input type="password" class="form-control" id="password_create" name="password" placeholder="باسورد" required >
                        {{--                        <label for="status">الحالة</label><br>--}}
                        {{--                        <div class="form-check">--}}
                        {{--                            <input type="checkbox" class="form-check-input" id="status" name="status" checked>--}}
                        {{--                        </div>--}}
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">اضافة</button>
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">الغاء</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="modal" id="editPage" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل بيانات مستخدم</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('user.update')}}" class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="mg-b-10">الاسم</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="الاسم" required>
                        <br>
                        <label for="email" class="mg-b-10">الاميل</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="كود الدولة"
                               required>
                        <br>
                        <label for="country_code" class="mg-b-10">الدولة المسؤل عنها</label>
                        <div class="form-group  select2-lg">
                            <select id="country_code" name="country_code" required
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                                <option value="null">الكل</option>
                            </select>
                        </div>
                        <br>
                        <label for="roll_id" class="mg-b-10">الوظيفة</label>
                        <div class="form-group  select2-lg">
                            <select id="roll_id" name="role_id" required class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">

                            </select>
                        </div>
                        <br>
                        <label for="password" class="mg-b-10">الباسورد</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <input type="hidden" class="form-control" value="" name="id">
                        <label for="status">الحالة</label><br>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="status" name="status" checked>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">تعديل</button>
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">الغاء</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal" id="deletePage" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف مستخدم</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('user.delete')}}" class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">خلى بالك انت كدة هتحذف المستخدم الى اسمة <span class="page-name"></span></p>
                        <input type="hidden" class="form-control" value="" name="id">
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">حذف</button>
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">الغاء</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteModal = document.getElementById('deletePage');
            deleteModal.addEventListener('show.bs.modal', function (event) {
                // Get the button that triggered the modal
                var button = event.relatedTarget;

                // Extract info from data-id and data-name attributes
                var pageId = button.getAttribute('data-id');
                var pageName = button.getAttribute('data-name');

                // Update the hidden input field inside the modal with the page ID
                var hiddenInput = deleteModal.querySelector('input[name="id"]');
                hiddenInput.value = pageId;

                // Update the span or any element that will show the page name
                var Input = deleteModal.querySelector('span.page-name');
                if (Input) {
                    Input.innerHTML = `( ` + pageName + ` )`;
                    Input.style.fontSize = 'large';
                    Input.style.fontWeight = 'bold';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var editModal = document.getElementById('editPage');
            editModal.addEventListener('show.bs.modal', function (event) {
                // Get the button that triggered the modal
                var button = event.relatedTarget;

                // Extract info from data-id and data-name attributes
                var userId = button.getAttribute('data-id');
                var userName = button.getAttribute('data-name');
                var userEmail = button.getAttribute('data-email');
                var userStatus = button.getAttribute('data-status');
                var userCountryCode = button.getAttribute('data-country');
                var userRole = button.getAttribute('data-role');
                var countries = JSON.parse(button.getAttribute('data-countries'));

                // Update the hidden input field inside the modal with the country ID
                var hiddenInput = editModal.querySelector('input[name="id"]');
                hiddenInput.value = userId;

                // Update the span or any element that will show the country name
                var Input = editModal.querySelector('input[name="name"]');
                Input.value = userName;

                var InputEmail = editModal.querySelector('input[name="email"]');
                InputEmail.value = userEmail;

                var InputStatus = editModal.querySelector('input[name="status"]');
                InputStatus.checked = userStatus == 1;

                // Update the country_code select field
                var selectCountry = editModal.querySelector('select[name="country_code"]');
                selectCountry.innerHTML = '';  // Clear existing options

                // Loop through the countries array and add options to the select
                countries.forEach(function (country) {
                    var option = document.createElement('option');
                    option.value = country.code;
                    option.text = country.name;
                    if (country.code == userCountryCode) {
                        option.selected = true;
                    }
                    selectCountry.appendChild(option);
                });
                var optionAll = document.createElement('option');
                optionAll.value = '0';
                optionAll.text = 'الكل';
                if (userCountryCode == '') {
                    optionAll.selected = true;
                }
                selectCountry.appendChild(optionAll);



                // Update the country_code select field
                var selectRole = editModal.querySelector('select[name="role_id"]');
                selectRole.innerHTML = '';  // Clear existing options

                var option1 = document.createElement('option');
                option1.value ='1';
                option1.text = 'موظف';
                if (userRole == '1') {
                    option1.selected = true;
                }
                selectRole.appendChild(option1);

                var option2 = document.createElement('option');
                option2.value ='0';
                option2.text = 'مدير';
                if (userRole == '0') {
                    option2.selected = true;
                }
                selectRole.appendChild(option2);
            });
        });
    </script>
@endsection
