<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use Carbon\Carbon;
use App\Models\GdpaperInventoryData;
use App\Models\GdpaperInventoryItem;
use App\Models\IncomeData;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('price','desc')->where('status','up')->get();

        $datas = GdpaperInventoryData::orderby('id','desc');
        if($request)
        {
          $after_date = $request->after_date;
          if($after_date){
            $datas = $datas->where('date','>=',$after_date);
          }
          $before_date = $request->before_date;
          if($before_date){
            $datas = $datas->where('date','<=',$before_date);
          }
          $user_id = $request->user_id;
          if ($user_id != "null") {
            if (isset($user_id)) {
                $datas = $datas->where('update_user_id', $user_id);
            } else {
                $datas = $datas;
            }
          }
          $state = $request->state;
          if (isset($state)) {
              $datas = $datas->where('state', $state);
          } else {
              $datas = $datas->where('state', '0');
          }
          $datas = $datas->get();
        }else{
          $datas = $datas->get();
        }

        $users = User::where('status','0')->orderby('job_id','desc')->get();
        return view('inventory.index')->with('products', $products)->with('datas',$datas)->with('request',$request)->with('users',$users);
    }

    public function create(Request $request)
    {
        $categorys = Category::where('status','up')->get();
        $users = User::where('status','0')->orderby('job_id','desc')->get();
        // dd($users);

        return view('inventory.create')->with('users',$users)->with('categorys',$categorys);
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
        $InventoryData->type = $request->category_id;
        $InventoryData->date = Carbon::now()->locale('zh-tw')->format('Y-m-d');
        $InventoryData->state = 0;
        $InventoryData->created_user_id = Auth::user()->id;
        $InventoryData->update_user_id = $request->update_user_id;
        $InventoryData->save();


        if($request->category_id == 'all'){
          $products = Product::orderBy('price','desc')->where('stock','1')->where('status','up')->get();
        }else{
          $products = Product::orderBy('price','desc')->where('category_id',$request->category_id)->where('stock','1')->where('status','up')->get();
        }

        // dd($products);

        if($InventoryData->type){
          foreach($products as $product)
          {
            //查詢舊庫存
            $Old_GdpaperInventoryItem = GdpaperInventoryItem::where('product_id',$product->id)->where('type',$InventoryData->type)->orderby('gdpaper_inventory_id','desc')->first();
            
            $productInventoryItem = new GdpaperInventoryItem;
            $productInventoryItem->gdpaper_inventory_id = $inventory_no;
            $productInventoryItem->product_id = $product->id;
            $productInventoryItem->type = $request->category_id;
            // dd($Old_GdpaperInventoryItem);
            if(!isset($Old_GdpaperInventoryItem)){
              $productInventoryItem->old_num = 0;
            }else{
              $productInventoryItem->old_num = $Old_GdpaperInventoryItem->new_num;
            }
            $productInventoryItem->new_num = null;
            $productInventoryItem->save();
          }
        }
        

        // $InventoryData->state = 0 預設（未修改）


        return redirect()->route('product.inventorys');
    }


    public function delete($id , Request $request)
    {
      $categorys = Category::where('status','up')->get();
      $users = User::where('status','0')->orderby('job_id','desc')->get();
      $data = GdpaperInventoryData::where('id',$id)->first();
      return view('inventory.del')->with('data',$data)->with('categorys',$categorys)->with('users',$users);
    }

    public function destroy($id)
    {
      $data = GdpaperInventoryData::where('id',$id)->first();

      $items = GdpaperInventoryItem::where('gdpaper_inventory_id',$data->inventory_no)->get();
      foreach($items as $item)
      {
        $item->delete();
      }
      $data->delete();
      
      return redirect()->route('product.inventorys');
    }

    //盤點細項
    public function inventoryItem_index(Request $request , $product_inventory_id)
    {
        $inventory_no = $product_inventory_id;
        $datas = GdpaperInventoryItem::where('gdpaper_inventory_id',$product_inventory_id)->get();
        return view('inventory.item')->with('datas',$datas)->with('inventory_no',$inventory_no);
    }

    public function inventoryItem_edit(Request $request , $product_inventory_id)
    {
        $inventory_data = GdpaperInventoryData::orderby('inventory_no','desc')->where('inventory_no',$product_inventory_id)->first();
        $datas = GdpaperInventoryItem::where('gdpaper_inventory_id',$product_inventory_id)->get();

          foreach($datas as $data)
          {
            $i = $data->product_id;
            // dd($request->product);
            $data->new_num = $request->product[$data->product_id];
            $data->comment = $request->comment[$data->product_id];
            $data->save();
          }
        // dd($inventory_data);
        //盤點狀況改為1 已盤點
        $inventory_data->state = 1;
        $inventory_data->save();

        if(Auth::user()->level != 2){
          return redirect()->route('product.inventorys');
        }else{
          return redirect()->route('person.inventory');
        }
    }


}
