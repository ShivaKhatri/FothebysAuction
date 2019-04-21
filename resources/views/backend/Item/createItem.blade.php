@extends('backend.'.$layout)
@section('content')

    {{--<div class="row">--}}
    <!-- general form elements -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('item.sold')}}">Item</a>
        <span class="breadcrumb-item active"> Sell Item</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Sell New Item</h3>
                    </div>
                    {!! Form::open(array('route'=>'item.store', 'class' =>"form-horizontal form-label-left", 'method' => 'post', 'id'=>'sectionForm', 'enctype' => "multipart/form-data")) !!}

                    <div class="card-body">
                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Category') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('category',$category,null,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Category']) }}
                            </div>
                        </div>
                        @if(!($Subcategory->isEmpty()))
                        <div   class="form-group ">
                            <label for="subCategory" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Sub Category') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="Subcategory" class="form-control"></select>
{{--                                {{ Form::select('Subcategory',$Subcategory,null,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Sub-Category']) }}--}}
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Piece Title<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('Piece_Title',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Artist(s)<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('artists',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div class="form-group required">

                            <input type="radio" name="tab" value="year" onclick="year();" />
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Produced Year
                            </label>

                            <input type="radio" name="tab" value="period" onclick="period();" />
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Period
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12" id="year">
                                {{ Form::selectYear('from',date('Y')-6260, date('Y'),date('Y'), array('class' => 'form-control col-md-7 col-xs-12','required'=>'','aria-describedby'=>"dateHelp" )) }}
                                <input name="to" type="hidden" value="null">
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12 row " id="period">
                                {{ Form::selectYear('from',date('Y')-6260, date('Y'),date('Y'), array('class' => 'form-control col-md-5 col-xs-12','required'=>'','style'=>"margin-right:15px" )) }}
                                {{ Form::selectYear('to',date('Y')-6260, date('Y'),date('Y'), array('class' => 'form-control col-md-5 col-xs-12','required'=>'')) }}
                            </div>
                            <small id="dateHelp" class="form-text text-muted">Positive years represent AD where as negative years represent BC</small>

                        </div>


                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Classification') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('classification',$classification,null,['class'=>'form-control','id'=>'classification','required'=>'', 'placeholder'=>'Select Classification']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Agreed Reserve Price<span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12 row">
                                {{ Form::number('reservePrice',null, array('class' => 'form-control col-md-5 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Provenance Details<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input multiple="multiple" name="provenance" type="file">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Front Side Image of Item<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  name="frontImage" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Back Side Image of Item<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  name="backImage" type="file">
                            </div>
                        </div>
                        <div   id="additionalDetail">

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Lot Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <form>
                                    <textarea class="textarea form-control" placeholder="Place some text here" name="description"></textarea>
                                </form>
                            </div>
                        </div>
                        <div class="form-group required">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >I accept the customer agreement
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12 row">
                                <input type="radio" name="agreement" id="yes" value="yes"  required/>
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Yes
                                </label>

                                <input type="radio" name="agreement" id="no" value="no"  checked/>
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >No
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit"  class="btn btn-primary" onclick="agreement();">Add</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--</div>--}}

@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="category"]').on('change', function() {
                var categoryId = $(this).val();

                console.log(categoryId);
                if (categoryId) {
                    $.ajax({
                        url: 'ajax/' + categoryId,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {


                            // $('select[name="subCategory"]').empty();


                                    $('#additionalDetail').html(data[0]);

                            console.log(data[1]);
                            $('select[name="Subcategory"]').empty();

                            $.each(data[1], function (key, value) {
                                        $('select[name="Subcategory"]').append('<option value="' + key + '">' + value + '</option>');


                                    });


                                }

                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#period").hide();
            $("#year").hide();

        })
        function year() {

            $("#period").hide();
            $("#period :input").prop('required', null).attr('disabled', true);//to remove required property of hidden divs

            $("#year").show();
            $("#year :input").prop('required', true).attr('disabled', false);//to add required property of shown divs
        }

        function period() {

            $("#year").hide();
            $("#year :input").prop('required', null).attr('disabled', true);//to remove required property of hidden divs

            $("#period").show();
            $("#period :input").prop('required', true).attr('disabled', false);//to add required property of shown divs
        }

    </script>
    <script type="text/javascript">
       function agreement() {

           var categoryId = $("input[name='agreement']:checked").val();
           console.log(categoryId);
           if (categoryId=== "yes"){
               $('#sectionForm').submit()
           } else {
               alert("You must agree to the terms and conditions of Fothebys to sell the item");

           }
       }
    </script>
    {{--<script>--}}
        {{--$('#submit').on('click', function() {--}}
            {{--if ($('#yes').attr('checked') === "checked") {--}}
                {{--$('#sectionForm').submit();--}}
            {{--} else {--}}
                {{--alert("You must agree to the terms and conditions of Fothebys to sell the item");--}}
            {{--}--}}
            {{--return false;--}}
        {{--});--}}
    {{--</script>--}}
@endsection

