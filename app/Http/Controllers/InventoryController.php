<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gdpaper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use Carbon\Carbon;
use App\Models\GdpaperInventoryData;
use App\Models\GdpaperInventoryItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class InventoryController extends Controller
{
    public function inventory(Request $request)
    {
        $gdpapers = Gdpaper::orderBy('price','desc')->where('status','up')->get();
        $datas = GdpaperInventoryData::orderby('id','desc')->get();
        return view('inventory.inventory')->with('gdpapers', $gdpapers)->with('datas',$datas);
    }

    public function person_inventory(Request $request)
    {
        $gdpapers = Gdpaper::orderBy('price','desc')->where('status','up')->get();
        $datas = GdpaperInventoryData::where('update_user_id',Auth::user()->id)->where('state',0)->get();
        return view('inventory.person_inventory')->with('datas',$datas);
    }


    public function create(Request $request)
    {
        
        $users = User::where('status','0')->orderby('job_id','desc')->get();
        // dd($users);

        return view('inventory.new_inventory')->with('users',$users);
    }

    public function store(Request $request)
    {
        //建立單號
        //只取日期當數字
        $today = date('Y-m-d', strtotime(Carbon::now()->locale('zh-tw')));
        $today = explode("-",$today);
        $today = $today[0].$today[1].$today[2];
        $inventory_no = '';
        //查詢是否當日有無單號
        $data = GdpaperInventoryData::orderby('inventory_no','desc')->where('inventory_no','like',$today.'%')->first();
        // dd(substr($data->inventory_no,8,2));
        // dd($data);
        //單號自動計算
        if(!isset($data->inventory_no)){
          $i = 0;
        }else{
            //2023022201
            if(substr($data->inventory_no,8,1) != 0){
              $i = intval(substr($data->inventory_no,8,2));
            }else{
              $i = intval(str_replace(0, '', substr($data->inventory_no,8,2)));
            }
        }

        $i = $i+1;

        if($i <= 9){
            $inventory_no = $today.'0'.$i;
          }else{
            $inventory_no = $today.$i;
        }


        $InventoryData = new GdpaperInventoryData;
        $InventoryData->inventory_no = $inventory_no;
        $InventoryData->type = $request->type;
        $InventoryData->date = Carbon::now()->locale('zh-tw')->format('Y-m-d');
        $InventoryData->state = 0;
        $InventoryData->created_user_id = Auth::user()->id;
        $InventoryData->update_user_id = $request->update_user_id;
        $InventoryData->save();

        $gdpapers = Gdpaper::orderBy('price','desc')->where('status','up')->get();

        // dd($gdpapers);

        if($InventoryData->type == 'gd_paper'){
          foreach($gdpapers as $gdpaper)
          {
            //查詢舊庫存
            $Old_GdpaperInventoryItem = GdpaperInventoryItem::where('product_id',$gdpaper->id)->where('type',$InventoryData->type)->orderby('gdpaper_inventory_id','desc')->first();
            
            $GdpaperInventoryItem = new GdpaperInventoryItem;
            $GdpaperInventoryItem->gdpaper_inventory_id = $inventory_no;
            $GdpaperInventoryItem->product_id = $gdpaper->id;
            $GdpaperInventoryItem->type = $request->type;
            // dd($Old_GdpaperInventoryItem);
            if(!isset($Old_GdpaperInventoryItem)){
              $GdpaperInventoryItem->old_num = 0;
            }else{
              $GdpaperInventoryItem->old_num = $Old_GdpaperInventoryItem->new_num;
            }
            $GdpaperInventoryItem->new_num = null;
            $GdpaperInventoryItem->save();
          }
        }
        

        // $InventoryData->state = 0 預設（未修改）


        return redirect()->route('inventory');
    }

    //盤點細項
    public function gdpaper_inventoryItem(Request $request ,$type , $gdpaper_inventory_id)
    {
        $datas = GdpaperInventoryItem::where('type',$type)->where('gdpaper_inventory_id',$gdpaper_inventory_id)->get();
        return view('inventory.gdpaper_inventoryItem')->with('datas',$datas)->with('type',$type)->with('gdpaper_inventory_id',$gdpaper_inventory_id);
    }

    public function inventoryItem_edit(Request $request ,$type , $gdpaper_inventory_id)
    {
        $inventory_data = GdpaperInventoryData::orderby('inventory_no','desc')->where('inventory_no',$gdpaper_inventory_id)->first();
        $datas = GdpaperInventoryItem::where('type',$type)->where('gdpaper_inventory_id',$gdpaper_inventory_id)->get();
        if($type == 'gd_paper')
        {
          foreach($datas as $data)
          {
            $i = $data->product_id;
            // dd($request->product);

            $data->new_num = $request->product[$data->product_id];
            $data->comment = $request->comment[$data->product_id];
            $data->save();
          }
        }
        // dd($inventory_data);
        //盤點狀況改為1 已盤點
        $inventory_data->state = 1;
        $inventory_data->save();
        if(Auth::user()->level != 2){
          return redirect()->route('inventory');
        }else{
          return redirect()->route('person.inventory');
        }
    }


}
