<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repository\OptionRepository;
use App\Repository\SettingRepository;

use App\User;

use App\Models\Setting;

use App\Notifications\PasswordChanged;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Show user account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = User::whereId(auth()->user()->id)->with(['role','usertype','settings','authentications' => function($authenticationQuery){
            $authenticationQuery->orderBy('created_at', 'desc');
        }])->firstOrFail();
        
        return (request()->expectsJson()) ? response()->json($account) : view('dashboard.account.profile', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        return view('dashboard.account.settings.index');
    }

    public function updateSettings(Request $request)
    {
        if($request->has('display_style')){
            app(OptionRepository::class)->remember(auth()->user()->id.'_display_style')->updateOrCreate(['key' => auth()->user()->id.'_display_style'], ['key' => auth()->user()->id.'_display_style','value' => $request->display_style, 'identifier' => 'account_settings']);
            session([
                'display_style' => $request->display_style
            ]);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
    
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        // Send password change notification
        $user->notify(new PasswordChanged());

        return ($request->expectsJson()) ? response()->json(['success' => true, 'message' => 'Account password changed successfully...'], 200) : back()->withInput()->with('updated', 'Account password changed successfully...');
    }

    

    /**
     * Update account photo
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required||mimes:jpeg,png,jpg|max:2048'
        ]);

        User::whereId(auth()->user()->id)->update([
            'avator' => 'storage/'.request()->photo->store('avators', 'public')
        ]);

        return ($request->expectsJson()) ? response()->json(['success' => true, 'message' => 'Photo updated successfully'], 200) : back()->withInput()->with('updated', 'Avator changed successfully');
    }
}
