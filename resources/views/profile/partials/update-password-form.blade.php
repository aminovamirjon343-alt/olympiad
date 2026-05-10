<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">
            {{ __('Обновление пароля') }}
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            {{ __('Используйте длинный случайный пароль, чтобы ваш аккаунт оставался в безопасности.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        {{-- Текущий пароль --}}
        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-slate-700 mb-1">
                {{ __('Текущий пароль') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                   autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs text-red-500" />
        </div>

        {{-- Новый пароль --}}
        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-slate-700 mb-1">
                {{ __('Новый пароль') }}
            </label>
            <input id="update_password_password" name="password" type="password"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs text-red-500" />
        </div>

        {{-- Подтверждение пароля --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">
                {{ __('Подтвердите пароль') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs text-red-500" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-95">
                {{ __('Сохранить изменения') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-emerald-600"
                >
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Обновлено') }}
                    </span>
                </p>
            @endif
        </div>
    </form>
</section>
