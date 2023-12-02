<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
class CryptoController extends Controller
{
    public function encryptleadid($id)
    {
        //$data=User::find($id)->get(['full_name','email','password']);
        $data=DB::table('users')->where('id',$id)->select('full_name','email','password')->first();
        //dd($data);
        $string=254;
        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = 'apnacare';
        $secret_iv = 'hhms';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
       
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        
        $output = base64_encode($output);
       
        return response()->json(['status'=>200,'data'=>$output]);
    }

    public function decrypt(Request $request)
    {
        $data=DB::table('users')->where('email',$request->email)->select('full_name','email','password')->first();
        if(!empty($data))
        {
            $user_password=$data->password;
            $validate=\Hash::check($request->password,$user_password);
            if($validate)
            {
                return response()->json(['status'=>200,'data'=>"User Login Successfully"]);
            }else{
                return response()->json(['status'=>404,'data'=>"User Password Incorrect"]);
            }
            
            return response()->json(['status'=>404,'data'=>"User Password Incorrect"]);
        }else{
            return response()->json(['status'=>200,'data'=>"Email Id not Present"]);
        }
        return response()->json(['status'=>404,'data'=>$data]);
       
        
    }

    public function update(Request $request)
    {
        $data=DB::table('users')->where('email',$request->email)->select('full_name','email','password')->first();
        if(!empty($data))
        {
            $updated_password= bcrypt($request->password);
            $data=DB::table('users')->where('email',$request->email)->update(['password'=>$updated_password]);
            // $validate=\Hash::check("Magesh@123",$user_password);
            return response()->json(['status'=>200,'data'=>"Password Updated Successfully"]);
            
        }else{
            return response()->json(['status'=>200,'data'=>"Password Updated Failed"]);
        }

    }
}
