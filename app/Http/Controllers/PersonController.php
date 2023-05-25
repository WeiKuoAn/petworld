<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserLog;
use App\Models\Debit;

class PersonController extends Controller
{
    public function show()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('person.edit-profile')->with('user', $user)
                                       ->with('hint', '0');
    }

    public function update(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        //取得舊資料，要寫入log中
        $old_name = $user->name;
        $old_mobile = $user->mobile;
        $old_email = $user->email;
        $old_address = $user->address;

        if(Auth::user()->level == 0 && Auth::user()->level == 1){
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->entry_date = $request->entry_date;
            $user->level = $request->level;
            $user->status = $request->status;
            $user->save();
        }else{
            //不是管理員的話，要紀錄到log中
            $user_log = new UserLog();
            $user_log->type = 'edit';
            $user_log->user_id = $user->id;
            $user_log->title = ' ';
            $user_log->text = ' ';
            if ($old_name != $request->name) {
                $user_log->title .= '姓名' . "*";
                $user_log->text .= $old_name . "→" . $request->name . "*";
            }
            if ($old_email != $request->email) {
                $user_log->title .= '信箱' . "*";
                $user_log->text .= $old_email . "→" . $request->email . "*";
            }
            if ($old_mobile != $request->mobile) {
                $user_log->title .= '電話' . "*";
                $user_log->text .= $old_mobile . "→" . $request->mobile . "*";
            }
            if ($old_address != $request->address) {
                $user_log->title .= '地址' . "*";
                $user_log->text .= $old_address . "→" . $request->address . "*";
            }
            $user_log->Update_at = Auth::user()->id;
            $user_log->save();
            

            $user->name = $request->name;
            $user->sex = $request->sex;
            $user->birthday = $request->birthday;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
           
            $user->ic_card = $request->ic_card;
            $user->marriage = $request->marriage;
            $user->address = $request->address;
            $user->census_address = $request->census_address;
            $user->bank_id = $request->bank_id;
            $user->bank_number = $request->bank_number;
            $user->urgent_name = $request->urgent_name;
            $user->urgent_relation = $request->urgent_relation;
            $user->urgent_mobile = $request->urgent_mobile;
            $user->state = 0; //用戶只能修改第一次,第一次修改後 只能透過人資去修改，所以狀態是0
            $user->save();
        }
        return view('person.edit-profile')->with('user', $user)
                                        ->with('hint','1');
    }

     //員工送出借出。補錢單
     public function debit_create()
     {
         return view('debit.new_debit')->with('hint', '0');
     }
 
     public function debit_store(Request $request)
     {
         $data = new Debit();
         $data->user_id = Auth::user()->id;
         $data->type = $request->type;
         $data->price = $request->price;
         $data->state = $request->type;
         $data->comment = $request->comment;
         $data->save();
         return redirect()->route('new-debit');
     }
}
