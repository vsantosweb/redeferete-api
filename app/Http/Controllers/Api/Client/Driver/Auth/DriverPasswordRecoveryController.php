<?php

namespace App\Http\Controllers\Api\Client\Driver\Auth;

use App\Http\Controllers\Controller;
use App\Models\Driver\Driver;
use App\Notifications\PasswordRecovery\PasswordRecoveryNotification;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DriverPasswordRecoveryController extends Controller
{
    /**
     *  Send recovery request.
     *
     * @return Response
     */
    public function recoveryRequest()
    {
        $credentials = request()->validate(['email' => 'required|email']);

        $driver = Driver::where('email', $credentials)->firstOrfail();

        $tokenData = DB::table('password_resets')->where('email', request()->email)->first();

        if (empty($tokenData)) {
            DB::table('password_resets')->insert([
                'email'      => $driver->email,
                'token'      => Str::random(60),
                'expire_at'  => now()->addHours(2),
                'created_at' => now(),
            ]);
        }

        $tokenData = DB::table('password_resets')->where('email', request()->email)->first();

        $link = env('APP_URL_PASSWORD_RESET') . '?token=' . $tokenData->token . '&email=' . $tokenData->email;

        $driver->notify(new PasswordRecoveryNotification($driver, $link));

        return $this->outputJSON('Enviamos um link para redefinir sua senha.', [], true, 201);
    }

    public function validateRecoveryRequest()
    {
        $passwordResetData = DB::table('password_resets')->where('email', request()->email)->where('token', request()->token);
        if (!$passwordResetData->first()) {
            return $this->outputJSON([], 'Invalid token', false, 400);
        }

        return $this->outputJSON($passwordResetData->first(), '', true, 200);
    }

    public function recovery()
    {
        request()->validate([
            'email'                 => 'required|email|exists:drivers',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $passwordResetData = DB::table('password_resets')->where('email', request()->email)->where('token', request()->token);

        if (!$passwordResetData->first()) {
            return $this->outputJSON([], 'Invalid token', false, 400);
        }

        Driver::where('email', $passwordResetData->first()->email)->update(['password' => Hash::make(request()->password)]);

        return $this->outputJSON([], 'Password updated successfully', true, 200);
    }
}
