<?php
namespace App\Actions\Api\Auth;

use App\Mail\ForgotMail;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class ForgotPasswordAction{
  public function execute(Collection $collection){
    DB::beginTransaction();
    try{
      $user = User::where('email',$collection['email'])->first();
      if(!$user){
        return ['status'=>false,'message'=>'User does not exist','code'=>422];
      }
      $new_password = Str::random(10);
      $user->password = Hash::make($new_password);
      Mail::to($collection['email'])
      ->send(new ForgotMail(data:['new_password'=>$new_password,'name'=>$user->name]));
      $user->save();
      DB::commit();
      return ['status'=>true,'message'=>'Password resets successfully'];;
    }catch(Throwable $th){
      info($th);
      DB::rollback();
      return ['status'=>false,'message'=>'Something went wrong','code'=>500];
    }
  }
}