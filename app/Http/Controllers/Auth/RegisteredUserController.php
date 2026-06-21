<?php
//
//namespace App\Http\Controllers\Auth;
//
//use App\Http\Controllers\Controller;
//use App\Models\User;
//use Illuminate\Auth\Events\Registered;
//use Illuminate\Http\RedirectResponse;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Validation\Rules;
//use Illuminate\Validation\ValidationException;
//use Illuminate\View\View;
//
//class RegisteredUserController extends Controller
//{
//    /**
//     * Display the registration view.
//     */
//    public function create(): View
//    {
//        return view('auth.register');
//    }
//
//    /**
//     * Handle an incoming registration request.
//     *
//     * @throws ValidationException
//     */
//    public function store(Request $request): RedirectResponse
//    {
//        // 1. Добавляем валидацию для поля 'role'
//        $request->validate([
//            'name' => ['required', 'string', 'max:255'],
//            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
//            'password' => ['required', 'confirmed', Rules\Password::defaults()],
//            'role' => ['required', 'string', 'in:admin,employee,director,user'], // Проверяем, что пришло значение из твоего enum
//        ]);
//
//        // 2. Сохраняем роль в базу данных
//        $user = User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//            'role' => $request->role, // <- ВОТ ЭТОГО НЕ ХВАТАЛО!
//        ]);
//
//        event(new Registered($user));
//
//        Auth::login($user);
//
//        return redirect(route('dashboard', absolute: false));
//    }
//}


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\Company;

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
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,employee,director,user'],
        ]);

        // Создаём компанию для нового пользователя
        $companyName = $request->name . "'s Team";

        $company = Company::create([
            'name' => $companyName,
            'owner_id' => null,
        ]);

        // Создаём пользователя как админа своей компании (level=1)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'level' => 1,
            'company_id' => $company->id,
            'company' => $companyName,
            'created_by' => null,
        ]);

        $company->update([
            'owner_id' => $user->id,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
