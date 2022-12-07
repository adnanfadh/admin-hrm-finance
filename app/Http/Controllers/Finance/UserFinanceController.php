<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages_finance.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->all();
        
        $item = User::findOrFail($id);

        if ($request->old_password == $item->password) {
            echo "aku menang";
        }



    }

    public function changePasswordFinance(Request $request){
        if (Hash::check($request->current_password, Auth::user()->password)) {
            if(!(strcmp($request->new_password, $request->new_password_confirm) == 0 )) {
                if(!(strcmp($request->current_password, $request->new_password) == 0 )){
                    $data['password'] = Hash::make($request->new_password);
                    $item = User::findOrFail(Auth::user()->id);
                    $msg = $item->update($data);
                    return redirect()->back()->with("success","Password changed successfully !");
                }else{
                    return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
                }
            }else{
                return redirect()->back()->with("error","New Password should be same as your confirmed password. Please retype new password.");
            }
        }else{
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
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
        if (!empty($request->photo)) {
        
            $data = $request->all();

            Storage::disk('local')->delete('public/'. $request->photo2);
        
            $data['photo'] = $request->file('photo')->store('assets/dokumen/user', 'public');

            $item = User::findOrFail($id);

            $msg = $item->update($data);

            if ($msg) {
                return redirect()->route('user_finance.index')->with(['success' => 'Data Berhasil Dirubah']);
            } else {
                return redirect()->route('user_finance.index')->with(['error' => 'Data Gagal Dirubah']);
            }
        }else{
            $data = $request->all();

            $item = User::findOrFail($id);

            $msg = $item->update($data);

            if ($msg) {
                return redirect()->route('user_finance.index')->with(['success' => 'Data Berhasil Dirubah']);
            } else {
                return redirect()->route('user_finance.index')->with(['error' => 'Data Gagal Dirubah']);
            }

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
