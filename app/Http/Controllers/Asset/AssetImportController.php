<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
//use Maatwebsite\Excel\Facades\Excel;
//use App\Imports\AssetsImport;


class AssetImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.assets.import');
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        Excel::import(new AssetsImport, request()->file('file'));
        return back()->withInput()->with('created', 'Assets imported successsfully ...');
    }


    public function downloadTemplate()
    {
        $file= public_path(). "/imports/templates/AssetsImportTemplate.xlsx";
        
        return response()->download($file, 'assetimporttemplate.xlsx');
    }

    
}
