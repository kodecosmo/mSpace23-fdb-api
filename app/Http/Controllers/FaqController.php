<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(){

        try {
            
            $faqs = Faq::all();

            return response()->json([
                'success' => true,
                "message" => "all:faqs",
                'data' => $faqs,
            ]);
        } catch (\Throwable $th) {
            
            return response()->json([
                'success' => false,
                'message' => 'unexpected error occured',
            ]);
        }

    }

    public function paginate(){

        try {
                
            $faqs = Faq::paginate();

            return response()->json([
                'success' => true,
                "message" => "paginate:faqs",
                'data' => $faqs,
            ]);
        } catch (\Throwable $th) {
            
            return response()->json([
                'success' => false,
                'message' => 'unexpected error occured',
            ]);
        }
    }
}
