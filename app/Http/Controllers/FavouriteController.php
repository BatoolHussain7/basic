<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expert;
use App\Models\Favourite;
use Illuminate\Support\Facades\Storage;
class FavouriteController extends Controller
{
    public function makeFavouriteList(Request $request){
        
       $favourite = new Favourite();
       $favourite->user_id = $request->user_id;
       $favourite->expert_id = $request->expert_id;
       $favourite->save();
       return response()->json(['status' => 200]);
   }

//       public function getFav(Request $request){

//        $user = User::find($request->id);
//        return response()->json($user->expert);

//    }
  
//    public function deleteFav(Request $request){
//     $request= Expert::where('id',$request->id)->get->first();
//     $request->delete();
//     return response()->json([
//         'message'=>'success',
//     ]);
//    }
}
