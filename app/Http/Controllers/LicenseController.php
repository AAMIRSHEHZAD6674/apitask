<?php

namespace App\Http\Controllers;

use App\Models\LicenseModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LicenseController extends Controller
{

    public function index(Request $request)
    {

        $data = [
            'owner_name' => $request->owner_name,
            'business_name' => $request->business_name,
            'voucher_no' => $request->voucher_no,
            'amount' => $request->amount,
            'cnic' => $request->cnic,

        ];
        LicenseModel::create($data);
        return "Data Saved";


    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $data = $user->createToken($request->email);

        return ['token' => $data->plainTextToken];

    }

    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {


            $data = Auth::user()->createToken($request->email);
            return ['token' => $data->plainTextToken];
        }
        return "Unathorised user";
    }

    public function show(Request $request)
    {
        $data = LicenseModel::get([
            'owner_name', 'voucher_no', 'business_name', 'amount', 'cnic',

        ])->where('voucher_no', $request->voucher_no);
        return $data;
    }

    public function update(Request $request)
    {


        $data=LicenseModel::where('voucher_no',$request->voucher_no)->first();
        if($data['branch_code']!=null){
            return 'alredy updated';
        }


        $data =  [
            'paid_amount' =>$request->paid_amount,
            'paid_date' => date('Y-m-d  H:i:s'),
            'branch_code'=> $request->branch_code,
            'transection_id' => $request->transection_id,
        ];




        LicenseModel::where('voucher_no', $request->voucher_no)
            ->update($data);

        return "Data Updated";

    }

}
