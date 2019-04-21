
@extends('backend.'.$layout)
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('item.index')}}">Item</a>
        <span class="breadcrumb-item active"> Update Item Details</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update Item Details') }}</div>

                    <div class="card-body">
                        {!! Form::model($item, [
      'route' => ['item.update', $item->id],
      'class' =>"form-horizontal form-label-left",
      'method' => 'PUT',
      'id' => 'userForm',
      'enctype' => "multipart/form-data",
  ])
  !!}
                        @csrf

                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Category') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('category',$category,$item->category_id,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Category']) }}
                            </div>
                        </div>
                        @if(!($Subcategory->isEmpty()))
                            <div   class="form-group ">
                                <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Sub Category') }}</label>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{ Form::select('Subcategory',$Subcategory,$item->subCategory_id,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Sub-Category']) }}
                                </div>
                            </div>
                        @else
                            {{ Form::hidden('Subcategory', 'null') }}
                        @endif
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Piece Title<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('Piece_Title',$item->Piece_Title, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Artist(s)<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('artists',$item->artists, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
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
                                {{ Form::selectYear('from',date('Y')-6260, date('Y'),$item->from, array('class' => 'form-control col-md-7 col-xs-12','required'=>'','aria-describedby'=>"dateHelp" )) }}
                                <input name="to" type="hidden" value="null">
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12 row " id="period">
                                {{ Form::selectYear('from',date('Y')-6260, date('Y'),$item->from, array('class' => 'form-control col-md-5 col-xs-12','required'=>'','style'=>"margin-right:15px" )) }}
                                {{ Form::selectYear('to',date('Y')-6260, date('Y'),$item->to, array('class' => 'form-control col-md-5 col-xs-12','required'=>'')) }}
                            </div>
                            <small id="dateHelp" class="form-text text-muted">Positive years represent AD where as negative years represent BC</small>

                        </div>


                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Classification') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('classification',$classification,$item->classification_id,['class'=>'form-control','id'=>'classification','required'=>'', 'placeholder'=>'Select Classification']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Agreed Reserve Price<span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12 row">
                                {{ Form::number('reservePrice',$item->reservePrice, array('class' => 'form-control col-md-5 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Provenance Details<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input multiple="multiple" name="provenance" type="file">
                            </div>
                        </div>
                        <div   id="additionalDetail">

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Lot Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                    <textarea class="textarea form-control" placeholder="Place some text here" name="description">{{$item->description}}</textarea>

                            </div>
                        </div>
                        <div class="form-group required">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >I accept the customer agreement
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12 row">
                                <input type="radio" name="customer_agreement" id="yes" value="yes"  required/>
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Yes
                                </label>

                                <input type="radio" name="customer_agreement" id="no" value="no"  checked/>
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
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="category"]').on('change', function() {
                var categoryId = $(this).val();
                console.log(categoryId);
                if(categoryId) {
                    $.ajax({
                        url: 'ajax/'+categoryId,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {


                            $('#additionalDetail').html(data);
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

            var categoryId = $("input[name='customer_agreement']:checked").val();
            console.log(categoryId);
            if (categoryId=== "yes"){
                $('#userForm').submit()
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

