<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\unit_master;
use Illuminate\Validation\Rules;
use DB;

class unitController extends Controller
{
  public function view()
  {
    $unit = DB::table('unit_masters')->paginate(10);
    return view('admin.unit_of_measurement.index', ['unit' => $unit]);
  }

  public function create()
  {
    return view('admin.unit_of_measurement.action');
  }

  public function edit($id)
  {
    $unit = unit_master::find($id);
    return view('admin.unit_of_measurement.action', ['unit' => $unit]);
  }

  public function addupdate(Request $request)
  {

    if (isset($request->id) && !empty($request->id)) {
      $unit = unit_master::find($request->id);
      $unit->unit = $request->name;
      $unit->save();
      $request->session()->flash('status', 'Task was successful!');
      return redirect('unit')->with('success', ' Unit Updated Successfully');
    } else {

      $request->validate([
        "name" => ["required", "unique:unit_masters,unit"],
      ]);


      $unit = new unit_master;
      $unit->unit = $request->name;
      $unit->save();
      $request->session()->flash('status', 'Task was successful!');
      return redirect('unit')->with('success', ' Unit Added Successfully');
    }
  }

  public function delete($id)
  {
    $unit = unit_master::find($id);
    $unit->delete();
    return redirect('unit')->with('danger', ' Unit Deleted Successfully');
  }
}
