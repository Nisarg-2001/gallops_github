<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Hash;

class UserController extends Controller
{

    public function view()
    {
        $user = User::all();
        return view('admin.user_index',['user'=>$user]);

    }

    public function store(Request $request)
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

        return redirect('user');
    }

    public function delete($id)
    {
        $user=User::find($id);
        $user->delete();
        return redirect('user');
    }

    
}
