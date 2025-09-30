<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function ResponseSuccess ($data, $code){
        return response()->json([
            'flag' => 'success',
            'message' => 'this data send whit api',
            'sttatus' => $code,
            'data' => $data
        ], $code);
    }
    
    public function ResponseError ($data = "", $code = 404){
        return response()->json([
            'flag' => 'Error',
            'message' => 'this data send whit api',
            'sttatus' => $code,
            'data' => $data
        ], $code);
    }
}
