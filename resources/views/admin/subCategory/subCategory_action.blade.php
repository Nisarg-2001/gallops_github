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
              <form action="{{ url('createsubCategory') }}" method="post" id="catForm">
                @csrf


<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
    <div class="form-group">
    <label >Sub Category</label>
    <input type="hidden" name="id" value="{{ (isset($data->id) && !empty($data->id)) ? $data->id : '' }}" >
    <input type="text" class="form-control" name="name" value="{{ ( isset($data->sub_category) && !empty($data->sub_category)) ? $data->sub_category : '' }}"  placeholder="Sub Category" required>
    @error('title')
    <div class="text-danger">{{$message}}</div>
    @enderror
   
  </div>
</div>
<div class="col-12 col-md-6 col-lg-6">
<div class="form-group">
    <label for="exampleInputPassword1">Category</label>
    <select id="inputState" name="category" class="form-control" required>
      @foreach($category as $info)
        <option value="{{ $info->id}}" @if(isset($data->category) && $data->category==$info->id) ? selected="Selected" :'' @endif >{{ $info->title }}</option>
      @endforeach
      </select>
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

