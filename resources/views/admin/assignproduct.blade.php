<x-app-layout>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product Assign master</h1>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
        

            <div class="card">
              <div class="card-header">
              <h3>Assign Products</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="{{ url('createtax') }}" method="post" id="form">
                @csrf
<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
    <div class="form-group">
                  <label>Select vendor</label>
                  <select class="form-control select2" style="width: 100%;">
                  @foreach($product as $info)
                    <option value="{{$info->id}}">{{ $info->name }}</option>
                  @endforeach
                  </select>
                </div>
</div>


</div>
<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
    <div class="form-group">
                  <label>Select Product</label>
                  <select class="form-control select2" style="width: 100%;">
                  @foreach($vendor as $info)
                    <option value="{{$info->id}}">{{ $info->name }}</option>
                  @endforeach
                  </select>
                </div>
</div>


</div>
<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Tax</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>Trident</td>
                    <td>Internet
                      Explorer 5.0
                    </td>
                    <td>Win 95+</td>
                    <td>Tax : <input type="text" name="value" class="form-input"  /> <strong>&nbsp;%</strong></td>
                    <td>C</td>
                  </tr>
              
                  <tr>
                    <td>Misc</td>
                    <td>IE Mobile</td>
                    <td>Windows Mobile 6</td>
                    <td>Tax : <input type="text" name="value" class="form-input"  /> <strong>&nbsp;%</strong></td>
                    <td>C</td>
                  </tr>
                  <tr>
                    <td>Misc</td>
                    <td>PSP browser</td>
                    <td>PSP</td>
                    <td>Tax : <input type="text" name="value" class="form-input"  /> <strong>&nbsp;%</strong></td>
                    <td>C</td>
                  </tr>
                  <tr>
                    <td>Other browsers</td>
                    <td>All others</td>
                    <td>-</td>
                    <td>Tax : <input type="text" name="value" class="form-input"  /> <strong>&nbsp;%</strong></td>
                    <td>U</td>
                  </tr>
                   
                  </tr>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Tax</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
                 




<div class="text-center">
  <button type="submit" class="btn btn-primary ">Add Tax</button>
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

  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 </strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>

 
</x-app-layout>

