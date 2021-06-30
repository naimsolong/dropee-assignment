<?php

namespace App\Http\Controllers;

use App\Custom\RSP;
use Illuminate\Http\Request;

use App\Models;

class HomeController extends Controller
{
    function home() {
        return RSP::view([
            'view_name' => 'home',
        ]);
    }

    function sentence($email) {
        $user = Models\User::where('email', $email)->first();
        $setting = $user->setting()->first();
        $total_row = $setting->row;
        $total_column = $setting->column;
        $sentences = $user->sentences()->get();

        $row_array = [];            
        for ($i = 1; $i <= $total_row; $i++) {
            unset($column_array);
            $column_array = [];
            for ($j = 1; $j <= $total_column; $j++) {
                foreach($sentences as $sentence) {
                    $found = false;
                    if($sentence->row == $i && $sentence->column == $j) {
                        array_push($column_array, $sentence);
                        $found = true;
                        break;
                    }
                }
                if($found == false) {
                    array_push($column_array, false);
                }
                if($j == $total_column)
                    array_push($row_array, $column_array);
            }
        }
        
        return RSP::view([
            'view_name' => 'sentences',
            'compact' => [
                'total_row' => $total_row,
                'total_column' => $total_column,
                'sentences' => $row_array
            ]
        ]);
    }
}
