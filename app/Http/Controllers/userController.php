<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\product_master;
use App\Models\state;
use App\Models\role;
use App\Models\order;
use Illuminate\Validation\Rules;
use Hash;
use DB;
use Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = User::all()->count();
        $products = product_master::all()->count();
        $product = product_master::all();
        $order = DB::table('orders')->paginate(10);
        return view('admin.dashboard')->with(['user'=>$user,'product'=>$product,'products'=>$products,'order'=>$order]);
    }

    public function view()
    {
        $user = DB::table('users')->join('roles', 'users.role', '=', 'roles.id')->select('users.*', 'roles.role as rolename')->paginate(10);
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
            $user->status = $request->status;
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

    public function resetPassword(Request $request)
    {
        $request->validate([
            'ctpass' => ['required'],
            'pass' => ['required'],
            'cnpass' => ['required'],['confirmed:pass'],
        ]);

        $data=User::find($request->id);
        if(!Hash::check($request->ctpass,$data->password))
        {
            return back()->with('danger','Password does not match our records');
            
        }
        else
        {
            $data->password = Hash::make($request->pass);
            $data->save();
            return back()->with('success','Password Reset Successfully');
        }
        

    }
}
