<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models;

use App\Custom\RSP;
use Illuminate\Database\Eloquent\Model;

class ApiController extends Controller
{
    function get_all(Request $request) {
        $user_id = $request->user()->id;
        $sentences = Models\Sentence::where('user_id', $user_id)->get();
        $setting = Models\Setting::where('user_id', $user_id)->first();

        return RSP::json([
            "data" => [
                "total_row" => $setting->row,
                "total_column" => $setting->column,
                "sentences" => $sentences->toArray()
            ]
        ]);
    }

    function save_setting(Request $request) {
        if($request->user()->setting()->update([
            "row" => $request->row,
            "column" => $request->column,
        ])) {
            return RSP::json([
                "message" => "Success!",
            ]);
        } else {
            return RSP::json([
                "message" => "Fail!",
            ]);
        }
        
    }

    function save_sentence(Request $request, $id = null) {
        if(Models\Sentence::where('row', $request->row)->where('column', $request->column)->count() > 0) {
            return RSP::json([
                "message" => "Fail! The cell already occupied",
            ]);
        }

        if($id != null) {
            if($request->user()->sentences()->where('id', $id)->update([
                "value" => $request->value,
                "row" => $request->row,
                "column" => $request->column,
                "text_color" => $request->text_color,
                "background_color" => $request->background_color,
            ])) {
                return RSP::json([
                    "message" => "Success!",
                ]);
            }
        } else {
            if($request->user()->sentences()->save(
                new Models\Sentence([
                    "value" => $request->value,
                    "row" => $request->row,
                    "column" => $request->column,
                    "text_color" => $request->text_color,
                    "background_color" => $request->background_color,
                ])
            )) {
                $request->user()->refresh();
                return RSP::json([
                    "message" => "Success!",
                    "data" => $request->user()->sentences()->get()->toArray()
                ]);
            }
        }

        return RSP::json([
            "message" => "Fail!",
        ]);
    }

    function delete_sentence(Request $request, $id) {
        if($request->user()->sentences()->where('id', $id)->delete()) {
            return RSP::json([
                "message" => "Success!",
            ]);
        } else {
            return RSP::json([
                "message" => "Fail!",
            ]);
        }
    }
}
