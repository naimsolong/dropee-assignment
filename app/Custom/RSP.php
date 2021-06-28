<?php

namespace App\Custom;

use Illuminate\Support\Facades\Cookie;

// RSP stand for Response
class RSP {
    /**
     * Return variable
     */
    public static $_return;

    public static function json(array $array) {
        $array['status'] = $array['status'] ?? 200;

        $array_key = ['redirect', 'message', 'errors', 'callback', 'column', 'data'];
        $temp_array = [];

        foreach($array_key as $key) {
            if(isset($array[$key]))
                $temp_array[$key] = $array[$key];
        }

        self::$_return = response()->json($temp_array, $array['status']);

        return self::setCookies('json', $array);
    }

    public static function view(array $array) {
        $array['compact'] = $array['compact'] ?? [];

        if(count($array['compact']) > 0)
            self::$_return = view($array['view_name'], $array['compact']);
        else
            self::$_return = view($array['view_name']);
        
        return self::setCookies('view', $array);
    }

    public static function redirect(array $array) {
        $array['type'] = $array['type'] ?? '';

        self::$_return = redirect($array['url']);

        if($array['type'] == "success")
            self::$_return->with('success', $array['message']);
        elseif($array['type'] == "error")
            self::$_return->withErrors($array['message']);
        
        return self::setCookies('redirect', $array);
    }

    public static function setCookies(string $type = '', array $array) {
        $array['cookies'] = $array['cookies'] ?? [];
        
        if(count($array['cookies']) > 0) {
            switch($type) {
                case 'json':
                    self::$_return->cookie(
                        $array['cookies']['name'],
                        $array['cookies']['value'],
                        $array['cookies']['minutes'] ?? 0,
                        $array['cookies']['path'] ?? null,
                        $array['cookies']['domain'] ?? null,
                        $array['cookies']['secure'] ?? null,
                        $array['cookies']['httpOnly'] ?? true
                    );
                    break;
                default:
                    Cookie::queue(
                        $array['cookies']['name'],
                        $array['cookies']['value'],
                        $array['cookies']['minutes'] ?? 0,
                        $array['cookies']['path'] ?? null,
                        $array['cookies']['domain'] ?? null,
                        $array['cookies']['secure'] ?? null,
                        $array['cookies']['httpOnly'] ?? true
                    );
                    break;
            }
        }
        
        return self::$_return;
    }
}