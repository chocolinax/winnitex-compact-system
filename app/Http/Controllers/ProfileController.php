<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function by($groupBy, $id) {
        switch ($groupBy) {
            case 'dept':
                $info = DB::table('record_lists')
                    ->select('wtxusers.full_name_eng', 'wtxusers.ext', 'departments.department', 'departments.team', 'locations.location', 'stocktake_date')
                    ->join('wtxusers', 'wtxusers.id', '=', 'record_lists.wtxuser_id')
                    ->join('departments', 'departments.id', '=', 'wtxusers.department_id')
                    ->join('locations', 'locations.id', '=', 'record_lists.location_id')
                    ->where('departments.id', '=', $id)
                    ->groupBy('wtxusers.full_name_eng')
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
