<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KeyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Generate a 32-character key used for API authentication.
     *
     * @return string
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required'
        ]);


        $data = $request->all();
        $key = Str::random(32);
        $data["created_date"] = time();
        $data["key"] = password_hash($key, PASSWORD_DEFAULT);
        DB::table('Users')->insert($data);

        // app('db')->insert("INSERT INTO users (name, email, key, created_date, enabled) VALUES(?, ?, ?, ?, ?); ", ["Steven", "ss@ss.com", $key, time(), 1]);
        return response()->json(['key' => $key]);
    }

    /**
     * Revoke access to the supplied key API key.
     */
    public function delete()
    {
        return response()->json(['key' => '']);
    }
}
