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
          @if( session('success'))
              <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="fa fa-times"></i>
                </button>
                {{session('success')}}
              </div>
              @endif
              @if( session('danger'))
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="fa fa-times"></i>
                </button>
                {{session('danger')}}
              </div>
            @endif

            <div class="card">
              <div class="card-header">
                <a href="{{ url('assign_product/add') }}" class="btn btn-primary"> Assign Product</a>
                <a href="" id="reload" class="btn btn-sm btn-primary float-right"
                                    title="Refresh"><i class="fas fa-redo-alt"></i></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Vendor Name</th>
                      <th>Product Name</th>
                      <th>Price</th>
                      @foreach($taxData as $tax) 
                      <th>{{$tax->tax_name}} (%)</th>
                      @endforeach
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $info)

                    @php
                      $taxSingleRecord = [];
                      $taxRec = ($info->tax != '') ? json_decode($info->tax) : [];
                      
                    @endphp
                    @if(!empty($taxRec))
                      @foreach($taxRec as $t)
                        @php 
                          $taxSingleRecord[$t->id] = $t;
                        @endphp
                      @endforeach
                    @endif

                    <tr>
                      <td>{{ $info->vendor_name }}</td>
                      <td>{{ $info->product_name }}</td>
                      <td>{{ $info->price }}</td>
                      @foreach($taxData as $tax)
                      <td>{!! (isset($taxSingleRecord[$tax->id]) && !empty($taxSingleRecord[$tax->id]->value)) ? $taxSingleRecord[$tax->id]->value : '-' !!}</td>
                      @endforeach

                      <td class="text-center">
                        <a href="{{ url('assign_product/edit/'.$info->id)}}" class="btn btn-info" title="Edit"><i class="fas fa-pencil"></i></a>
                        <a data-confirm="" href="{{ url('assign_product/delete/'.$info->id)}}" data-id="{{$info->id}}" class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    @endforeach
                </table>
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
    <script src="{{ asset('/admin/assets/js/data-tables.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/sweetalert.js') }}"></script>

  @endsection
  @include('layouts.footer')


</x-app-layout>