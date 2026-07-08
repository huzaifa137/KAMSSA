<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public static function totalRows($table, $column="", $column_value=""){

        if(empty($column))
			$sql = ("SELECT * FROM $table");
		else
			$sql = ("SELECT * FROM $table WHERE $column = '$column_value'");

		$row = DB::select($sql);

		return count($row);
	}

	public static function rgf($table, $id, $look_up, $column){

		$sql = "SELECT $column FROM $table WHERE $look_up = '$id' ";
		$row = DB::select($sql);

        if (count($row) > 0) {
            if (property_exists($row[0], $column)) {
                return $row[0]->{$column};
            } else {
                return 'Column not found in the result';
            }
        }
	}

}
