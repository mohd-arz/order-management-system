<?php
namespace App\Actions\Api\Auth;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Throwable;

class RegisterAction{
  public function execute(Collection $collection){
    DB::beginTransaction();
    try{
      $user = new User();
      $user->name = $collection['name'];
      $user->email = $collection['email'];
      $user->password = Hash::make($collection['password']);
      if($user->save()){
        if (!Auth::attempt(['email' => $collection['email'], 'password' => $collection['password']])) {
          DB::rollback();
          return false;
        }
      }
      DB::commit();
      return true;
    }catch(Throwable $th){
      info($th);
      DB::rollback();
      return false;
    }
  }
}