<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Job;
use App\Models\Branch;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('status','0')->orderby('level')->paginate(30);
        return view('user.users')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branchs = Branch::where('status','up')->get();
        $jobs = Job::where('status','up')->get();
        return view('user.create')->with('jobs',$jobs)->with('branchs',$branchs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'entry_date' => $request->entry_date,
            'job_id'=> $request->job_id,
            'branch_id'=> $request->branch_id,
            'level' => '2',
            'state' => '1' //剛開始由管理員新增時
        ]);

        return redirect()->route('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        $jobs = Job::where('status','up')->get();
        return view('user.edit')->with('user', $user)
                                     ->with('hint', '0')
                                     ->with('jobs',$jobs);
    }

    public function password_show()
    {
        return view('person.edit-password')->with('hint','0');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    // public function check()
    // {
    //     $datas = User::where('status','0')->orderby('level')->paginate(30);
    //     return view('user.users')->with('users', $users);
    // }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ((Hash::check($request->password, $user->password))) {
            if ($request->password_new === $request->password_conf) {
                $user->password = Hash::make($request->password_new);
                $user->save();
                return view('auth.login');
            }else {
                return view('person.edit-password')->with(['hint' => '2']);
            }
        } else {
            return view('person.edit-password')->with(['hint' => '1']);
        }
    }

    public function update(Request $request , $id)
    {
        $jobs = Job::where('status','up')->get();
        $user = User::where('id', $id)->first();
        //取得舊資料，要寫入log中
        $old_name = $user->name;
        $old_mobile = $user->mobile;
        $old_email = $user->email;
        $old_address = $user->address;

        if(Auth::user()->level == 0 || Auth::user()->level == 1){
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
            $user->job_id = $request->job_id;
            if(!empty($user->birthday)){//判斷生日值再不再，代表員工是否有填寫
                $user->state = 0; //用戶只能修改第一次,第一次修改後 只能透過人資去修改，所以狀態是0
            }
            $user->status = $request->status;
            $user->level = $request->level;
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
        }
        return view('user.edit')->with('user', $user)
                                    ->with('hint','1')
                                    ->with('jobs',$jobs);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function check()
    {
        $datas = UserLog::where('type','edit')->get();
        return view('user.check_user')->with('datas',$datas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkdata(Request $request , $id)
    {
        $user = User::where('id', $id)->first();
        //user的狀態改為0 代表編輯畫面出來
        $user->state = 0;
        $user->save();

        //user_log的type改成完成
        $user_log = UserLog::where('user_id', $id)->first();
        // dd($user_log);

        $user_log->type = 'complete';
        $user_log->save();

        return redirect()->route('users-check');
    }
}
