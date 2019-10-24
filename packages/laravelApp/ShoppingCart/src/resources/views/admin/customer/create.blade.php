@extends('welcome')
@section('title')
Add Customer - Frelii
@endsection

@section('content')
@include('../front/partials/sidenav')
<link href="{{ asset('css/admin/ingredient/ingredient.css') }}" rel="stylesheet" type="text/css"/>
<style>
.row {
  margin-right: 0% !important;
    margin-left: 0% !important;
    margin-top: 0% !important;
    margin-bottom: 0% !important;
}
.nav-tabs-dropdown {
  display: none;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

.nav-tabs-dropdown:before {
  content: "\e114";
  font-family: 'Glyphicons Halflings';
  position: absolute;
  right: 30px;
}

@media screen and (min-width: 769px) {
  #nav-tabs-wrapper {
    display: block!important;
  }
}
@media screen and (max-width: 768px) {
  .nav-tabs-dropdown {
    display: block;
  }
  #nav-tabs-wrapper {
    display: none;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    text-align: center;
  }
  .nav-tabs-horizontal {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
  }
  .nav-tabs-horizontal  > li {
    float: none;
  }
  .nav-tabs-horizontal  > li + li {
    margin-left: 2px;
  }
  .nav-tabs-horizontal > li,
  .nav-tabs-horizontal > li > a {
    background: transparent;
    width: 100%;
  }
  .nav-tabs-horizontal  > li > a {
    border-radius: 4px;
  }
  .nav-tabs-horizontal  > li.active > a,
  .nav-tabs-horizontal  > li.active > a:hover,
  .nav-tabs-horizontal  > li.active > a:focus {
    color: #ffffff;
    background-color: #428bca;
  }

}
.tab-header {
  margin-top: 2%;
}
.required {
  color: red !important;
}
.list-unstyled {
  color: red;
}
.disabled {
  pointer-events: none;
  cursor: default;
  text-decoration: none;
  color: black;
}
.validation-message {
  color: red !important;
}
</style>
<div class="ingredient-list-container-style">
  <div class="section">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-body">
            <h2 class="list-ingredient-heading-color">Add New Customer</h2>
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            @include('flash::message')
            <hr>
            <div class="">
              <form class="" method="POST" action="{{ route('customer.store') }}" id="customerForm" name="customerForm" enctype="multipart/form-data" data-toggle="validator">
                {{ csrf_field() }}
                <a href="#" class="nav-tabs-dropdown btn btn-block btn-primary">Tabs</a>
                <ul id="nav-tabs-wrapper" class="nav nav-tabs nav-tabs-horizontal">
                  <li class="active"><a href="#htab1" data-toggle="tab">Personal Info</a></li>
                  <li><a href="#htab2" id="personalInfoTab" class="disabled" data-toggle="tab">Address</a></li>
                  <li><a href="#htab3" data-toggle="tab" id="addressInfoTab" class="disabled">Password</a></li>
                  <!-- <li><a href="#htab4" data-toggle="tab" id="passwordInfoTab" class="disabled">Health Goal</a></li> -->
                </ul>
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade in active" id="htab1">
                    <h3 class="tab-header">Personal Info</h3>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="first_name">First Name <span class="required">*</span></label>
                        <input id="first_name" type="text" class="form-control m-input" name="first_name" value="{{ old('first_name') }}"  maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required onblur="validateFirstName()">
                        <div class="help-block with-errors" id="fistNameError">
                          @if ($errors->has('first_name'))
                          <span class="help-block">
                            <strong class="validation-message">{{ $errors->first('first_name') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 ">
                        <label for="last_name">Last Name <span class="required">*</span></label>
                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required onblur="validateLastName()">
                        <div class="help-block with-errors" id="lastNameError">
                          @if ($errors->has('last_name'))
                          <span class="help-block">
                            <strong class="validation-message">{{ $errors->first('last_name') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="company">Company Name</label>
                        <input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom">
                        <div class="help-block with-errors">
                          @if ($errors->has('company'))
                          <span class="help-block">
                            <strong class="validation-message">{{ $errors->first('company') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="email">E-Mail Address <span class="required">*</span></label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" pattern="^[A-Za-z0-9]+(\.[_A-Za-z0-9]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,15})$" maxlength="191" data-toggle="tooltip" title="Use upto 191 characters." data-placement="bottom" data-pattern-error="Please enter a valid email address." required onblur="validateEmail()">
                        <div id="emailExist"></div>
                        <div id="emailError" class="help-block with-errors">
                          @if ($errors->has('email'))
                          <span class="help-block">
                            <strong class="validation-message">{{ $errors->first('email') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <label for="country_code">Country Code <span class="required">*</span></label>
                        <div class="input-group">
                          <span class="input-group-addon">+</span>
                          <input id="country_code" type="text" pattern="[0-9]{1,4}"  maxlength="4" class="col-md-3 form-control" name="country_code" value="{{ old('country_code') }}" data-toggle="tooltip" title="Use upto 4 digits." data-placement="bottom" data-pattern-error="Country Code must be number." required onblur="validateCountryCode()">
                        </div>
                        <div id=countryCodeError class="help-block with-errors">
                          @if ($errors->has('country_code'))
                          <span class="help-block">
                            <strong class="validation-message">{{ $errors->first('country_code') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-8">
                        <label for="code">Phone <span class="required">*</span></label>
                        <input id="phone" type="text" pattern="[0-9]{4,14}" maxlength="14" class="col-md-7 form-control" name="phone" value="{{ old('phone') }}"  data-toggle="tooltip" title="Use upto 14 digits." data-placement="bottom" data-pattern-error="Phone must be number." required onblur="validatePhone()">
                        <div id="phoneError" class="help-block with-errors">
                          @if ($errors->has('phone'))
                          <span class="help-block">
                            <strong class="validation-message">{{ $errors->first('phone') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                    <div class="nav-tabs-wrapper-btn col-md-12">
                      <a href="#htab2" id="personalInfo" class="btn btn-info continue" type="button">
                        NEXT
                      </a>
                    </div>
                  </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="htab2">
                    <h3 class="tab-header">Address</h3>
                    <div class="">
                      <label for="address1">Street Address <span class="required">*</span></label>
                      <input id="address1" type="text" class="form-control" name="address1" placeholder="House number and street name" value="{{old('address1') }}"  maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required onblur="validateAddress1()">
                      <div id="address1Error" class="help-block with-errors">
                        @if ($errors->has('address1'))
                        <span class="help-block">
                          <strong class="validation-message">{{ $errors->first('address1') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>
                    <div class="">
                      <input id="address2" type="text" class="form-control" name="address2" placeholder="Apartment, suit, unit etc. (option)" value="{{ old('address2') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom">
                      <div id="address2Error" class="help-block with-errors">
                        @if ($errors->has('address2'))
                        <span class="help-block">
                          <strong class="validation-message">{{ $errors->first('address2') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>
                    <div class="">
                      <label for="town_city" >Town / City <span class="required">*</span></label>
                      <input id="town_city" type="text" class="form-control" name="town_city" value="{{ old('town_city') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required onblur="validateCity()">
                      <div id="cityError" class="help-block with-errors">
                        @if ($errors->has('town_city'))
                        <span class="help-block">
                          <strong class="validation-message">{{ $errors->first('town_city') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>
                    <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                      <label for="country" >Country <span class="required">*</span></label><br>
                      <select name="country" id="country" class="form-control form-control-md selectpicker" data-live-search="true" data-width="100%" required onblur="validateCountry()">
                        <option value="">select</option>
                        @if(isset($countries))
                        @foreach ($countries as $key =>$countrie)
                        <option name="selectedCountry" value="{{$key}}" @if(old('country') == $key) {{ 'selected' }} @endif >{{$countrie}}</option>
                        @endforeach
                        @endif
                      </select>
                      <div id="countryError" class="help-block with-errors">
                        @if ($errors->has('country'))
                        <span class="help-block">
                          <strong class="validation-message" >{{ $errors->first('country') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>
                    <div id="stateDropdown" class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                      <label for="state" > State <span class="required">*</span></label><br>
                      <select id="state" name="state" class="form-control form-control-md selectpicker" data-live-search="true" data-width="100%" required onblur="validateState()">
                      </select>
                      <div id="stateError" class="help-block with-errors">
                        @if ($errors->has('state'))
                        <span class="help-block">
                          <strong class="validation-message">{{ $errors->first('state') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>
                    <div class="">
                      <label for="zipcode" >Zip Code<span class="required">*</span></label>
                      <input id="zipcode" type="text" data-minlength="2" class="form-control" name="zipcode" value="{{ old('zipcode') }}" maxlength="10" data-toggle="tooltip" title="Use upto 10 characters." data-placement="bottom" data-minlength-error="Zip must be at least 2 characters long." required onblur="validateZip()">
                      <div id="zipError" class="help-block with-errors">
                        @if ($errors->has('zipcode'))
                        <span class="help-block">
                          <strong class="validation-message">{{ $errors->first('zipcode') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>
                    <div class="">
                      <a href="#htab1" class="btn btn-info back" type="button">
                        PREVIOUS
                      </a>
                      <a href="#htab3" id="addressInfo" class="btn btn-info" type="button">
                        NEXT
                      </a>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade in" id="htab3">
                    <h3 class="tab-header">Password</h3>
                    <div class="">
                      <label for="password">Password <span class="required">*</span></label>
                      <input id="new_password" name="new_password" type="password" class="form-control" data-minlength="8" maxlength="30" data-minlength-error="Your password must be at least 8 characters long."  data-toggle="tooltip" title="Use upto 30 characters." data-placement="bottom" required onblur="validatePassword()">
                      <div id="passwordError" class="help-block with-errors">
                        @if ($errors->has('password'))
                        <span class="help-block">
                          <strong class="validation-message">{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>
                    <div class="">
                      <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                      <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" data-match="#new_password" data-match-error="Confirm passsword must be same as new password." required onblur="validateConfirmPassword()">
                      <div id="confirmPasswordError" class="help-block with-errors">
                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                          <strong class="validation-message">{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>
                    <div class="nav-tabs-wrapper-btn">
                      <a href="#htab3" class="btn btn-info back" type="button">
                        PREVIOUS
                      </a>
                      <input type="hidden" value="{{encrypt(CUSTOMER_CREATE_PERMISSION)}}" name="permission">
                      <button id="btnSubmit" class="btn cancel-button-style-for-ingredient cancel-a-link-style-for-ingredient" type="submit">
                        CREATE
                      </button>
                      <!-- <a href="#htab4" id="passwordInfo" class="btn btn-info" type="button">
                        NEXT
                      </a> -->
                    </div>
                  </div>
                  <!-- <div role="tabpanel"  id="htab4" class="tab-pane fade">
                    <h3 class="tab-header">Health Goal</h3>
                    <div class="row">
                      <div class="col-md-6 ">
                        <div class="">
                          <label for="health_first_name">First Name<span class="required">*</span></label>
                          <input id="health_first_name" type="text" class="form-control" name="health_first_name" value="{{ old('health_first_name') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus onblur="validateHealthFirstName()">
                          <div id="healthFirstNameError" class="help-block with-errors">
                            @if ($errors->has('health_first_name'))
                            <span class="help-block">
                              <strong class="validation-message">{{ $errors->first('health_first_name') }}</strong>
                            </span>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 ">
                        <div class="">
                          <label for="health_email">Email Address<span class="required">*</span></label>
                          <input id="health_email" type="email" class="form-control" name="health_email" value="{{ old('health_email') }}" maxlength="191" data-toggle="tooltip" title="Use upto 191 characters." data-placement="bottom" required onblur="validateHealthEmail()">
                          <div id="healthEmailError" class="help-block with-errors">
                            @if ($errors->has('health_email'))
                            <span class="help-block">
                              <strong class="validation-message">{{ $errors->first('health_email') }}</strong>
                            </span>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="weight">Weight (LBS)</label>
                        <input id="weight" type="number" class="form-control" name="weight" value="{{ old('weight') }}">
                        <div class="help-block with-errors"></div>
                        @if ($errors->has('weight'))
                        <span class="help-block">
                          <strong class="validation-message">{{ $errors->first('weight') }}</strong>
                        </span>
                        @endif
                      </div>
                      <div class="col-md-6">
                        <div class="font-weight-bold"><label>Sex<span class="required">*</span></label></div>
                        <div class="col s12 m12 l4">
                          <input id="male" class="with-gap" type="radio" name="sex" value="M" required="true" onblur="validateGender()"/>
                          <label for="male">Male</label>
                          <input id="female" class="with-gap" type="radio" name="sex" value="F" onblur="validateGender()" />
                          <label for="female">Female</label>
                        </div>
                        <div id="genderError" class="help-block with-errors">
                          @if ($errors->has('sex'))
                          <span class="help-block">
                            <strong class="validation-message">{{ $errors->first('sex') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="row height-div-style">
                      <div class="col-md-3">
                        <div class="form-group{{ $errors->has('feet') ? ' has-error' : '' }}">
                          <label for="feet">Height (Feet)</label>
                          <input id="feet" type="number" class="form-control" name="feet" value="{{old('feet') }}">
                          <div class="help-block with-errors"></div>
                          @if ($errors->has('feet'))
                          <span class="help-block">
                            <strong class="validation-message">{{ $errors->first('feet') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="inches">Height (Inches)</label>
                          <input id="inches" type="number" class="form-control" name="inches" value="{{ old('inches') }}">
                          <div class="help-block with-errors"></div>
                          @if ($errors->has('inches'))
                          <span class="help-block">
                            <strong class="validation-message">{{ $errors->first('inches') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 age-respinsive-style">
                        <div class="form-group{{ $errors->has('age') ? ' has-error' : '' }}">
                          <label for="age">Age</label>
                          <input id="age" type="number" class="form-control" name="age" value="{{ old('age') }}">
                          <div class="help-block with-errors"></div>
                          @if ($errors->has('age'))
                          <span class="help-block">
                            <strong class="validation-message">{{ $errors->first('age') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="">
                        <div class="col-md-6">
                          <label for="how_active"> How active are you?<span class="required">*</span></label>
                          <select name="how_active" id="how_active" class="validate form-control form-control-md" required onblur="validatehowActive()">
                            <option value="" disabled="true" selected="selected">Choose your option</option>
                            <option value="NACT">No Active</option>
                            <option value="SEDT">Sedentary</option>
                            <option value="LACT">Lightly Active</option>
                            <option value="ACT">Active</option>
                            <option value="VACT">Very Active</option>
                          </select>
                          <div id="howActiveError" class="help-block with-errors">
                            @if ($errors->has('how_active'))
                            <span class="help-block">
                              <strong class="validation-message">{{ $errors->first('how_active') }}</strong>
                            </span>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="exclude_tag_id">What is your health goals?<span class="required">*</span></label>
                        <select name="exclude_tag_id" id="exclude_tag_id" class="form-control form-control-md" data-width="100%" onblur="validateHealthGoal()" required>
                          <option value="" disabled="true" selected="selected">Choose your option</option>
                          @foreach($excludeTag as $kay => $value)
                          <option value="{{$value->id}}" onblur="validateHealthGoal()"> {{$value->name}}</option>
                          @endforeach
                        </select>
                        <div id="healthGoalError" class="help-block with-errors">
                          @if ($errors->has('exclude_tag_id'))
                          <span class="help-block">
                            <strong class="validation-message">{{ $errors->first('exclude_tag_id') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="exclude_tag_id">Select a work out level ?<span class="required">*</span></label>
                        <div class="">
                          <div class="radio">
                            <label><input class="with-gap" id="beginner" type="radio" name="work_out_level" value="BEG" required onblur="validateWorkOutLevel()" />Beginner</label>
                          </div>
                          <div class="radio">
                            <label><input class="with-gap" id="intermediate" type="radio" name="work_out_level" value="INT" onblur="validateWorkOutLevel()" />Intermediate</label>
                          </div>
                          <div class="radio">
                            <label><input class="with-gap" id="advanced" type="radio" name="work_out_level" value="ADV"  onblur="validateWorkOutLevel()"/>Advanced</label>
                          </div>
                          <div id="workOutLevelError" class="help-block with-errors">
                            @if ($errors->has('work_out_level'))
                            <span class="help-block">
                              <strong class="validation-message">{{ $errors->first('work_out_level') }}</strong>
                            </span>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <br>
                    <div class="nav-tabs-wrapper-btn">
                      <a href="#htab3" class="btn btn-info back" type="button">
                        PREVIOUS
                      </a>
                      <button class="btn cancel-button-style-for-ingredient cancel-a-link-style-for-ingredient" type="submit">
                        CREATE
                      </button>
                    </div>
                  </div> -->
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>
</div>

@endsection
@push('scripts')
<script>
var personalInfoFlag = 0;

$('.nav-tabs-dropdown').each(function(i, elm) {
  $(elm).text($(elm).next('ul').find('li.active a').text());
});

$('.nav-tabs-dropdown').on('click', function(e) {
  e.preventDefault();
  $(e.target).toggleClass('open').next('ul').slideToggle();
});

$('#nav-tabs-wrapper a[data-toggle="tab"]').on('click', function(e) {
  $(e.target).closest('ul').hide().prev('a').removeClass('open').text($(this).text());
});
// $('#btnSubmit').on('click', function(e) {
// e.preventDefault();
// var form = document.getElementById('customerForm');
// var hiddenInputPermission = document.createElement('input');
//
// hiddenInputPermission.setAttribute('name', 'permission' );
// hiddenInputPermission.setAttribute("style", "visibility: hidden;");
// hiddenInputPermission.setAttribute('value', "{{encrypt(CUSTOMER_CREATE_PERMISSION)}}" );
//                form.appendChild(hiddenInputPermission);
//                form.submit();
// });
function validateTab1() {
  var emailReg = /^[A-Za-z0-9]+(\.[_A-Za-z0-9]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,15})$/;
  var codeReg =  /[0-9]{1,4}/;
  var numberReg =  /[0-9]{4,14}/;
  var firstName = document.customerForm.first_name.value;
  var lastName = document.customerForm.last_name.value;
  var email = document.customerForm.email.value;
  var phone = document.customerForm.phone.value;
  var countryCode = document.customerForm.country_code.value;

  if (firstName!=null && firstName!="" && lastName!=null && lastName!="" &&
  email!=null && email!="" && phone!=null && phone!="" && country_code!=null && country_code!="" && emailReg.test(email) && numberReg.test(phone) && codeReg.test(countryCode)){
    $("#personalInfoTab").removeClass("disabled");
    return true;
  } else {
    $("#personalInfoTab").addClass("disabled");
  }
}
$('.back').click(function(){
  $('.nav-tabs > .active').prev('li').find('a').trigger('click').attr("data-toggle", "tab");
});

/*validation for all fields start*/

function validateFirstName(){
  var firstName = document.customerForm.first_name.value;
  if (firstName==null || firstName==""){
    $("#fistNameError").html("");
    $("#personalInfoTab").addClass("disabled");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#fistNameError" ).append('<ul class="list-unstyled"><li>' + 'First Name field is required.'+'</li></ul>');
    return false;
  }
  else{
    $("#fistNameError").html("");
  }
}
function validateLastName(){
  var lastName = document.customerForm.last_name.value;
  if (lastName==null || lastName==""){
    $("#lastNameError").html("");
    $("#personalInfoTab").addClass("disabled");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#lastNameError" ).append('<ul class="list-unstyled"><li>' + 'Last Name field is required.'+'</li></ul>');
  }
  else{
    $("#lastNameError").html("");
  }
}
function validateEmail(){
  var emailReg = /^[A-Za-z0-9]+(\.[_A-Za-z0-9]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,15})$/;
  var email = document.customerForm.email.value;
  if (email==null || email==""){
    $("#emailError").html("");
    $("#personalInfoTab").addClass("disabled");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#emailError" ).append('<ul class="list-unstyled"><li>' + 'E-Mail Address field is required.'+'</li></ul>');
  } else if(!emailReg.test(email)){
    $("#emailError").html("");
    $("#personalInfoTab").addClass("disabled");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $('#emailError').append('<ul class="list-unstyled"><li>' + 'E-Mail Address must be valid.'+'</li></ul>');
  } else{
    $("#emailError").html("");
  }

}
function validatePhone(){
  var numberReg =  /^\d{4,14}$/;
  var phone = document.customerForm.phone.value;
  if (phone==null || phone==""){
    $("#phoneError").html("");
    $("#personalInfoTab").addClass("disabled");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#phoneError" ).append('<ul class="list-unstyled"><li>' + 'Phone field is required.'+'</li></ul>');
  } else if(!numberReg.test(phone)) {
    $("#phoneError").html("");
    $("#personalInfoTab").addClass("disabled");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#phoneError" ).append('<ul class="list-unstyled"><li>' + 'Phone must be valid.'+'</li></ul>');
  }
  else{
    $("#phoneError").html("");
  }
}
function validateCountryCode(){
  var codeReg =  /^\d{1,4}$/;
  var countryCode = document.customerForm.country_code.value;
  if (countryCode==null || countryCode==""){
    $("#countryCodeError").html("");
    $("#personalInfoTab").addClass("disabled");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#countryCodeError" ).append('<ul class="list-unstyled"><li>' + 'Country Code field is required.'+'</li></ul>');
  }else if(!codeReg.test(countryCode)) {
    $("#countryCodeError").html("");
    $("#personalInfoTab").addClass("disabled");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#countryCodeError" ).append('<ul class="list-unstyled"><li>' + 'Country Code must be valid.'+'</li></ul>');
  }
  else{
    $("#countryCodeError").html("");
  }
}
function validateAddress1(){
  var address1 = document.customerForm.address1.value;
  if (address1==null || address1==""){
    $("#address1Error").html("");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#address1Error" ).append('<ul class="list-unstyled"><li>' + 'Street Address field is required.'+'</li></ul>');
  }
  else{
    $("#address1Error").html("");
  }
}
function validateCity(){
  var city = document.customerForm.town_city.value;
  if (city==null || city==""){
    $("#cityError").html("");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#cityError" ).append('<ul class="list-unstyled"><li>' + 'City field is required.'+'</li></ul>');
  }
  else{
    $("#cityError").html("");
  }
}
function validateCountry(){
  var country = document.customerForm.country.value;
  if (country==null || country==""){
    $("#countryError").html("");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#countryError" ).append('<ul class="list-unstyled"><li>' + 'Country field is required.'+'</li></ul>');
  }
  else{
    $("#countryError").html("");
  }
}
function validateState(){
  var state = document.customerForm.state.value;
  if (state==null || state==""){
    $("#stateError").html("");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#stateError" ).append('<ul class="list-unstyled"><li>' + 'State field is required.'+'</li></ul>');
  }
  else{
    $("#stateError").html("");
  }
}
function validateZip(){
  var zipcode = document.customerForm.zipcode.value;
  var zipReg = /^\d{2,10}$/;
  if (zipcode==null || zipcode==""){
    $("#zipError").html("");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#zipError" ).append('<ul class="list-unstyled"><li>' + 'Zip Code field is required.'+'</li></ul>');
  } else if(!zipReg.test(zipcode)) {
    $("#zipError").html("");
    $("#addressInfoTab").addClass("disabled");
    $("#passwordInfoTab").addClass("disabled");
    $( "#zipError" ).append('<ul class="list-unstyled"><li>' + 'Zip Code must be valid.'+'</li></ul>');
  }
  else{
    $("#zipError").html("");
  }
}
function validatePassword(){
  var password = document.customerForm.new_password.value;
  if (password==null || password==""){
    $("#passwordError").html("");
    $("#passwordInfoTab").addClass("disabled");
    $( "#passwordError" ).append('<ul class="list-unstyled"><li>' + 'Password field is required.'+'</li></ul>');
  }
  else if(password.length < 8) {
    $("#passwordError").html("");
    $("#passwordInfoTab").addClass("disabled");
    $( "#passwordError" ).append('<ul class="list-unstyled"><li>' + 'Password must have at least 8 characters.'+'</li></ul>');
  }
  else{
    $("#passwordError").html("");
  }
}
function validateConfirmPassword(){
  var confirmPassword = document.customerForm.password_confirmation.value;
  var password = document.customerForm.new_password.value;
  if (confirmPassword==null || confirmPassword==""){
    $("#confirmPasswordError").html("");
    $("#passwordInfoTab").addClass("disabled");
    $( "#confirmPasswordError" ).append('<ul class="list-unstyled"><li>' + 'Confirm Password field is required.'+'</li></ul>');
  }
  else if(password.length < 8) {
    $("#confirmPasswordError").html("");
    $("#passwordInfoTab").addClass("disabled");
    $( "#confirmPasswordError" ).append('<ul class="list-unstyled"><li>' + 'Confirm Password must have at least 8 characters.'+'</li></ul>');
  }
  else if(password != confirmPassword) {
    $("#confirmPasswordError").html("");
    $("#passwordInfoTab").addClass("disabled");
    $( "#confirmPasswordError" ).append('<ul class="list-unstyled"><li>' + 'Confirm Password and Password must be same.'+'</li></ul>');
  }
  else{
    $("#confirmPasswordError").html("");
  }
}
// function validateHealthFirstName(){
//   var healthFirstName = document.customerForm.health_first_name.value;
//   if (healthFirstName==null || healthFirstName==""){
//     $("#healthFirstNameError").html("");
//     $( "#healthFirstNameError" ).append('<ul class="list-unstyled"><li>' + 'First Name field is required.'+'</li></ul>');
//   }
//   else{
//     $("#healthFirstNameError").html("");
//   }
// }
// function validateHealthEmail(){
//   var emailReg = /^[A-Za-z0-9]+(\.[_A-Za-z0-9]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,15})$/;
//   var healthEmail = document.customerForm.health_email.value;
//   if (healthEmail==null || healthEmail==""){
//     $("#healthEmailError").html("");
//     $( "#healthEmailError" ).append('<ul class="list-unstyled"><li>' + 'E-mail Address field is required.'+'</li></ul>');
//   } else if(!emailReg.test(healthEmail)) {
//     $("#healthEmailError").html("");
//     $('#healthEmailError').append('<ul class="list-unstyled"><li>' + 'E-mail Address must be valid.'+'</li></ul>');
//   }
//   else{
//     $("#healthEmailError").html("");
//   }
// }
// function validateGender(){
//   var gender = document.customerForm.sex.value;
//   if (gender==null || gender==""){
//     $("#genderError").html("");
//     $( "#genderError" ).append('<ul class="list-unstyled"><li>' + 'Sex field is required.'+'</li></ul>');
//   }
//   else{
//     $("#genderError").html("");
//   }
// }
// function validatehowActive() {
//   var howActive = document.customerForm.how_active.value;
//   if (howActive==null || howActive==""){
//     $("#howActiveError").html("");
//     $( "#howActiveError" ).append('<ul class="list-unstyled"><li>' + 'Active field is required.'+'</li></ul>');
//   }
//   else{
//     $("#howActiveError").html("");
//   }
// }
// function validateHealthGoal(){
//   var healthGoal = document.customerForm.exclude_tag_id.value;
//   // var healthGoal = document.getElementById("exclude_tag_id").value ;
//   if (healthGoal==null || healthGoal==""){
//     $("#healthGoalError").html("");
//     $( "#healthGoalError" ).append('<ul class="list-unstyled"><li>' + 'Health goal field is required.'+'</li></ul>');
//   }
//   else{
//     $("#healthGoalError").html("");
//   }
// }
// function validateWorkOutLevel(){
//   var workOutLevel = document.customerForm.work_out_level.value;
//   if (workOutLevel==null || workOutLevel==""){
//     $("#workOutLevelError").html("");
//     $( "#workOutLevelError" ).append('<ul class="list-unstyled"><li>' + 'Work out level field is required.'+'</li></ul>');
//   }
//   else{
//     $("#workOutLevelError").html("");
//   }
// }
$(document).ready(function(){
  $('#personalInfo').click(function(){
    validatePresonalInfoForm();
  });
  $('#addressInfo').click(function(){
    validateAddressInfoForm();
  });
  $('#passwordInfo').click(function(){
    validatePasswordInfoForm();
  });
  // $('#healthgoalInfo').click(function(){
  //   validateHealthGoalInfoForm();
  // });
  //tab 1 START
  function validatePresonalInfoForm(){
    var emailReg = /^[A-Za-z0-9]+(\.[_A-Za-z0-9]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,15})$/;
    var codeReg =  /^\d{1,4}$/;
    var numberReg = /^\d{4,14}$/;
    var firstName = document.customerForm.first_name.value;
    var lastName = document.customerForm.last_name.value;
    var email = document.customerForm.email.value;
    var phone = document.customerForm.phone.value;
    var countryCode = document.customerForm.country_code.value;

    if (firstName!=null && firstName!="" && lastName!=null && lastName!="" &&
    email!=null && email!="" && phone!=null && phone!="" && country_code!=null && country_code!="" && emailReg.test(email) && numberReg.test(phone) && codeReg.test(countryCode)){
      $('.nav-tabs > .active').next('li').find('a').trigger('click').attr("data-toggle", "tab");
      personalInfoFlag = 1;
      $("#personalInfoTab").removeClass("disabled");
      return true;
    }else{
      $("#personalInfoTab").addClass("disabled");
      $("#addressInfoTab").addClass("disabled");
      $("#passwordInfoTab").addClass("disabled");
      if (firstName==null || firstName==""){
        $("#fistNameError").html("");
        $( "#fistNameError" ).append('<ul class="list-unstyled"><li>' + 'First Name field is required.'+'</li></ul>');
      }
      else{
        $("#fistNameError").html("");
      }
      if (lastName==null || lastName==""){
        $("#lastNameError").html("");
        $( "#lastNameError" ).append('<ul class="list-unstyled"><li>' + 'Last Name field is required.'+'</li></ul>');
      }
      else{
        $("#lastNameError").html("");
      }
      if (email==null || email==""){
        $("#emailError").html("");
        $( "#emailError" ).append('<ul class="list-unstyled"><li>' + 'E-Mail Address field is required.'+'</li></ul>');
      } else if(!emailReg.test(email)){
        $("#emailError").html("");
        $('#emailError').append('<ul class="list-unstyled"><li>' + 'E-Mail Address must be valid.'+'</li></ul>');
      } else{
        $("#emailError").html("");
      }
      if (phone==null || phone==""){
        $("#phoneError").html("");
        $( "#phoneError" ).append('<ul class="list-unstyled"><li>' + 'Phone field is required.'+'</li></ul>');
      } else if(!numberReg.test(phone)) {
        $("#phoneError").html("");
        $( "#phoneError" ).append('<ul class="list-unstyled"><li>' + 'Phone must be valid.'+'</li></ul>');
      }
      else{
        $("#phoneError").html("");
      }
      if (countryCode==null || countryCode==""){
        $("#countryCodeError").html("");
        $( "#countryCodeError" ).append('<ul class="list-unstyled"><li>' + 'Country Code field is required.'+'</li></ul>');
      }else if(!codeReg.test(countryCode)) {
        $("#countryCodeError").html("");
        $( "#countryCodeError" ).append('<ul class="list-unstyled"><li>' + 'Country Code must be valid.'+'</li></ul>');
      }
      else{
        $("#countryCodeError").html("");
      }
    }
  }
  //Tab1 END

  //Tab2 Start
  function validateAddressInfoForm(){
    var address1 = document.customerForm.address1.value;
    var city = document.customerForm.town_city.value;
    var state = document.customerForm.state.value;
    var country = document.customerForm.country.value;
    var zipcode = document.customerForm.zipcode.value;
    var zipReg = /^\d{2,10}$/;
    if (address1!=null && address1!="" && city!=null && city!="" &&
    state!=null && state!="" && country!=null && country!="" && zipcode!=null && zipcode!="" && zipReg.test(zipcode) ){
      $('.nav-tabs > .active').next('li').find('a').trigger('click').attr("data-toggle", "tab");
      $("#addressInfoTab").removeClass("disabled");
      return true;
    }else{
      $("#addressInfoTab").addClass("disabled");
      $("#passwordInfoTab").addClass("disabled");
      if (address1==null || address1==""){
        $("#address1Error").html("");
        $( "#address1Error" ).append('<ul class="list-unstyled"><li>' + 'Street Address field is required.'+'</li></ul>');
      }
      else{
        $("#address1Error").html("");
      }
      if (city==null || city==""){
        $("#cityError").html("");
        $( "#cityError" ).append('<ul class="list-unstyled"><li>' + 'City field is required.'+'</li></ul>');
      }
      else{
        $("#cityError").html("");
      }
      if (country==null || country==""){
        $("#countryError").html("");
        $( "#countryError" ).append('<ul class="list-unstyled"><li>' + 'Country field is required.'+'</li></ul>');
      }
      else{
        $("#countryError").html("");
      }
      if (state==null || state==""){
        $("#stateError").html("");
        $( "#stateError" ).append('<ul class="list-unstyled"><li>' + 'State field is required.'+'</li></ul>');
      }
      else{
        $("#stateError").html("");
      }
      if (zipcode==null || zipcode==""){
        $("#zipError").html("");
        $( "#zipError" ).append('<ul class="list-unstyled"><li>' + 'Zip Code field is required.'+'</li></ul>');
      } else if(!zipReg.test(zipcode)) {
        $("#zipError").html("");
        $( "#zipError" ).append('<ul class="list-unstyled"><li>' + 'Zip Code must be valid.'+'</li></ul>');
      }
      else{
        $("#zipError").html("");
      }
    }
  }
  //Tab 2 END

  //Tab 3 START
  function validatePasswordInfoForm(){
    var password = document.customerForm.new_password.value;
    var confirmPassword = document.customerForm.password_confirmation.value;

    // var len = {min:4,max:30};
    if (password!=null && password!="" && confirmPassword!=null && confirmPassword!="" && password.length >= 8 && confirmPassword.length >= 8 && password == confirmPassword){
      $('.nav-tabs > .active').next('li').find('a').trigger('click').attr("data-toggle", "tab");
      $("#passwordInfoTab").removeClass("disabled");
      return true;
    }else{
      $("#passwordInfoTab").addClass("disabled");
      if (password==null || password==""){
        $("#passwordError").html("");
        $( "#passwordError" ).append('<ul class="list-unstyled"><li>' + 'Password field is required.'+'</li></ul>');
      }
      else if(password.length < 8) {
        $("#passwordError").html("");
        $( "#passwordError" ).append('<ul class="list-unstyled"><li>' + 'Password must have at least 8 characters.'+'</li></ul>');
      }
      else{
        $("#passwordError").html("");
      }
      if (confirmPassword==null || confirmPassword==""){
        $("#confirmPasswordError").html("");
        $( "#confirmPasswordError" ).append('<ul class="list-unstyled"><li>' + 'Confirm Password field is required.'+'</li></ul>');
      }
      else if(password.length < 8) {
        $("#confirmPasswordError").html("");
        $( "#confirmPasswordError" ).append('<ul class="list-unstyled"><li>' + 'Confirm Password must have at least 8 characters.'+'</li></ul>');
      }
      else if(password != confirmPassword) {
        $("#confirmPasswordError").html("");
        $( "#confirmPasswordError" ).append('<ul class="list-unstyled"><li>' + 'Confirm Password and password must be sane.'+'</li></ul>');
      }
      else{
        $("#confirmPasswordError").html("");
      }
    }
  }
  //Tab 3 END

  //Tab 4 START
  // function validateHealthGoalInfoForm() {
  //   var emailReg = /^[A-Za-z0-9]+(\.[_A-Za-z0-9]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,15})$/;
  //   var healthFirstName = document.customerForm.health_first_name.value;
  //   var healthEmail = document.customerForm.health_email.value;
  //   var howActive = document.customerForm.how_active.value;
  //   var gender = document.customerForm.sex.value;
  //   var healthGoal = document.customerForm.exclude_tag_id.value;
  //   var workOutLevel = document.customerForm.work_out_level.value;
  //   if (healthFirstName!=null && healthFirstName!="" && healthEmail!=null && healthEmail!="" &&
  //   howActive!=null && howActive!="" && gender!=null && gender!="" &&
  //   healthGoal!=null && healthGoal!="" && workOutLevel!=null && workOutLevel!=""){
  //     return true;
  //   }else{
  //     if (healthFirstName==null || healthFirstName==""){
  //       $("#healthFirstNameError").html("");
  //       $( "#healthFirstNameError" ).append('<ul class="list-unstyled"><li>' + 'First Name field is required.'+'</li></ul>');
  //     }
  //     else{
  //       $("#healthFirstNameError").html("");
  //     }
  //     if (healthEmail==null || healthEmail==""){
  //       $("#healthEmailError").html("");
  //       $( "#healthEmailError" ).append('<ul class="list-unstyled"><li>' + 'E-mail Address field is required.'+'</li></ul>');
  //     } else if(!emailReg.test(healthEmail)) {
  //       $("#healthEmailError").html("");
  //       $('#healthEmailError').append('<ul class="list-unstyled"><li>' + 'E-mail Address must be valid.'+'</li></ul>');
  //     }
  //     else{
  //       $("#healthEmailError").html("");
  //     }
  //     if (gender==null || gender==""){
  //       $("#genderError").html("");
  //       $( "#genderError" ).append('<ul class="list-unstyled"><li>' + 'Sex field is required.'+'</li></ul>');
  //     }
  //     else{
  //       $("#genderError").html("");
  //     }
  //     if (howActive==null || howActive==""){
  //       $("#howActiveError").html("");
  //       $( "#howActiveError" ).append('<ul class="list-unstyled"><li>' + 'Active field is required.'+'</li></ul>');
  //     }
  //     else{
  //       $("#howActiveError").html("");
  //     }
  //     if (healthGoal==null || healthGoal==""){
  //       $("#healthGoalError").html("");
  //       $( "#healthGoalError" ).append('<ul class="list-unstyled"><li>' + 'Health goal field is required.'+'</li></ul>');
  //     }
  //     else{
  //       $("#healthGoalError").html("");
  //     }
  //     if (workOutLevel==null || workOutLevel==""){
  //       $("#workOutLevelError").html("");
  //       $( "#workOutLevelError" ).append('<ul class="list-unstyled"><li>' + 'Work out level field is required.'+'</li></ul>');
  //     }
  //     else{
  //       $("#workOutLevelError").html("");
  //     }
  //   }
  // }
  //Tab 4 END
});


/*validation end*/
/*  dropdown state according to country */
$('select[name="country"]').on('change', function () {
  var countryID = $(this).val();
  var parm = {'country': countryID}
  var param = JSON.stringify(parm);
  if (countryID) {
    $.ajax({
      url: '/getState',
      type: 'GET',
      data: parm,
      success: function (data) {
        if ('State not found' == data) {
          $('select[name="state"]').empty();
          $('#state').append('<option value="N.A">N.A</option>');
          $("#countryError").html("");
          $("#stateError").html("");
          $('#state').selectpicker('refresh');
        }else {
          $('select[name="state"]').empty();
          var res = data.state;
          $.each(res, function (key, value) {
            $('#state').append('<option value="' + value + '">' + value + '</option>');
            $("#countryError").html("");
            $("#stateError").html("");
            $('#state').selectpicker('refresh');
          });
        }
      },
      error: function () {
        console.log("State not found");
      }
    });
  } else {
    $('select[name="state"]').empty();
  }
});

/* END*/
/*Email validation START*/

$('input[name="email"]').on('change', function () {
    var email = $('#email').val();
    console.log(email);
    var token = $('input[name="_token"]').val();
    var data = { _token: token, email: email};
  $.ajax({
    url: '/checkEmail',
    type: 'POST',
    data: data,
    success: function (response) {
      if(response.code === 200) {
        $('#emailExist').html('');
      }else if(response.code === 404){
        $('#emailExist').html('');
      } else {
        alert(response.msg);
        // $('#emailExist').append('<span style="color:red">'+response.msg+'</span>');
        $("#email").val('');
      }
    },
    error: function () {

    }
  });
});

/*Email validation end*/
</script>
@endpush
