<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tax_master;
use Illuminate\Validation\Rules;

class taxController extends Controller
{
    public function view()
    {
      $data = tax_master::all();
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
         $tax->type = $request->type;
         $tax->value = $request->value;
         $tax->save();
         $request->session()->flash('status', 'Task was successful!');
         return redirect('tax');
       }
     else{

      $request->validate([
        "name" => ["required","unique:tax_masters,tax_name"],
        "type" => ["required"],
        "value" => ["required"],
        ]);
       

      $tax = new tax_master;
      $tax->tax_name = $request->name;
      $tax->type = $request->type;
      $tax->value = $request->value;
      $tax->save();
      $request->session()->flash('status', 'Task was successful!');
        return redirect('tax');
     }
       
    }

    public function delete($id)
    {
        $user=tax_master::find($id);
        $user->delete();
        return redirect('tax');  
    }
}
