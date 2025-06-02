<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WineController;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

// Authentification
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Forgot Password
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return response()->json(['status' => $status]);

})->middleware('guest')->name('password.email');


Route::post('/reset-password', function (Request $request) {

    $request->validate([
        'email' => 'required|email',
        'token' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);

    $record = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->first();

    if (!$record) {
        return response()->json(['message' => 'Invalid email or token.'], 404);
    }

    $isValid = Hash::check($request->token, $record->token);

    if (!$isValid) {
        return response()->json(['message' => 'Invalid token.'], 401);
    }

    // Cambiar la contraseña
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    // Eliminar el token de la base de datos
    DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    return response()->json(['message' => 'Password updated successfully.']);
});


// Wines
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wines', [WineController::class, 'index']);
    Route::get('/wines/{id}', [WineController::class, 'find']);
    Route::post('/wines', [WineController::class, 'store']);
    Route::put('/wines/{id}', [WineController::class, 'update']);
    Route::delete('/wines/{id}', [WineController::class, 'destroy']);
});
