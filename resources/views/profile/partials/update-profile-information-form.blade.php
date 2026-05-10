<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">
            {{ __('Данные профиля') }}
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            {{ __("Обновите информацию вашего аккаунта и адрес электронной почты.") }}
        </p>
    </header>

    {{-- Форма для верификации (скрытая) --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        {{-- Имя --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Имя</label>
            <input id="name" name="name" type="text"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                   value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-xs text-red-500" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
            <input id="email" name="email" type="email"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                   value="{{ old('email', $user->email) }}"
                   required autocomplete="username" />
            <x-input-error class="mt-2 text-xs text-red-500" :messages="$errors->get('email')" />

            {{-- Блок верификации --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 border border-amber-100 rounded-xl">
                    <p class="text-sm text-amber-800">
                        {{ __('Ваш адрес электронной почты не подтвержден.') }}
                        <button form="send-verification" class="block mt-1 underline font-bold hover:text-amber-900 transition-colors">
                            {{ __('Нажмите здесь, чтобы отправить письмо снова.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 italic">
                            {{ __('Новая ссылка отправлена на ваш email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Кнопка и статус --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-95">
                {{ __('Сохранить профиль') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-emerald-600 flex items-center gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Сохранено') }}
                </p>
            @endif
        </div>
    </form>
</section>
