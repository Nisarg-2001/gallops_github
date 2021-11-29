<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category_master;
use App\Models\sub_category_master;
use DB;

class sub_categoryController extends Controller
{
    public function view()
    {
        $data = DB::table('sub_category_masters')->paginate(10);
        return view('admin.subCategory.index',['data'=>$data]); 
    }

    public function create()
    {   
        $category= category_master::all();
        return view('admin.subCategory.action')->with(['category'=>$category]);
    }

    public function edit($id)
    {
            $data = sub_category_master::find($id);
            $category= category_master::all();
            return view('admin.subCategory.action',['data'=>$data,'category'=>$category]); 
    }
    public function addupdate(Request $request)
    {
       
        if(isset($request->id) && !empty($request->id))
        {
            $data = sub_category_master::find($request->id);
            $data->sub_category = $request->name;
            $data->category = $request->category;
            $data->save();
            $request->session()->flash('status', 'Task was successful!');
            return redirect('subCategory')->with('success',' subCategory Updated Successfully');
        }
        else
        {
            $request->validate([
                'name' => "required|unique:sub_category_masters,sub_category",
                'category' => "required",
            ]);
        $category = new sub_category_master;
        $category->sub_category = $request->name;
        $category->category = $request->category;
        $category->save();
        $request->session()->flash('status', 'Task was successful!');

        return redirect('subCategory')->with('success',' subCategory Added Successfully');
        }
    }

    public function delete($id)
    {
        $user=sub_category_master::find($id);
        $user->delete();
        return redirect('subCategory')->with('success',' subCategory deleted Successfully');
    }
}
