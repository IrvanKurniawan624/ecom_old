<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;
use Socialite;
use Auth;

use App\Models\User;

class GoogleSocialiteController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleCallback()
    {
        try {
     
            $user = Socialite::driver('google')->user();
      
            $finduser = User::where('social_id', $user->id)->first();
      
            if($finduser){
      
                return redirect('/dashboard');
      
            }else{
                $newUser = User::create([
                    'nama' => $user->name,
                    'tipe_customer_id'=>1,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'is_active'=>1,
                    'poin'=>0,
                    'social_type'=> 'google',
                    'password' => encrypt('my-google')
                ]);
     
                return redirect('/dashboard');
            }
     
        }
        
        catch (Exception $e) {
            dd($e->getMessage());
        }
    }

}