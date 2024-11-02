<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\SchoolInfoRepository;

use Delgont\Core\Entities\Option;

class SchoolInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = app(SchoolInfoRepository::class)->getInfo();
        return view('admin.settings.school_info', compact('schoolinfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->hasFile('school_logo')) {
            # code...
            Option::updateOrCreate(['key' => 'school_logo', 'group' => 'schoolviser_school_info'], [
                'key' => 'school_logo',
                'group' => 'schoolviser_school_info',
                'value' => 'storage/'.$request->file('school_logo')->store('logos', 'public')
            ]);
        }

        Option::updateOrCreate(['key' => 'school_name', 'group' => 'schoolviser_school_info'], [
            'key' => 'school_name',
            'group' => 'schoolviser_school_info',
            'value' => $request->school_name
        ]);

        Option::updateOrCreate(['key' => 'address', 'group' => 'schoolviser_school_info'], [
            'key' => 'address',
            'group' => 'schoolviser_school_info',
            'value' => $request->address
        ]);

        Option::updateOrCreate(['key' => 'phone', 'group' => 'schoolviser_school_info'], [
            'key' => 'phone',
            'group' => 'schoolviser_school_info',
            'value' => $request->phone
        ]);

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
