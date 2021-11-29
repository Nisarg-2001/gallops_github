<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\role;
use Illuminate\Validation\Rules;
use DB;
use Auth;

class roleController extends Controller
{
    public function view()
    {
      $data = DB::table('roles')->paginate(10);
      return view('admin.role.index',['data'=>$data]);
    }

    public function create()
    {  
      return view('admin.role.action');
    }

    public function edit($id)
    {      
      $data = role::find($id);  
      return view('admin.role.action')->with(['data'=>$data]);
    }

    public function addupdate(Request $request)
    {
      
      if(isset($request->id) && !empty($request->id))
       {
         $role = role::find($request->id);
         $role->role = $request->role;
         $role->save();
         $request->session()->flash('status', 'Task was successful!');
         return redirect('role')->with('success',' Role Updated Successfully');
       }
     else{

      $request->validate([
        "role" => ["required","unique:roles,role"],
        ]);
       

      $role = new role;
      $role->role = $request->role;
      $role->save();
      $request->session()->flash('status', 'Task was successful!');
        return redirect('role')->with('success',' Role Added Successfully');
     }
       
    }

    public function delete($id)
    {
        $user=role::find($id);
        $user->delete();
        return redirect('role')->with('danger',' Role Deleted Successfully');  
    }
}
