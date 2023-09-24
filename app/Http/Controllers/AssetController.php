<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{

    public function index()
    {
        $assets = Asset::all();

        return response()->json($assets);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'asset' => ['required', 'mimes:jpg,bmp,png,jpeg,gif,svg,pdf,zip,7z,gz', 'max:5120'], // 5MB
        ]);
 
        if ($validator->fails()) {
             
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validator->errors(),
            ], 401);
        }
        
        try{

            $asset = $request->file('asset');

            $upload_path = config('assets.upload_path');
            $view_path = config('assets.view_path');
            
            $path = $asset->store($upload_path);

            $asset_file = new Asset;
            
            // location inside storage folder - 'storage/app/public/file.extension'
            $asset_file->relative_path = $path;

            // location inside public folder - 'public/assets/file.extension'. output can be 'http://localhost/assets/file.extension'
            $asset_file->complete_path = asset(str_replace($upload_path, $view_path, $path));
            
            $asset_file->save();

            return response()->json([
                'success' => true,
                'message' => 'asset uploaded',
                'data' => $asset_file,
            ]);
        } catch (\Throwable $th) {
            
            return response()->json([
                'success' => false,
                'message' => 'unexpected error occured',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function show(string $id)
    {
        $asset = Asset::find($id);

        return response()->json($asset);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
