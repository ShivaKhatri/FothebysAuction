@extends('backend.layout')

@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <span class="breadcrumb-item active">Classification</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Classification') }}</div>

                    <div class="card-body">
                        {!! $dataTable->table(['class' => 'table table-striped ']) !!}
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <!-- from dataTables push-->
    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
    <script src="{{asset('vendor/datatables/buttons.server-side.js')}}"></script>
    {!! $dataTable->scripts() !!}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', '#delete', function(e) {
            e.preventDefault(); // does not go through with the link.

            var $this = $(this);

            $.post({
                type: "DELETE",
                url: $this.attr('href')
            }).done(function (data) {
                window.location.replace('/classification');
            });
        });
    </script>
@endsection
