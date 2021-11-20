<x-app-layout>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content mt-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">


                        <div class="card">
                            <div class="card-header">
                                <h3>Add Tax</h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ url('createtax') }}" method="post" id="taxForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">

                                                <label>Tax Name</label>
                                                <input type="hidden" name="id"
                                                    value="{{(isset($tax->id) && !empty($tax->id)) ? $tax->id : ''}}">
                                                <input type="text" class="form-control" name="name"
                                                    value="{{(isset($tax->tax_name) && !empty($tax->tax_name)) ? $tax->tax_name : ''}}"
                                                    aria-describedby="emailHelp" placeholder="Enter Tax Name">
                                                @error('name')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label>Tax type</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="type"
                                                        @if(isset($tax->type) && $tax->type=='percentage') ? checked="Checked"
                                                    :"" @endif value="percentage" id="flexRadioDefault1">
                                                    <label class="form-check-label mr-5" for="flexRadioDefault1">
                                                        Percentage
                                                    </label>
                                                    <input class="form-check-input" type="radio" name="type"
                                                        @if(isset($tax->type) && $tax->type=='amount') ? checked="Checked"
                                                    :"" @endif value="amount" id="flexRadioDefault2" >
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        Fixed Amount
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Value</label>
                                                <input type="number" class="form-control" name="value"
                                                    value="{{(isset($tax->value) && !empty($tax->value)) ? $tax->value : ''}}"
                                                    placeholder="Enter tax value">
                                            </div>
                                        </div>
                                    </div>






                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                        <a href="{{url()->previous()}}" class="btn btn-danger">Cancel</a>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- /.content -->
    </div>

    @include('layouts.footer')




</x-app-layout>