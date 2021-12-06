<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\shelf_life;
use Illuminate\Validation\Rules;
use DB;

class shelflifeController extends Controller
{
    public function view()
    {
      $psl = DB::table('shelf_lives')->paginate(10);
      return view('admin.product_shelf_life.index',['psl'=>$psl]);
    }

    public function create()
    {
      return view('admin.product_shelf_life.action');
    }

    public function edit($id)
    {
      $psl = shelf_life::find($id);
      return view('admin.product_shelf_life.action',['psl'=>$psl]);
    }

    public function addupdate(Request $request)
    {
      
      if(isset($request->id) && !empty($request->id))
       {
         $psl = shelf_life::find($request->id);
         $psl->label = $request->label;
         $psl->month = $request->month;
         $psl->year = $request->year;
         $psl->save();
         $request->session()->flash('status', 'Task was successful!');
         return redirect('productshelflife')->with('success',' Shelf Life Updated Successfully');
       }
     else{

      $request->validate([
        "label" => ["required"],
        ]);
       

        $psl = new shelf_life;
        $psl->label = $request->label;
        $psl->month = $request->month;
        $psl->year = $request->year;
        $psl->save();
      $request->session()->flash('status', 'Task was successful!');
        return redirect('productshelflife')->with('success',' Shelf Life Added Successfully');
     }
       
    }

    public function delete($id)
    {
        $unit=shelf_life::find($id);
        $unit->delete();
        return redirect('productshelflife')->with('danger',' Shelf Life Deleted Successfully');  
    }
}
