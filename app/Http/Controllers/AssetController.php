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
                    ->select('wtxusers.full_name_eng', 'brands.brand', DB::raw('count(*) as total'))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->groupBy('wtxusers.full_name_eng', 'brands.brand')
                    ->get()
                    ->flatten();
                break;

            case 'dept':
                $info = DB::table('record_lists')
                    ->select('departments.department', 'brands.brand', DB::raw('count(*) as total'))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('departments', 'departments.id', '=', 'wtxusers.department_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->groupBy('departments.department', 'brands.brand')
                    ->get();
                break;

            case 'type':
                $info = DB::table('record_lists')
                    ->select('types.type', 'departments.department', DB::raw('count(*) as total'))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('departments', 'departments.id', '=', 'wtxusers.department_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('types', 'types.id', '=', 'assets.type_id')
                    ->groupBy('types.type', 'departments.department')
                    ->get();
                break;

            case 'brand':
                $info = DB::table('record_lists')
                    ->select('brands.brand', 'assets.model_no', DB::raw('count(*) as total'))
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->groupBy('brands.brand', 'assets.model_no')
                    ->get();
                break;

            default:
                # code...
                break;
        }
        return $info;
    }
}
