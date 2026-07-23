<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| LOGIN PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
});

/*
|--------------------------------------------------------------------------
| LOGIN FUNCTION
|--------------------------------------------------------------------------
*/

Route::post('/login', function (Request $request) {

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = DB::table('users')
        ->where('email', $request->email)
        ->first();

    if (!$user) {
        return back()->with('error', 'Email not found.');
    }

    if (!Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Wrong password.');
    }

    Session::put('user_id', $user->id);
    Session::put('name', $user->name);
    Session::put('role', $user->role ?? 'employee');

    if (($user->role ?? 'employee') === 'admin') {
        return redirect('/dashboard');
    }

    return redirect('/user/dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    if (!Session::has('user_id')) {
        return redirect('/login');
    }

    if (Session::get('role') !== 'admin') {
        return redirect('/user/dashboard');
    }

    $files = DB::table('uploaded_files')
        ->latest()
        ->get();

    return view('dashboard', compact('files'));
});

/*
|--------------------------------------------------------------------------
| USER DASHBOARD - PREVIEW ONLY
|--------------------------------------------------------------------------
*/

Route::get('/user/dashboard', function () {

    if (!Session::has('user_id')) {
        return redirect('/login');
    }

    if (Session::get('role') === 'admin') {
        return redirect('/dashboard');
    }

    $files = DB::table('uploaded_files')
        ->latest()
        ->get();

    return view('user_dashboard', compact('files'));
});

/*
|--------------------------------------------------------------------------
| UPLOAD FILE - ADMIN ONLY
|--------------------------------------------------------------------------
*/

Route::post('/upload', function (Request $request) {

    if (!Session::has('user_id')) {
        return redirect('/login');
    }

    if (Session::get('role') !== 'admin') {
        return redirect('/user/dashboard');
    }

    $request->validate([
        'file' => 'required|file|max:20480',
    ]);

    $file = $request->file('file');
    $path = $file->store('uploads', 'public');

    DB::table('uploaded_files')->insert([
        'user_id' => Session::get('user_id'),
        'original_name' => $file->getClientOriginalName(),
        'file_path' => $path,
        'file_type' => $file->getClientMimeType(),
        'file_size' => $file->getSize(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', 'File uploaded successfully.');
});

/*
|--------------------------------------------------------------------------
| DOWNLOAD FILE - ADMIN ONLY
|--------------------------------------------------------------------------
*/

Route::get('/download/{id}', function ($id) {

    if (!Session::has('user_id')) {
        return redirect('/login');
    }

    if (Session::get('role') !== 'admin') {
        return redirect('/user/dashboard');
    }

    $file = DB::table('uploaded_files')
        ->where('id', $id)
        ->first();

    if (!$file) {
        abort(404);
    }

    return response()->download(
        storage_path('app/public/' . $file->file_path),
        $file->original_name
    );
});

/*
|--------------------------------------------------------------------------
| DELETE FILE - ADMIN ONLY
|--------------------------------------------------------------------------
*/

Route::post('/delete-file/{id}', function ($id) {

    if (!Session::has('user_id')) {
        return redirect('/login');
    }

    if (Session::get('role') !== 'admin') {
        return redirect('/user/dashboard');
    }

    $file = DB::table('uploaded_files')
        ->where('id', $id)
        ->first();

    if ($file) {
        Storage::disk('public')->delete($file->file_path);

        DB::table('uploaded_files')
            ->where('id', $id)
            ->delete();
    }

    return back()->with('success', 'File deleted successfully.');
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/logout', function () {
    Session::flush();

    return redirect('/login');
});