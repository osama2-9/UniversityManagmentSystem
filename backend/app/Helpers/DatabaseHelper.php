<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;


class DatabaseHelper {
    public static function isDatabaseConnected(){
        try {
            DB::connection()->getPdo();
            return true;

        } catch (\Exception $th) {
            return false;

        }
    }
}
