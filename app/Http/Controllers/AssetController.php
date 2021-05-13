<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function by($groupBy) {
        switch ($groupBy) {
            case 'user':
                $subQuery = DB::table('record_lists')
                    ->select('wtxuser_id', 'assets.brand_id', DB::raw('count(*) as ttlbybrand'))
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->groupBy('wtxuser_id', 'assets.brand_id');

                $info = DB::table('record_lists')
                    ->select('wtxusers.id', 'wtxusers.full_name_eng', DB::raw("string_agg(concat(brands.brand,': ', sub.ttlbybrand), ', ') as ttlbybrand"))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->joinSub($subQuery, 'sub', function ($join) {
                        $join->on('wtxusers.id', '=', 'sub.wtxuser_id')
                            ->on('brands.id', '=', 'sub.brand_id');
                    })
                    ->groupBy('wtxusers.id', 'wtxusers.full_name_eng')
                    ->get();
                break;

            case 'dept':
                $subQuery = DB::table('record_lists')
                    ->select('wtxuser_id', 'assets.brand_id', DB::raw('count(*) as ttlbybrand'))
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->groupBy('wtxuser_id', 'assets.brand_id');

                $info = DB::table('record_lists')
                    ->select('departments.id', 'departments.department', DB::raw("string_agg(concat(brands.brand,': ', sub.ttlbybrand), ', ') as ttlbybrand"))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('departments', 'departments.id', '=', 'wtxusers.department_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->joinSub($subQuery, 'sub', function ($join) {
                        $join->on('wtxusers.id', '=', 'sub.wtxuser_id')
                            ->on('brands.id', '=', 'sub.brand_id');
                    })
                    ->groupBy('departments.id', 'departments.department')
                    ->get();
                break;

            case 'type':
                $subQuery = DB::table('record_lists')
                    ->select('wtxuser_id', 'assets.type_id', DB::raw('count(*) as ttlbydept'))
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->groupBy('wtxuser_id', 'assets.type_id');

                $info = DB::table('record_lists')
                    ->select('types.id', 'types.type', DB::raw("string_agg(concat(types.type,': ', sub.ttlbydept), ', ') as ttlbydept"))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('departments', 'departments.id', '=', 'wtxusers.department_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('types', 'types.id', '=', 'assets.type_id')
                    ->joinSub($subQuery, 'sub', function ($join) {
                        $join->on('wtxusers.id', '=', 'sub.wtxuser_id')
                            ->on('types.id', '=', 'sub.type_id');
                    })
                    ->groupBy('types.id', 'types.type')
                    ->get();
                break;

            case 'brand':
                $info = DB::table('record_lists')
                    ->select('brands.id', 'brands.brand', DB::raw("string_agg(assets.model_no, ', ') as model_no"), DB::raw('count(*) as total'))
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->groupBy('brands.id', 'brands.brand')
                    ->get();
                break;

            default:
                # code...
                break;
        }
        return $info;
    }
}
