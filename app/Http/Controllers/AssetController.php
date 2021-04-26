<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function user($groupBy) {
        switch ($groupBy) {
            case 'user':
                $info = DB::table('record_lists')
                    ->select('wtxuser_id', DB::raw('count(*) as total'))
                    ->groupBy('wtxuser_id')
                    ->get();
                break;

            default:
                # code...
                break;
        }
        return $info;
    }
}
