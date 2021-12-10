<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\vendor_master;
use App\Models\state;
use Illuminate\Http\Request;
use Hash;
use Session;
use DB;


class vendorController extends Controller
{
    public function login(Request $request)
    {
        if(isset($request->email))
        {
            $email =$request->input('email');
            $password =$request->input('password');
            $user = vendor_master::where('email',$email)->first();
            if(!$user || !Hash::check($password,$user->password))
            {
                return back()->with('danger', 'Password does not match our records');
            }
            else
            {
                Session::put('vname',$user->name);
                Session::put('vid',$user->id);
                return redirect('vendor/dashboard');
            }
                
        }
        else
            return view('vendors.login');
    }
    public function home()
    {
    
        return view('vendors.dashboard');
    }
    public function view()
    {
        $data = DB::table('vendor_masters')->paginate(10);
        return view('admin.vendor.index',['data'=>$data]);
    }

    public function create()
    {
        $state = state::all();
        return view('admin.vendor.action')->with(['state'=>$state]);
    }

   public function edit($id)
    {
        $vendor = vendor_master::find($id);
        $state = state::all();
        return view('admin.vendor.action',['data'=>$vendor,'state'=>$state]);
    }

    public function addupdate(Request $request)
    {
        if($request->has('id') && !empty($request->id))
        {
            $data = vendor_master::find($request->id);
            $data->name = $request->name;
            $data->email = $request->email;
            $data->contact = $request->contact;
            $data->gst = $request->gst;
            $data->cin = $request->cin;
            $data->fssai = $request->fssai;
            $data->address_line_1 = $request->address1;
            $data->address_line_2 = $request->address2;
            $data->state = $request->state;
            $data->pincode = $request->pincode;
            $data->save();
            $request->session()->flash('status', 'Task was successful!');
            return redirect('vendors')->with('success',' Vendor Updated Successfully');



        }
        else
        {
        $vendor = new vendor_master;
        $vendor->name = $request->name;
        $vendor->email= $request->email;
        $vendor->contact = $request->contact;
        $vendor->username = $request->username;
        $vendor->password =  Hash::make($request->password);
        $vendor->gst = $request->gst;
        $vendor->cin =$request->cin;
        $vendor->fssai = $request->fssai;
        $vendor->address_line_1 = $request->address1;
        $vendor->address_line_2 =$request->address2;
        $vendor->state = $request->state;
        $vendor->pincode = $request->pincode;
        $vendor->save();
        $request->session()->flash('status', 'Task was successful!');
        return redirect('vendors')->with('success',' Vendor Added Successfully');
        }
    }

    public function order(Request $request)
    {
        if(isset($request))
        {
            return view('vendors.order');
        }
        else
        {
            return view('vendors.order');
        }
    }

    public function delete($id)
    {
        $user=vendor_master::find($id);
        $user->delete();
        return redirect('vendors')->with('danger',' Vendor Deleted Successfully');  
    }
}
