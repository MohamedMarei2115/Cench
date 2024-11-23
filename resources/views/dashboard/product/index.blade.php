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
                        <h6 class="main-content-label mb-1">Products</h6>
                        {{--                        <button class="btn ripple btn-main-primary float-end mb-2">Primary</button>--}}
                        <a class="btn ripple btn-primary float-end mb-2" data-bs-target="#addPage"
                           data-bs-toggle="modal" href="">Add New Product</a>
                    </div>

                    <div class="table-responsive border">
                        <table class="table text-nowrap text-md-nowrap mg-b-0">
                            <thead>
                            <tr>
                                {{--                                <th>#</th>--}}
                                <th>imag</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>price</th>
                                <th>size</th>
                                <th>details</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($products as $product)
                                <tr>
                                    {{--                                    <th scope="row">{{$avatar->id}}</th>--}}
                                    <td>
                                        <img src="{{$product->imag}}" height="100px" width="100px">
                                    </td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>{{$product->size}}</td>
                                    <td>{{$product->details}}</td>
                                    <td>
                                        @if($product->status == 1)
                                            <span style="color: green"> Active</span>
                                        @else
                                            <span style="color: red">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="d-flex ht-150 justify-center">
                                        <a class="btn btn-success btn-with-icon me-2" data-bs-target="#editPage"
                                           data-bs-toggle="modal" data-id="{{$product->id}}"
                                           data-name="{{$product->name}}"
                                           data-status="{{$product->status}}"
                                           data-category_id="{{$product->category_id}}"
                                           data-price="{{$product->price}}"
                                           data-details="{{$product->details}}"
                                           data-categories="{{$categories}}"
                                           data-size="{{$product->size}}"
                                           href=""><i class="fe fe-edit"></i>Edit</a>

                                        <a class="btn btn-danger btn-with-icon me-2"  data-bs-target="#deletePage"
                                           data-bs-toggle="modal" data-id="{{$product->id}}"
                                           data-name="{{$product->name}}"
                                           href=""><i class="fe fe-delete"></i>Delete</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="addPage" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add New Product</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('product.add')}}" enctype="multipart/form-data"
                      class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="mg-b-10">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                        <br>
                        <label for="event" class="mg-b-10">Category</label>
                        <div class="form-group  select2-lg">
                            <select id="event" name="category_id" required
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                                @foreach($categories as $category)
                                    <option
                                        value="{{$category->id}}">{{$category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="price" class="mg-b-10">Price</label>
                        <div class="form-group  select2-lg">
                            <input type="number" min="1" step=".5" class="form-control" id="price" name="price"
                                   placeholder="Price" required>
                        </div>
                        <label for="link" class="mg-b-10">Imag</label>
                        <input type="file" class="form-control" id="link" name="imag" placeholder="" required>
                        <br>
                        <label for="size" class="mg-b-10">Size</label>
                        <div class="form-group  select2-lg">
                            <select id="size" name="size" required
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                            </select>
                        </div>
                        <br>

                        <label for="detail" class="mg-b-10">Detail</label>
                        <div class="form-group  select2-lg">
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="detail">
                        </div>
                        <label for="status">Status</label><br>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="status" name="status" checked>
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
                <form method="post" action="{{route('product.update')}}" enctype="multipart/form-data"
                      class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="mg-b-10">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                        <br>

                        <label for="event" class="mg-b-10">Category</label>
                        <div class="form-group  select2-lg">
                            <select id="event" name="category_id" required
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                            </select>
                        </div>
                        <label for="price" class="mg-b-10">Price</label>
                        <input type="number" step=".5" min="1" class="form-control" id="price" name="price"
                               required>
                        <br>
                        <label for="imag" class="mg-b-10">Imag</label>
                        <input type="file" class="form-control" id="imag" name="imag" placeholder="">
                        <br>
                        <label for="size" class="mg-b-10">Size</label>
                        <div class="form-group  select2-lg">
                            <select id="size" name="size" required
                                    class="form-control select-lg select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true">
                            </select>
                        </div>
                        <br>
                        <label for="details" class="mg-b-10">Detail</label>
                        <div class="form-group  select2-lg">
                            <input type="text" class="form-control" id="details" name="details" placeholder="details">
                        </div>
                        <label for="status">status</label><br>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="status" name="status">
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
                    <h6 class="modal-title">Delete Avatar</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('product.delete')}}" class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">Warning!! You are going to delete the media named<span
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
        function setDuration($type, $s) {

            if ($s === 'create') {
                if ($type === 'image' || $type === 'gif') {
                    document.getElementById('duration_creat').value = 5;
                } else {
                    document.getElementById('duration_creat').value = 10;
                }
            } else {
                if ($type === 'image' || $type === 'gif') {
                    document.getElementById('duration_edit').value = 5;
                } else {
                    document.getElementById('duration_edit').value = 10;
                }
            }

        }


        function showPopup(media) {
            var popup = document.getElementById('popup');
            var content = document.getElementById('popup-content');

            popup.classList.add('active');
            content.innerHTML = '';


            if (media.type === 'audio') {
                content.innerHTML = `<audio id="media-player" controls autoplay>
                                <source src="${media.link}" type="audio/mpeg">
                                Audio Not supported
                             </audio>`;
            } else if (media.type === 'video') {
                content.innerHTML = `<video id="media-player" controls autoplay width="400">
                                <source src="${media.link}" type="video/mp4">
                               video Not supported
                             </video>`;
            } else {
                content.innerHTML = `<img class="wd-400 ht-400" id="avatar" src="${media.link}">`;
            }


            var mediaPlayer = document.getElementById('media-player');
            if (mediaPlayer) {
                mediaPlayer.load();
            }
        }

        function hidePopup() {
            var popup = document.getElementById('popup');
            var content = document.getElementById('popup-content');


            var mediaPlayer = content.querySelector('#media-player');
            if (mediaPlayer) {
                mediaPlayer.pause();
                mediaPlayer.currentTime = 0;
            }

            popup.classList.remove('active');
        }


        window.onclick = function (event) {
            var popup = document.getElementById('popup');
            if (event.target == popup) {
                hidePopup();
            }
        }


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
                var productId = button.getAttribute('data-id');
                var productName = button.getAttribute('data-name');
                var productPrice = button.getAttribute('data-price');
                var productCategoryId = button.getAttribute('data-category_id');
                var productDetails = button.getAttribute('data-details');
                var productStatus = button.getAttribute('data-status');
                var productSize = button.getAttribute('data-size');
                var categories = button.getAttribute('data-categories');

                // Update the hidden input field inside the modal with the country ID
                var hiddenInput = editModal.querySelector('input[name="id"]');
                hiddenInput.value = productId;

                // Update the span or any element that will show the country name
                var InputName = editModal.querySelector('input[name="name"]');
                InputName.value = productName;


                var InputPrice = editModal.querySelector('input[name="price"]');
                InputPrice.value = productPrice;

                var InputDetail = editModal.querySelector('input[name="details"]');
                InputDetail.value = productDetails;

                // var InputImag = editModal.querySelector('img[name="avatar"]');
                // InputImag.src = avatarImag;

                var InputStatus = editModal.querySelector('input[name="status"]');
                InputStatus.checked = productStatus == 1;

                categories = typeof categories === 'string' ? JSON.parse(categories) : categories;

                var selectCategory = editModal.querySelector('select[name="category_id"]');
                selectCategory.innerHTML = '';  // Clear existing options

                categories.forEach(function (category) {
                        var option1 = document.createElement('option');
                        option1.value = category.id;
                        option1.text = category.name;
                        if (category.id == productCategoryId) {
                            option1.selected = true;
                        }
                        selectCategory.appendChild(option1);
                    }
                )

                // <option value="video">video</option>
                //     <option value="audio">audio</option>
                //     <option value="image">image</option>

                var selectSize = editModal.querySelector('select[name="size"]');
                selectSize.innerHTML = '';  // Clear existing options

                var option1 = document.createElement('option');
                option1.value = 'XS';
                option1.text = 'XS';
                if (productSize === 'XS') {
                    option1.selected = true;
                }
                selectSize.appendChild(option1);

                var option2 = document.createElement('option');
                option2.value = 'S';
                option2.text = 'S';
                if (productSize === 'S') {
                    option2.selected = true;
                }
                selectSize.appendChild(option2);

                var option3 = document.createElement('option');
                option3.value = 'M';
                option3.text = 'M';
                if (productSize === 'M') {
                    option3.selected = true;
                }
                selectSize.appendChild(option3);

                var option4 = document.createElement('option');
                option4.value = 'L';
                option4.text = 'L';
                if (productSize === 'L') {
                    option4.selected = true;
                }
                selectSize.appendChild(option4);
            });
        });
    </script>
@endsection
