@extends('backend.buyerLayout')
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <span class="breadcrumb-item active">  Item</span>
    </nav>
    <div class="card">
        <div class="card-header">
            Commission Bids
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

            $.post({
                type: "DELETE",
                url: $this.attr('href')
            }).done(function (data) {
                window.location.replace('/items');
            });
        });
    </script>
@endsection