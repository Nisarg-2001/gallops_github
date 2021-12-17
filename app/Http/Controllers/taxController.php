<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tax_master;
use Illuminate\Validation\Rules;
use DB;

class taxController extends Controller
{
    public function view()
    {
      $data = DB::table('tax_masters')->paginate(10);
      return view('admin.tax.index',['data'=>$data]);
    }

    public function create()
    {
      return view('admin.tax.action');
    }

    public function edit($id)
    {
      $tax = tax_master::find($id);
      return view('admin.tax.action',['tax'=>$tax]);
    }

    public function addupdate(Request $request)
    {
      
      if(isset($request->id) && !empty($request->id))
       {
         $tax = tax_master::find($request->id);
         $tax->tax_name = $request->name;
         $tax->save();
         $request->session()->flash('status', 'Task was successful!');
         return redirect('tax')->with('success',' Tax Updated Successfully');
       }
     else{

      $request->validate([
        "name" => ["required","unique:tax_masters,tax_name"],
        ]);
       

      $tax = new tax_master;
      $tax->tax_name = $request->name;
      $tax->save();
      $request->session()->flash('status', 'Task was successful!');
        return redirect('tax')->with('success',' Tax Added Successfully');
     }
       
    }

    public function delete($id)
    {
        $user=tax_master::find($id);
        $user->delete();
        return redirect('tax')->with('danger',' Tax Deleted Successfully');  
    }
}
