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
        .delete-image {
            z-index: 10;
            padding: 5px;
            font-size: 12px;
            line-height: 1;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            text-align: center;
        }
    </style>
@endsection
@section('content')
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

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Gallery</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gallery</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div>
                        <h6 class="main-content-label mb-1">{{$product->name}} Gallery</h6><br>
                    </div>
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <ul id="lightgallery" class="list-unstyled row mb-0">
                        @foreach($gallery as $image)
                            <li class="col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3 position-relative" style="overflow: hidden;">
                                <!-- زر الحذف -->
                                <button class="delete-image btn btn-danger btn-sm"
                                        style="position: absolute; top: 5px; right: 5px; z-index: 10;"
                                        data-id="{{ $image->id }}">
                                    &times;
                                </button>
                                <!-- الصورة -->
                                <a href="" class="wd-100p d-block" style="text-align: center;">
                                    <img class="img-responsive" src="{{ $image->image_path }}"
                                         alt="Image"
                                         style="max-width: 100%; max-height: 150px; object-fit: cover; display: inline-block;">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <form method="post" action="{{route('addGallery.add')}}" enctype="multipart/form-data"
          class="p-4 bg-light rounded shadow-sm">
        @csrf
        <div class="form-group">
            <div class="form-group  select2-lg">
                <input type="hidden" value="{{$product->id}}" name="product_id">
                <label for="images" class="mg-b-10">Add More Images</label>
                <input type="file" class="form-control" name="images[]" id="images" multiple>
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn ripple btn-primary" type="submit">Add</button>
        </div>
    </form>
    <!-- End Row -->
@endsection

@section('script')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('#lightgallery a').forEach(function (link) {
                link.addEventListener('click', function (e) {
                    e.preventDefault(); // تعطيل السلوك الافتراضي
                });
            });

            document.querySelectorAll('.delete-image').forEach(function (button) {
                button.addEventListener('click', function () {
                    const imageId = this.getAttribute('data-id');
                    const liElement = this.closest('li');
                    let url = "{{ route('delete.image', ':id') }}"; // رابط Laravel
                    url = url.replace(':id', imageId); // استبدال :id بمعرف الصورة

                    // تأكيد الحذف باستخدام SweetAlert
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // تنفيذ الحذف باستخدام AJAX
                            fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Deleted!', data.message, 'success');
                                        liElement.remove();
                                    } else {
                                        Swal.fire('Error!', 'Something went wrong.', 'error');
                                    }
                                });
                        }
                    });
                });

            });
        });
    </script>
@endsection
