@extends('dashboard.layouts.app')
@section('content')

{{--    @error('code')--}}
{{--    <div class="alert alert-danger mg-b-0" role="alert">--}}
{{--        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">--}}
{{--            <span aria-hidden="true">&times;</span>--}}
{{--        </button>--}}
{{--        <strong>!Error </strong> Code Must Be Unique--}}
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
                        <h6 class="main-content-label mb-1">Sizes</h6>
                        {{--                        <button class="btn ripple btn-main-primary float-end mb-2">Primary</button>--}}
                        <a class="btn ripple btn-primary float-end mb-2" data-bs-target="#addPage"
                           data-bs-toggle="modal" href="">Add New Size</a>
                    </div>

                    <div class="table-responsive border">
                        <table class="table text-nowrap text-md-nowrap mg-b-0">
                            <thead>
                            <tr>
{{--                                <th>#</th>--}}
                                <th>Size</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($sizes as $size)
                                <tr>
{{--                                    <th scope="row">{{$avatar->id}}</th>--}}
                                    <td>{{$size->size}}</td>
                                    <td class="d-flex">
                                        <a class="btn btn-success btn-with-icon me-2" data-bs-target="#editPage"
                                           data-bs-toggle="modal" data-id="{{$size->id}}" data-name="{{$size->size}}"
                                           href=""><i class="fe fe-edit"></i>Edit</a>

                                        <a class="btn btn-danger btn-with-icon me-2" data-bs-target="#deletePage"
                                           data-bs-toggle="modal" data-id="{{$size->id}}" data-name="{{$size->size}}"
                                           href=""><i class="fe fe-delete"></i>Delete</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {{ $sizes->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="addPage" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add New Size</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('size.add')}}" class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="mg-b-10">Size</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Size Name" required>
                        <br>
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
                    <h6 class="modal-title">Edit Size</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('size.update')}}" class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="mg-b-10">Size</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Size" required>
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
                    <h6 class="modal-title">Delete Size</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <form method="post" action="{{route('size.delete')}}" class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group">
                        <p class="mg-b-10">Warning!! You are going to delete the Size <span  class="page-name"></span></p>
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
                if(Input) {
                    Input.innerHTML = `( `+pageName+` )`;
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
                var categoryId = button.getAttribute('data-id');
                var categoryName = button.getAttribute('data-name');


                // Update the hidden input field inside the modal with the country ID
                var hiddenInput = editModal.querySelector('input[name="id"]');
                hiddenInput.value = categoryId;

                // Update the span or any element that will show the country name
                var Input = editModal.querySelector('input[name="name"]');
                    Input.value = categoryName;

            });
        });
    </script>
@endsection
