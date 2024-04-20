<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class SignUpController extends Controller
{
    public function page(): Factory|View|Application|RedirectResponse
    {

        return view('auth.sign-up');
    }

    public function handle(SignInFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        // TODO make DTOs
        $action(
            $request->get('name'),
            $request->get('email'),
            $request->get('password'),
        );

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'));

    }
}
