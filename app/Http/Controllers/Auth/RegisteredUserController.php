<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Roll;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {


        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $getrollid = Roll::where('slug', 'student')->first();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'age' => ['required', 'integer', 'min:1'],
            'class' => ['required', 'string', 'max:255'],
            'school' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'subjects_stream' => ['required', 'string', 'max:255'],
            'career_aspiration' => ['nullable', 'string', 'max:255'],
            'parental_occupation' => ['nullable', 'string', 'max:255'],
        ]);


        $user = User::create([
            'rolls_id' => $getrollid->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'class' => $request->class,
            'school' => $request->school,
            'location' => $request->location,
            'subjects_stream' => $request->subjects_stream,
            'career_aspiration' => $request->career_aspiration,
            'parental_occupation' => $request->parental_occupation,
        ]);


        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
