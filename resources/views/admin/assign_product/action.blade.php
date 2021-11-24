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
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ url('assign_product/post') }}" method="post" id="assignProductForm">
                                    @csrf
                                    <input type="hidden" name="id"
                                        value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}">

                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Select Vendor *</label>
                                                <select class="form-control select2" style="width: 100%;"
                                                    name="vendor_id" id="vendor_id">
                                                    <option value="">Select Vendor</option>
                                                    @foreach($vendor as $v)
                                                    <option value="{{$v->id}}"
                                                        {{ (isset($data->vendor_id) && $data->vendor_id == $v->id ) ? 'selected' : '' }}
                                                        {{(Request::get("vendor")) ? 'selected' : ''}}>
                                                        {{ $v->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Select Product *</label>
                                                <select class="form-control select2" style="width: 100%;"
                                                    name="product_id" id="product_id">
                                                    <option value="">Select Product</option>
                                                    @foreach($product as $p)
                                                    <option value="{{$p->id}}"
                                                        {{ (isset($data->product_id) && $data->product_id == $p->id ) ? 'selected' : '' }}
                                                        {{(Request::get("product")) ? 'selected' : ''}}>{{ $p->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Price (₹) *</label>
                                                <input type="text" class="form-control" name="price"
                                                    value="{{ (isset($data->price) && !empty($data->price)) ? $data->price : '' }}"
                                                    placeholder="Product Price">
                                                @error('name')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="taxSection">
                                        @if(isset($data) && !empty($data->id))
                                        {!! $defaultProdcutTaxView !!}
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-3 col-lg-3">
                                        <div class="form-group">

                                            @php
                                            $yesChecked = $noChecked = '';
                                            @endphp

                                            @if((isset($data->is_default) && $data->is_default == 1 ))
                                            @php $yesChecked = 'checked'; @endphp
                                            @else
                                            @php $noChecked = 'checked'; @endphp
                                            @endif
                                            <label>Is default?</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_default" value="1"
                                                    {{ $yesChecked }}>
                                                <label class="form-check-label mr-5" for="flexRadioDefault1">
                                                    Yes
                                                </label>
                                                <input class="form-check-input" type="radio" name="is_default" value="0"
                                                    {{ $noChecked }}>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                        <a href="{{url('assign_product')}}" class="btn btn-danger">Cancel</a>
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
    @section('page-footer-script')
    <script src="{{ asset('/admin/assets/js/common.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/form-validation.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/assign_product/action.js') }}"></script>
    @endsection
    @include('layouts.footer')
</x-app-layout>