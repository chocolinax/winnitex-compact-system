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
                    ->select('wtxusers.id', 'wtxusers.full_name_eng', DB::raw("string_agg(brands.brand, ', ') as brands"), DB::raw('count(*) as total'))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->groupBy('wtxusers.id', 'wtxusers.full_name_eng')
                    ->get();
                break;

            case 'dept':
                $info = DB::table('record_lists')
                    ->select('departments.department', DB::raw("string_agg(wtxusers.id::varchar, ', ') as id"), DB::raw("string_agg(brands.brand, ', ') as brands"), DB::raw('count(*) as total'))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('departments', 'departments.id', '=', 'wtxusers.department_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->groupBy('departments.department')
                    ->get();
                break;

            case 'type':
                $info = DB::table('record_lists')
                    ->select('types.type', DB::raw("string_agg(wtxusers.id::varchar, ', ') as id"), DB::raw("string_agg(departments.department, ', ') as departments"), DB::raw('count(*) as total'))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('departments', 'departments.id', '=', 'wtxusers.department_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('types', 'types.id', '=', 'assets.type_id')
                    ->groupBy('types.type')
                    ->get();
                break;

            case 'brand':
                $info = DB::table('record_lists')
                    ->select('brands.brand', DB::raw("string_agg(wtxusers.id::varchar, ', ') as id"), DB::raw("string_agg(assets.model_no, ', ') as model_no"), DB::raw('count(*) as total'))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->groupBy('brands.brand')
                    ->get();
                break;

            default:
                # code...
                break;
        }
        return $info;
    }
}
