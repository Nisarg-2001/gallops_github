<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\category_master;
use App\Models\sub_category_master;


class categoryController extends Controller
{
    public function view()
    {
        $data = category_master::all();
        return view('admin.category.index', ['data' => $data]);
    }

    public function create()
    {
        return view('admin.category.action');
    }

    public function edit($id)
    {
        $data = category_master::find($id);
        return view('admin.category.action', ['data' => $data]);
    }
    public function addupdate(Request $request)
    {
        if (isset($request->id) && !empty($request->id)) {
            $data = category_master::find($request->id);
            $data->title = $request->title;
            $data->description = $request->description;
            $data->save();

            return redirect('category')->with('success',' Category Updated Successfully');
        } else {
            $request->validate([
                'title' => "required|unique:category_masters,title",
                'description' => "required",
            ]);
            $category = new category_master;
            $category->title = $request->title;
            $category->description = $request->description;
            $category->save();
            
            return redirect('category')->with('success',' Category Added Successfully');
        }
    }

    public function delete($id)
    {
        $category = category_master::find($id);
        $subCategory = sub_category_master::where('category',$id);
        $category->delete();
        $subCategory->delete();
        return redirect('category')->with('danger',' Category Deleted Successfully');
    }

}
