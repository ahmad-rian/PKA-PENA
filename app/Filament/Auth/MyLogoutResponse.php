<?php

namespace App\Filament\Auth;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as Responsable;

class MyLogoutResponse implements Responsable
{
    public function toResponse($request)
    {
        return redirect()->route('filament.admin.auth.login');
    }
}
