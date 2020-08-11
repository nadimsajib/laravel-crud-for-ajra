@extends('customers.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12" style="text-align: center">
            <div>
                <h2>Laravel 7 CRUD using Bootstrap Modal</h2>
            </div>
            <br/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a href="javascript:void(0)" class="btn btn-success mb-2" id="new-customer" data-toggle="modal">New
                    Customer</a>
            </div>
        </div>
    </div>
    <br/>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p id="msg">{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th width="280px">Action</th>
        </tr>

        @foreach ($customers as $customer)
            <tr id="customer_id_{{ $customer->id }}">
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->address }}</td>
                <td>
                    <form action="{{ route('customers.destroy',$customer->id) }}" method="POST">
                        <a class="btn btn-info" id="show-customer" data-toggle="modal" data-id="{{ $customer->id }}">Show</a>
                        <a href="javascript:void(0)" class="btn btn-success" id="edit-customer" data-toggle="modal"
                           data-id="{{ $customer->id }}">Edit </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a id="delete-customer" data-id="{{ $customer->id }}"
                           class="btn btn-danger delete-user">Delete</a>
                    </form>
                </td>
                </form>
                </td>
            </tr>
        @endforeach

    </table>
    {!! $customers->links() !!}
    <!-- Add and Edit customer modal -->
    <div class="modal fade" id="crud-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="customerCrudModal"></h4>
                </div>
                <div class="modal-body">
                    <form name="custForm" id="custForm" action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="cust_id" id="cust_id">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                                           onchange="">
                                    <span class="error" id="nameError"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <select name="country_id" id="country" class="form-control" style="width:350px" >
                                        <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->id}}"> {{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error" id="countryError"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <select class="form-control" name="city_id" id="city">
                                        <option value="">Select City</option>
                                    </select>
                                    <span class="error" id="cityError"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                Skills
                                <span class="error" id="skillError"></span>
                                <div class="form-group" id="skill_div">
                                    <input type="checkbox" id="php" name="skill_1" value="php">
                                    <label for="php"> PHP </label><br>
                                    <input type="checkbox" id="c_plus" name="skill_2" value="c_plus">
                                    <label for="c_plus"> C++ </label><br>
                                    <input type="checkbox" id="c" name="skill_3" value="c">
                                    <label for="c"> C </label><br>
                                </div>
                                <input type="hidden" id="lang_skills" name="lang_skills" value="">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="date_of_birth" id="datepicker" placeholder="date of birth">
                                    <span class="error" id="date_of_birthError"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    Resume upload
                                    <input type="file" name="resume" id="file">
                                    <span class="error" id="fileError"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary">
                                    Submit
                                </button>
                                <a href="{{ route('customers.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Show customer modal -->
    <div class="modal fade" id="crud-modal-show" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="customerCrudModal-show"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-2 col-sm-2 col-md-2"></div>
                        <div class="col-xs-10 col-sm-10 col-md-10 ">
                            @if(isset($customer->name))

                                <table>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>{{$customer->name}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{$customer->email}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address:</strong></td>
                                        <td>{{$customer->address}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: right "><a
                                                    href="{{ route('customers.index') }}" class="btn btn-danger">OK</a>
                                        </td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
</script>