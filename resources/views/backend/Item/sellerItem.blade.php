@extends('backend.sellerLayout')
@section('headCss')
    {{--<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <span class="breadcrumb-item active">  Item</span>
    </nav>
    <div class="card">
        <div class="card-header">
                Sold Items Detail
        </div>
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-striped ']) !!}
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <!-- from dataTables push-->
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
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
console.log($this);
            $.post({
                type: "DELETE",
                url: $this.attr('href')
            }).done(function (data) {
                window.location.replace('/item/sold');
            });
        });
    </script>
@endsection