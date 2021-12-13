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
                                <form action="{{ url('outward/post') }}" method="post" id="outwardForm">
                                    @csrf

                                    <div class="row">
                                        @if((isset($orderData)))
                                        @else
                                        <div class="col-12 col-lg-12 col-md-6">
                                            <div class="form-group">
                                                <label>Select Product *</label>
                                                <select class="form-control select2" style="width: 100%;"
                                                    name="product_id" id="product_id">
                                                    <option value="">Select Product</option>
                                                    @foreach($product as $p)
                                                    <option value="{{$p->id}}">
                                                        {{ $p->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Person Name</label>
                                                <input type="text" class="form-control" name="name"
                                                value="{{ (isset($orderData->person_name) && !empty($orderData->person_name)) ? $orderData->person_name : '' }}" {{ ((isset($orderData))) ? 'readonly' : '' }} />
                                                @error('name')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Date of Issue</label>
                                                <input type="date" class="form-control" name="dateofissue"
                                                value="{{ (isset($orderData->issue_date) && !empty($orderData->issue_date)) ? $orderData->issue_date : date('Y-m-d', strtotime('+7 day')) }}" {{ ((isset($orderData))) ? 'readonly' : '' }}
                                                    placeholder="Date of Issue">
                                                @error('dateofissue')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <table id="example1" class="table table-bordered table-hover order-table">
                                        <thead>
                                            <tr>
                                                <th class='text-center' width="5%">No.</th>
                                                <th width="75%">Product Name</th>
                                                <th width="20%">Quantity</th>
                                                <!-- <th></th> -->
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr>
                                                @if(isset($orderItemData) && $orderItemData)
                                                    @php $i=1; @endphp
                                                

                                                @foreach($orderItemData as $orderItem)
                                               
                                                <td class='text-center'> {{ $i }} </td>
                                                <td>

                                                    <input type='text' value=" {{ $orderItem->product_name }}"
                                                        id="Item_{{ $i }}" name='Item[]' class='form-control '
                                                        readonly />
                                                </td>
                                                <td>
                                                    <input type='number' value="{{ $orderItem->qty }}" id="Qty_{{ $i }}"
                                                        name='Qty[]' class='form-control filterme' min='1' max='9999'
                                                        onkeyup="updateAmount('{{ $orderItem->item_id }}', '{{ $i }}')"
                                                        onchange="updateAmount('{{ $orderItem->item_id }}', '{{ $i }}')"
                                                        readonly>
                                                </td>
                                               
                                                
                                                <!-- <td class='text-center'>
                          <button type="button" class="btn btn-danger btn-sm removethis">
                            <i class="fa fa-trash"></i>
                          </button>
                        </td> -->
                                            </tr>
                                            @php $i++; @endphp
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                    

                                   

                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Note</label>
                                            <textarea type="text" class="form-control" name="note" id="note" value=""
                                                placeholder="{{ ((isset($orderData))) ? '' : 'Enter Note...' }}"
                                                {{ ((isset($orderData))) ? readonly : '' }}>{{ (isset($orderData) && !empty($orderData->note)) ? $orderData->note : '' }}</textarea>
                                            @error('name')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        @if((isset($orderData)))
                                        @else
                                        <button type="submit" class="btn btn-primary" onClick="return check();">Place
                                            Order</button>
                                        @endif
                                        <a href="{{url('return')}}" class="btn btn-danger">Back</a>
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
    <script src="{{ asset('/admin/assets/js/outward/action.js') }}"></script>
    @endsection
    @include('layouts.footer')
</x-app-layout>