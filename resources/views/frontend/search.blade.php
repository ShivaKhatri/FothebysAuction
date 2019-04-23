
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Scripts -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Fothebys Auction</title>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    {{--<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">--}}

    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">


</head>


<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
            <div class="sidebar-brand-icon rotate-n-5">
                <img src="{{asset('images/logo.jpg')}}" class="nav-icon" style="width: 100px; height:50px">
            </div>
            <div class="sidebar-brand-text mx-3">Fothebys Auction</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{route('welcome')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

    {!! Form::open(array('route'=>'search.advance', 'class' =>"form-horizontal form-label-left", 'method' => 'post', 'id'=>'sectionForm', 'enctype' => "multipart/form-data")) !!}
    <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Artist
        </div>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <div class="form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" ><span class="badge badge-success">Search</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    {{ Form::text('search',null, array('class' => 'form-control')) }}
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Item name
        </div>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <div class="form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" ><span class="badge badge-success">Item Name</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    {{ Form::text('itemName',null, array('class' => 'form-control ')) }}
                </div>
            </div>
        </li> <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Artist
        </div>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <div class="form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" ><span class="badge badge-success">Artist Name</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    {{ Form::text('artistName',null, array('class' => 'form-control')) }}
                </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Category
        </div>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            @php
                $category=\App\Model\Category::all()->pluck('name','id');
            @endphp
            <div class="form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" ><span class="badge badge-success">Category</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    {{ Form::select('category',$category,null, array('class' => 'form-control','placeholder'=>'Select Category')) }}
                </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Price
        </div>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <div class="form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" ><span class="badge badge-success">Minimum</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    {{ Form::text('from',null, array('class' => 'form-control')) }}
                </div>
            </div>
        </li>
        <li class="nav-item">
            <div class="form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" ><span class="badge badge-success">Maximum</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    {{ Form::text('to',null, array('class' => 'form-control ')) }}
                </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Auction Date
        </div>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <div class="form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" ><span class="badge badge-success">Auction Date</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    {{ Form::date('auction_date',null, array('class' => 'form-control')) }}
                </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Subject Classification
        </div>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            @php
                $category=\App\Model\Classification::all()->pluck('name','id');
            @endphp
            <div class="form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" ><span class="badge badge-success">Classification</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    {{ Form::select('classification',$category,null, array('class' => 'form-control','placeholder'=>'Select Classification')) }}
                </div>
            </div>
        </li>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <button type="submit" form="sectionForm" class="btn btn-success">Apply Filter</button>
        </li>
        {!! Form::close() !!}
    </ul>

    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid ">

                <nav class="breadcrumb" style="margin-top:30px;">
                    <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
                    <span class="breadcrumb-item active">Search Items</span>
                </nav>
                <div class="container">
                    <div class="row justify-content-center">
                        @foreach($item as $ivalue)
                            <div class="col-md-4" style="margin-bottom: 15px">
                                <div class="card card-primary">
                                    <div class="card-header with-border">
                                        <h3 class="card-title">Add New Slider Image</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-title">Piece Title: {{$ivalue->Piece_Title}}</div>
                                        <div class="card-title">Lot Reference Number: {{$ivalue->lotReferenceNumber}}</div>
                                        <div class="card-title">Artist(s): {{$ivalue->artists}}</div>
                                        @php
                                            $from='';   $to='';
                                                               if($ivalue->from<0){
                                                               $from=($ivalue->from*-1).'BC';
                                                               }
                                                               else{
                                                               $from=$ivalue->from.'AD';

                                                               }
                                                               if($ivalue->to<0){
                                                                        $to=($ivalue->to*-1).'BC';

                                                               }
                                                               else
                                                               {
                                                               $to=$ivalue->to.'AD';
                                                               }
                                               if(!($ivalue->to==null)){
                                                  echo '<div class="card-title">Period: '.$from.' to '.$to.'</div>';
                                               }
                                           else{
                                             echo '<div class="card-title">Produced Year: '.$from.'</div>';

                                           }
                                           $category=\App\Model\Item::find($ivalue->id)->category()->first();
                                            $classification=\App\Model\Item::find($ivalue->id)->classification()->first();

                                        @endphp
                                        <div class="card-title">Reserve Price: {{$ivalue->reservePrice}}</div>
                                        <div class="card-title">Category: {{$category->name}}</div>
                                        <div class="card-title">Provenance Details: <a href="{{asset('/images/item/'.$ivalue->provenance_details)}}">Link for the Image</a></div>
                                        <div class="card-title">Classification: {{$classification->name}}</div>
                                        <img src="{{$ivalue->frontImage}}" class="card-img-bottom">

                                    </div>
                                    <div class="card-footer">
                                        <a href="{{route('item.frontShow',$ivalue->id)}}" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> More Details</a>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{--</div>--}}

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Fothebys Website 2019</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>



<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
{{--<script src="js/app.js"></script>--}}

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>
