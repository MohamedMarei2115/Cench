@extends('dashboard.layouts.app')
@section('content')

    {{--    @error('code')--}}
    {{--    <div class="alert alert-danger mg-b-0" role="alert">--}}
    {{--        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">--}}
    {{--            <span aria-hidden="true">&times;</span>--}}
    {{--        </button>--}}
    {{--        <strong>!خطأ </strong> كود الدولة يجب الا يكون مكرر--}}
    {{--    </div>--}}
    {{--    @enderror--}}

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Good </strong> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mg-b-0" role="alert">
            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>!Opps </strong> {{ session('error') }}
        </div>
    @endif
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    {{--                    <div>--}}
                    {{--                        <h6 class="main-content-label mb-1">Avatars</h6>--}}
                    {{--                        --}}{{--                        <button class="btn ripple btn-main-primary float-end mb-2">Primary</button>--}}
                    {{--                        <a class="btn ripple btn-primary float-end mb-2" data-bs-target="#addPage"--}}
                    {{--                           data-bs-toggle="modal" href="">Add New Avatar</a>--}}
                    {{--                    </div>--}}

                    <div class="table-responsive border">
                        <table class="table text-nowrap text-md-nowrap mg-b-0">
                            <thead>
                            <tr>
                                {{--                                <th>#</th>--}}
                                <th>Customer Name</th>
                                <th>Products</th>
                                <th>Company Name</th>
                                <th>Country</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Province</th>
                                <th>Post_code</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($orders as $order)
                                <tr @if($order->status == 'delivered') style="background-color: #d7edcb " @elseif($order->status == 'in the way') style="background-color: #fff3cd " @endif>
                                <td>{{$order->customer}}</td>
                                    @php
                                        $products = json_decode($order->products)
                                    @endphp
                                    <td>
                                        @foreach($products as $product)
                                            {{$product->name}}  <span style="color: red">X</span> {{$product->quantity}} / {{$product->size}} <br>
                                        @endforeach
                                    </td>
                                    <td>{{$order->company_name}}</td>
                                    <td>{{$order->country}}</td>
                                    <td>{{$order->address}}</td>
                                    <td>{{$order->city}}</td>
                                    <td>{{$order->province}}</td>
                                    <td>{{$order->post_code}}</td>
                                    <td>{{$order->phone}}</td>
                                    <td>{{$order->email}}</td>
                                    <td>{{$order->total}}</td>
                                    <td>
                                        @if($order->status == 'delivered')
                                            <span style="color: green"> delivered</span>
                                        @else
                                            <span style="color: red">{{$order->status}}</span>
                                        @endif
                                    </td>
                                    <td class="d-flex ht-100">
                                        <a class="btn btn-success btn-with-icon me-2" data-bs-target="#editPage"
                                           data-bs-toggle="modal" data-id="{{$order->id}}"
                                           data-status="{{$order->status}}"
                                           href=""><i class="fe fe-edit"></i>Edit Status</a>

                                        <a class="btn btn-danger btn-with-icon me-2" data-bs-target="#deletePage"
                                           data-bs-toggle="modal" data-id="{{$order->id}}"
                                           data-name="{{$order->customer}}"
                                           href=""><i class="fe fe-delete"></i>Delete</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {{ $orders->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="modal" id="addPage" style="display: none;" aria-hidden="true">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content modal-content-demo">--}}
{{--                <div class="modal-header">--}}
{{--                    <h6 class="modal-title">Add New Avatar</h6>--}}
{{--                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>--}}
{{--                </div>--}}
{{--                <form method="post" action="{{route('avatar.add')}}" enctype="multipart/form-data"--}}
{{--                      class="p-4 bg-light rounded shadow-sm">--}}
{{--                    @csrf--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="name" class="mg-b-10">Name</label>--}}
{{--                        <input type="text" class="form-control" id="name" name="name" placeholder="Avatar Name"--}}
{{--                               required>--}}
{{--                        <br>--}}
{{--                        <label for="link" class="mg-b-10">Link</label>--}}
{{--                        <input type="text" class="form-control" id="link" name="link" placeholder="Link">--}}
{{--                        <br>--}}
{{--                        <label for="avatar" class="mg-b-10">Avatar Imag</label>--}}
{{--                        <div class="form-group  select2-lg">--}}
{{--                            <input type="file" class="form-control" id="avatar" name="avatar" placeholder="avatar Imag"--}}
{{--                                   required>--}}
{{--                        </div>--}}
{{--                        <label for="status">Status</label><br>--}}
{{--                        <div class="form-check">--}}
{{--                            <input type="checkbox" class="form-check-input" id="status" name="status" checked>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button class="btn ripple btn-primary" type="submit">Add</button>--}}
{{--                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>--}}
{{--                    </div>--}}
{{--                </form>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


    <div class="modal" id="editPage" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Order</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('order.update')}}" enctype="multipart/form-data"
                      class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
{{--                        <label for="name" class="mg-b-10">Name</label>--}}
{{--                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>--}}
{{--                        <br>--}}
{{--                        <label for="link" class="mg-b-10">Link</label>--}}
{{--                        <input type="text" class="form-control" id="link" name="link" placeholder="link">--}}
{{--                        <br>--}}
{{--                        <label for="avatar" class="mg-b-10">Avatar</label>--}}
{{--                        <div class="form-group  select2-lg">--}}
{{--                            <input type="file" class="form-control" id="avatar" name="avatar" placeholder="avatar">--}}
{{--                            <img onclick="" style="cursor: pointer;" class="wd-100 ht-100" name="avatar"--}}
{{--                                 id="avatarPreviw" src="">--}}
{{--                        </div>--}}
                        <label for="status">status</label><br>
                        <div class="form-group  select2-lg">
                            <select id="size" name="status" required
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                            </select>
                        </div>
                        <input type="hidden" class="form-control" value="" name="id">

                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">Edit</button>
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal" id="deletePage" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete Order</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('order.delete')}}" class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">Warning!! You are going to delete the order for customer named<span
                                class="page-name"></span></p>
                        <input type="hidden" class="form-control" value="" name="id">
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">Delete</button>
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">cancel</button>
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
                var orderId = button.getAttribute('data-id');
                // var avatarName = button.getAttribute('data-name');
                // var avatarLink = button.getAttribute('data-link');
                // var avatarImag = button.getAttribute('data-avatar');
                var orderStatus = button.getAttribute('data-status');

                // Update the hidden input field inside the modal with the country ID
                var hiddenInput = editModal.querySelector('input[name="id"]');
                hiddenInput.value = orderId;

                // Update the span or any element that will show the country name
                // var Input = editModal.querySelector('input[name="name"]');
                // Input.value = avatarName;
                //
                // var InputLink = editModal.querySelector('input[name="link"]');
                // InputLink.value = avatarLink;
                //
                // var InputImag = editModal.querySelector('img[name="avatar"]');
                // InputImag.src = avatarImag;

                var selectStatus = editModal.querySelector('select[name="status"]');
                selectStatus.innerHTML = '';  // Clear existing options

                var option1 = document.createElement('option');
                option1.value = 'pending';
                option1.text = 'pending';
                if (orderStatus === 'pending') {
                    option1.selected = true;
                }
                selectStatus.appendChild(option1);

                var option2 = document.createElement('option');
                option2.value = 'in the way';
                option2.text = 'in the way';
                if (orderStatus === 'in the way') {
                    option2.selected = true;
                }
                selectStatus.appendChild(option2);

                var option3 = document.createElement('option');
                option3.value = 'delivered';
                option3.text = 'delivered';
                if (orderStatus === 'delivered') {
                    option3.selected = true;
                }
                selectStatus.appendChild(option3);
            });
        });
    </script>
@endsection
