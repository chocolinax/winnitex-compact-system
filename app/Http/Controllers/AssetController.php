<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function by($groupBy) {
        switch ($groupBy) {
            case 'user':
                $info = DB::table('record_lists')
                    ->select(DB::raw('count(record_lists.wtxuser_id) as total'), 'wtxuser.full_name_eng', 'brands.brand')
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->groupBy('record_lists.wtxuser_id')
                    ->get();
                break;

            default:
                # code...
                break;
        }
        return $info;
    }
}
