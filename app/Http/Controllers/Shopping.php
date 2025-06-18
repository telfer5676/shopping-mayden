<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Items;

class Shopping extends Controller
{

    public $items = [];

    public function __construct() {
        $this->items = Items::where('user_id', Auth::id())->orderBy('order')->get();
    }

    public static function add($order, $name, $price) {
        $item = Items::create([
            'user_id' => Auth::id(),
            'order' => $order,
            'name' => $name,
            'price' => $price,
            'complete' => false
        ]);
    }

    public static function complete($id) {
        $item = Items::find($id);

        if($item->user_id == Auth::id()){
            $item->complete = true;
            $item->save();
        }
    }

    public static function delete($id) {
        $item = Items::find($id);

        if($item->user_id == Auth::id()){
            $item->delete();
        }
    }

    public static function order($ids) {
        $order = 0;
        foreach ($ids as $id) {
            $item = Items::find($id);

            if($item->user_id == Auth::id()){
                $order++;
                $item->order = $order;
                $item->save();
            }
        }
    }

    public function listItems() {
        $arr = [];
        foreach ($this->items as $item) {
            if(!$item->complete) $arr[] = $item;
        }
        return $arr;
    }

    public function listComplete() {
        $arr = [];
        foreach ($this->items as $item) {
            if($item->complete) $arr[] = $item;
        }
        return $arr;
    }

    public function count()
    {
        return $this->items->count();
    }

    public function countItems()
    {
        $items = $this->listItems();

        return count($items);
    }

    public function countComplete()
    {
        $items = $this->listComplete();

        return count($items);
    }

    public function total() {
        $total = DB::table('items')
            ->selectRaw('SUM(price) as total')
            ->where('user_id', Auth::id())
            ->where('deleted_at', null)
            ->first();

        if($total->total) return number_format($total->total, 2);

        return 0;
    }

    public function difference($budget) {
        $total = $this->total();
        $difference = ($budget - $total);

        return number_format($difference, 2);
    }
}
