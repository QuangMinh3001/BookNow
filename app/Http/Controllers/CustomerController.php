<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Comment;
class CustomerController extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function all_account(){
        $this->Authlogin();
        $all_customer = Customer::orderBy('customer_id','DESC')->paginate(10);
        $manager_customer = view('admin.all_account')->with('all_account',$all_customer);
        return view('admin_layout')->with('admin.all_account',  $manager_customer);
    }
    public function unactive_account($customer_id){
        $this->Authlogin();
        Customer::where('customer_id',$customer_id)->update(['customer_status'=>1]);
        Session::put('message','Kích hoạt tài khoản.');
        return Redirect::to('all-account');
    }
    public function active_account($customer_id){
        $this->Authlogin();
        Customer::where('customer_id',$customer_id)->update(['customer_status'=>0]);
        Session::put('message','Khóa tài khoản.');
        return Redirect::to('all-account');
    }
}
