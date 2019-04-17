@extends('backend.layout')

@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('users.index')}}">Users</a>
        <span class="breadcrumb-item active"> Edit Users</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update User Details') }}</div>

                    <div class="card-body">
                        {!! Form::model($user, [
      'route' => ['users.update', $user->id],
      'class' =>"form-horizontal form-label-left",
      'method' => 'PUT',
      'id' => 'userForm',
      'enctype' => "multipart/form-data",
  ])
  !!}
                        @csrf

                        <div   class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                {{ Form::select('title',['Mr'=>'Mr','Mrs'=>'Mrs','Miss'=>'Miss','Ms'=>'Ms','Mx'=>'Mx','Master'=>'Master'],$user->title,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Title']) }}
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="FirstName" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="FirstName" type="text" class="form-control{{ $errors->has('FirstName') ? ' is-invalid' : '' }}" name="FirstName" value="{{$user->FirstName}}" required autofocus>

                                @if ($errors->has('FirstName'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('FirstName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">

                            <label for="Surname" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                            <div class="col-md-6">
                                <input id="Surname" type="text" class="form-control{{ $errors->has('Surname') ? ' is-invalid' : '' }}" name="Surname" value="{{ $user->Surname}}" required autofocus>

                                @if ($errors->has('Surname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('Surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">

                            <label for="PhoneNo" class="col-md-4 col-form-label text-md-right">{{ __('PhoneNo') }}</label>

                            <div class="col-md-6">
                                <input name="PhoneNo"
                                       class="form-control{{ $errors->has('PhoneNo') ? ' is-invalid' : '' }}"
                                       oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                       type = "number"
                                       maxlength = "11"
                                       value="{{  $user->phone_no }}"
                                       required autofocus
                                />
                                @if ($errors->has('PhoneNo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('PhoneNo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div   class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ $user->address}}" required autofocus>

                                @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('User Type') }}</label>

                            <div class="col-md-6">
                                {{ Form::select('type',['Admin'=>'Administrator','Buyer'=>'Buyer','Seller'=>'Seller','Both'=>'Both'],$user->Cstatus,['class'=>'form-control','id'=>'type','required'=>'','placeholder'=>'Select User Type']) }}
                                @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div id="BankNo">
                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Verification Status') }}</label>
                                <div class="col-md-6">
                                    {{ Form::select('Astatus',['review'=>'In Review','verified'=>'Verified','UnVerified'=>'Un Verified'], $user->Astatus,['class'=>'form-control','id'=>'Astatus','required'=>'', 'placeholder'=>'Select Verification Status']) }}
                                    @if ($errors->has('Astatus'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('Astatus') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div  class="form-group row">

                                <label for="BankNo" class="col-md-4 col-form-label text-md-right">{{ __('BankNo') }}</label>

                                <div class="col-md-6">
                                    <input name="BankNo"
                                           class="form-control{{ $errors->has('BankNo') ? ' is-invalid' : '' }}"
                                           oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                           type = "number"
                                           maxlength = "8"
                                           value="{{ $user->bank_no }}"
                                           required autofocus
                                    />
                                    @if ($errors->has('BankNo'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('BankNo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{--{{dd($user->bank_sort_no)}}--}}
                        @php
                            $number=0;
                            if(!($user->bank_sort_no==null)){
                                $number=str_split($user->bank_sort_no,2);
                            }
                        @endphp
                        <div id="BankSortNo" class="form-group row">

                            <label for="BankSortNo" class="col-md-4 col-sm-4 col-xs-12 col-form-label text-md-right">{{ __('BankSortNo') }}</label>

                            <div class="col-md-7 col-sm-7 col-xs-12 row">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input name="BankSortNo1"
                                       class=" col-md-3 col-sm-3 col-lg-3 form-control{{ $errors->has('BankSortNo1') ? ' is-invalid' : '' }}"
                                       oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                       type = "number"
                                       maxlength = "2"
                                       value="{{ $number[0] }}"
                                       required autofocus
                                />
                                @if ($errors->has('BankSortNo1'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('BankSortNo1') }}</strong>
                                    </span>
                                @endif
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input name="BankSortNo2"
                                       class="form-control{{ $errors->has('BankSortNo2') ? ' is-invalid' : '' }} col-md-3 col-sm-3 col-lg-3"
                                       oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                       type = "number"
                                       maxlength = "2"
                                       value="{{$number[1] }}"
                                       required autofocus
                                />
                                @if ($errors->has('BankSortNo2'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('BankSortNo2') }}</strong>
                                    </span>
                                @endif
                                &nbsp;&nbsp;&nbsp;
                                <input name="BankSortNo3"
                                       class="form-control{{ $errors->has('BankNo') ? ' is-invalid' : '' }} col-md-3 col-sm-3 col-lg-3"
                                       oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                       type = "number"
                                       maxlength = "2"
                                       value="{{ $number[2] }}"
                                       required autofocus
                                />
                                {{--<input  type="text" pattern="\d*" class="form-control{{ $errors->has('BankSortNo') ? ' is-invalid' : '' }} col-md-3 col-sm-3 col-lg-3" name="BankSortNo" value="{{ old('BankSortNo') }}" maxlength="2" required autofocus>--}}

                                @if ($errors->has('BankSortNo3'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('BankSortNo3') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{  $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $("#BankNo").hide();
            $("#BankSortNo").hide();
            if ($('#type').val()=='Buyer'||$('#type').val()=='Seller'||$('#type').val()=='Both') {
                $("#BankNo").show();
                $("#BankSortNo").show();
                $("#BankNo :input").prop('required',true).attr('disabled',false);//to add required property of shown divs
                $("#BankSortNo :input").prop('required',true).attr('disabled',false);//to add required property of shown divs

            }
            $("#type").change(function () {
// console.log($('#type').val()); to check the selected value from the box
                if ($('#type').val()=='Buyer'||$('#type').val()=='Seller'||$('#type').val()=='Both') {
                    $("#BankNo").show();
                    $("#BankSortNo").show();
                    $("#BankNo :input").prop('required',true).attr('disabled',false);//to add required property of shown divs
                    $("#BankSortNo :input").prop('required',true).attr('disabled',false);//to add required property of shown divs

                } else {
                    $("#BankNo").hide();
                    $("#BankNo :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs

                    $("#BankSortNo").hide();
                    $("#BankSortNo :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs

                }
            });

        });
    </script>
@endsection