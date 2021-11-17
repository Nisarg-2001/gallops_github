<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category_master;

class categoryController extends Controller
{
    public function view()
    {
        $data = category_master::all();
        return view('admin.category_index',['data'=>$data]); 
    }

    public function edit($id)
    {
        $data = category_master::find($id);
        return view('admin.edit_category',['data'=>$data]);
    }
    public function addupdate(Request $request)
    {
        $request->validate([
            'title' => "required|unique:category_masters,title",
            'description' => "required",
        ]);
        if($request->has('id'))
        {
            $data = category_master::find($request->id);
            $data->title = $request->title;
            $data->description = $request->description;
            $data->save();
            return redirect('category');
        }
        else
        {
        $category = new category_master;
        $category->title = $request->title;
        $category->description = $request->description;
        $category->save();

        return redirect('category');
        }
    }

    public function delete($id)
    {
        $user=category_master::find($id);
        $user->delete();
        return redirect('category');  
    }
}
