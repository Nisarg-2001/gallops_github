<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\product_master;
use App\Models\state;
use App\Models\role;
use Illuminate\Validation\Rules;
use Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = User::all()->count();
        $product = product_master::all()->count();
        return view('admin.dashboard')->with(['user'=>$user,'product'=>$product]);
    }

    public function view()
    {
        $user = User::all();
        return view('admin.user.index',['user'=>$user]);

    }

    public function create()
    {
        $state = state::all();
        $role = role::all();
        return view('admin.user.action')->with(['state'=>$state,'role'=>$role]);
    }

    public function edit($id)
    {
        $state = state::all();
        $role = role::all();
        $user = User::find($id);
        
        return view('admin.user.action',['data'=>$user,'state'=>$state,'role'=>$role]);
    }

    public function addupdate(Request $request)
    {
        if($request->has('id') && !empty($request->id))
        {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->contact = $request->contact;
            $user->gst = $request->gst;
            $user->cin = $request->cin;
            $user->fssai = $request->fssai;
            $user->address_line_1 = $request->address1;
            $user->address_line_2 = $request->address2;
            $user->state = $request->state;
            $user->pincode = $request->pincode;
            $user->role = $request->role;
            $user->save();
            $request->session()->flash('status', 'Task was successful!');
            return redirect('user')->with('success',' User Updated Successfully');
        }
        else
        {
         $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
            'contact' => ['required'],
            'gst' => ['required'],
            'cin' => ['required'],
            'fssai' => ['required'],
            'username' => ['required'],
            'pincode' =>['required'],
            'role' => ['required'],    
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact' => $request->contact,
            'gst' => $request->gst,
            'cin' => $request->cin,
            'fssai' => $request->fssai,
            'username' => $request->username,
            'address_line_1' => $request->address1,
            'address_line_2' => $request->address2,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'role' => $request->role,
        ]);
        $request->session()->flash('status', 'Task was successful!');
        return redirect('user')->with('success',' User Created Successfully');
        }
    }
    public function delete($id)
    {
        $user=User::find($id);
        $user->delete();
        return redirect('user')->with('danger',' User deleted Successfully');  
    }
}
