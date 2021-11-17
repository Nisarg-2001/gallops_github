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
      return view('admin.tax_index',['data'=>$data]);
    }

    public function edit($id)
    {
      $tax = tax_master::find($id);
      return view('admin.edit_tax',['tax'=>$tax]);
    }

    public function addupdate(Request $request)
    {
        
       if($request->has('id'))
       {
         $tax = tax_master::find($request->id);
         $tax->tax_name = $request->name;
         $tax->type = $request->type;
         $tax->value = $request->value;
         $tax->save();

         return redirect('tax');
       }
     else{   
      $request->validate([
        'tax_name' => ['required'],
        'type' => ['required'],
        'value' => ['required'],
    ]);


      $tax = new tax_master;
      $tax->tax_name = $request->name;
      $tax->type = $request->type;
      $tax->value = $request->value;
      $tax->save();
      

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
