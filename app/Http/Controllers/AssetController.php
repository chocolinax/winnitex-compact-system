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
                    ->select('wtxusers.department_id', 'assets.brand_id', DB::raw('count(*) as ttlbybrand'))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('departments', 'departments.id', '=', 'wtxusers.department_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->groupBy('wtxusers.department_id', 'assets.brand_id');

                $info = DB::table('record_lists')
                    ->select('departments.id', 'departments.department', DB::raw("string_agg(concat(brands.brand,': ', sub.ttlbybrand), ', ') as ttlbybrand"))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('departments', 'departments.id', '=', 'wtxusers.department_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->joinSub($subQuery, 'sub', function ($join) {
                        $join->on('departments.id', '=', 'sub.department_id')
                            ->on('brands.id', '=', 'sub.brand_id');
                    })
                    ->groupBy('departments.id', 'departments.department')
                    ->get();
                break;

            case 'type':
                $subQuery = DB::table('record_lists')
                    ->select('assets.type_id', 'wtxusers.department_id', DB::raw('count(*) as ttlbydept'))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('types', 'types.id', '=', 'assets.type_id')
                    ->groupBy('assets.type_id', 'wtxusers.department_id');

                $info = DB::table('record_lists')
                    ->select('types.id', 'types.type', DB::raw("string_agg(concat(departments.department,': ', sub.ttlbydept), ', ') as ttlbydept"))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('departments', 'departments.id', '=', 'wtxusers.department_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('types', 'types.id', '=', 'assets.type_id')
                    ->joinSub($subQuery, 'sub', function ($join) {
                        $join->on('types.id', '=', 'sub.type_id')
                            ->on('departments.id', '=', 'sub.department_id');
                    })
                    ->groupBy('types.id', 'types.type')
                    ->get();
                break;

            case 'brand':
                $subQuery = DB::table('record_lists')
                    ->select('assets.brand_id', 'wtxusers.department_id', DB::raw('count(*) as ttlbydept'))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->groupBy('assets.brand_id', 'wtxusers.department_id');

                $info = DB::table('record_lists')
                    ->select('brands.id', 'brands.brand', 'departments.department', DB::raw("string_agg(concat(departments.department,': ', sub.ttlbydept), ', ') as model_no"))
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('departments', 'departments.id', '=', 'wtxusers.department_id')
                    ->join('assets', 'assets.id', '=', 'record_lists.asset_id')
                    ->join('brands', 'brands.id', '=', 'assets.brand_id')
                    ->joinSub($subQuery, 'sub', function ($join) {
                        $join->on('brands.id', '=', 'sub.brand_id')
                            ->on('departments.id', '=', 'sub.department_id');
                    })
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
