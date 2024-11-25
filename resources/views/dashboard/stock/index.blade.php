@extends('dashboard.layouts.app')
@section('style')
    <style>
        #popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        #popup.active {
            display: block;
        }

        #popup-content {
            margin-bottom: 20px;
        }
    </style>
@endsection
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
                    <div>
                        <h6 class="main-content-label mb-1">Stock</h6>
                        {{--                        <button class="btn ripple btn-main-primary float-end mb-2">Primary</button>--}}
                        <a class="btn ripple btn-primary float-end mb-2" data-bs-target="#addPage"
                           data-bs-toggle="modal" href="">Add New Stock Item</a>
                    </div>

                    <div class="table-responsive border">
                        <table class="table text-nowrap text-md-nowrap mg-b-0">
                            <thead>
                            <tr>
                                {{--                                <th>#</th>--}}
                                <th>Product</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($stocks as $stock)
                                <tr>
                                    {{--                                    <th scope="row">{{$avatar->id}}</th>--}}
                                    <td>{{$stock->product->name}}</td>
                                    <td>{{$stock->size->size}}</td>
                                    <td>{{$stock->price}}</td>
                                    <td>{{$stock->quantity}}</td>
                                    <td class="d-flex  justify-center">
                                        <a class="btn btn-success btn-with-icon me-2" data-bs-target="#editPage"
                                           data-bs-toggle="modal" data-id="{{$stock->id}}"
                                           data-product_id="{{$stock->product_id}}"
                                           data-size_id="{{$stock->size_id}}"
                                           data-quantity="{{$stock->quantity}}"
                                           data-price="{{$stock->price}}"
                                           data-products="{{$products}}"
                                           data-sizes="{{$sizes}}"
                                           href=""><i class="fe fe-edit"></i>Edit</a>

                                        <a class="btn btn-danger btn-with-icon me-2" data-bs-target="#deletePage"
                                           data-bs-toggle="modal" data-id="{{$stock->id}}"
                                           data-name="{{$stock->product->name}}"
                                           href=""><i class="fe fe-delete"></i>Delete</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {{ $stocks->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="addPage" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add New Stock Item</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('stock.add')}}" enctype="multipart/form-data"
                      class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="mg-b-10">Product</label>
                        <select id="event" name="product_id" required
                                class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                aria-hidden="true">
                            @foreach($products as $product)
                                <option
                                    value="{{$product->id}}">{{$product->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <label for="event" class="mg-b-10">Size</label>
                        <div class="form-group  select2-lg">
                            <select id="event" name="size_id" required
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                                @foreach($sizes as $size)
                                    <option
                                        value="{{$size->id}}">{{$size->size}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="price" class="mg-b-10">Price</label>
                        <div class="form-group  select2-lg">
                            <input type="number" min="1" step=".5" class="form-control" id="price" name="price"
                                   placeholder="Price" required>
                        </div>
                        <label for="quantity" class="mg-b-10">Quantity</label>
                        <div class="form-group  select2-lg">
                            <input type="number" min="1" step="1" class="form-control" id="quantity" name="quantity"
                                   placeholder="quantity" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">Add</button>
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="modal" id="editPage" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Product</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('stock.add')}}" enctype="multipart/form-data"
                      class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <label for="product" class="mg-b-10">Product</label>
                        <div class="form-group  select2-lg">
                            <select id="product" name="product_id" required readonly
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                            </select>
                        </div>

                        <label for="size" class="mg-b-10">Size</label>
                        <div class="form-group  select2-lg">
                            <select id="size" name="size_id" required readonly
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                            </select>
                        </div>
                        <label for="price" class="mg-b-10">Price</label>
                        <input type="number" step=".5" min="1" class="form-control" id="price" name="price"
                               required>
                        <br>
                        <label for="quantity" class="mg-b-10">Quantity</label>
                        <input type="number" step="1" min="1" class="form-control" id="quantity" name="quantity"
                               required>
                        <br>
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
                    <h6 class="modal-title">Delete Avatar</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('stock.delete')}}" class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">Warning!! You are going to delete the item named<span
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
    <div id="popup" class="popup">
        <div id="popup-content"></div>
        <button onclick="hidePopup()">close</button>
    </div>@endsection

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
                var stocktId = button.getAttribute('data-id');
                var productId = button.getAttribute('data-product_id');
                var productSize = button.getAttribute('data-size_id');
                var productQuantity = button.getAttribute('data-quantity');
                var productPrice = button.getAttribute('data-price');

                var products = button.getAttribute('data-products');
                var sizes = button.getAttribute('data-sizes');

                // Update the hidden input field inside the modal with the country ID
                var hiddenInput = editModal.querySelector('input[name="id"]');
                hiddenInput.value = stocktId;

                var InputPrice = editModal.querySelector('input[name="price"]');
                InputPrice.value = productPrice;

                var InputQuantity = editModal.querySelector('input[name="quantity"]');
                InputQuantity.value = productQuantity;


                products = typeof products === 'string' ? JSON.parse(products) : products;

                sizes = typeof sizes === 'string' ? JSON.parse(sizes) : sizes;

                var selectProduct = editModal.querySelector('select[name="product_id"]');
                selectProduct.innerHTML = '';  // Clear existing options

                products.forEach(function (product) {
                        var option1 = document.createElement('option');
                        option1.value = product.id;
                        option1.text = product.name;
                        if (product.id == productId) {
                            option1.selected = true;
                        }
                    selectProduct.appendChild(option1);
                    }
                )

                var selectSize = editModal.querySelector('select[name="size_id"]');
                selectSize.innerHTML = '';  // Clear existing options

                sizes.forEach(function (size) {
                        var option1 = document.createElement('option');
                        option1.value = size.id;
                        option1.text = size.size;
                        if (size.id == productSize) {
                            option1.selected = true;
                        }
                    selectSize.appendChild(option1);
                    }
                )
            });
        });
    </script>
@endsection
