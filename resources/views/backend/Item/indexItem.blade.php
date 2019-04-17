@extends('backend.layout')
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
            @if(Auth::user()->Cstatus=="Admin")
                Items Detail
                @elseif(Auth::user()->Cstatus=="Buyer")
                Bought Items
                @elseif(Auth::user()->Cstatus=="Seller")
                Sold Items
            @endif
        </div>
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-striped ']) !!}
            @if(Auth::user()->Cstatus=="Admin")
            <br><br>
            <p class="card-title">Items Links</p>
            <a href="{{route('item.inReview')}}" class="btn btn-sm btn-primary" style="margin:3px">
                <i class="glyphicon glyphicon-edit"></i> Items in review</a>&nbsp;&nbsp;
            <a href="{{route('item.verified')}}" class="btn btn-sm btn-success" style="margin:3px">
                <i class="glyphicon glyphicon-edit"></i> Verified Items</a>&nbsp;&nbsp;
            <a href="{{route('item.unVerified')}}" class="btn btn-sm btn-danger" style="margin:3px">
                <i class="glyphicon glyphicon-edit"></i> Unverified Items</a>
@endif
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