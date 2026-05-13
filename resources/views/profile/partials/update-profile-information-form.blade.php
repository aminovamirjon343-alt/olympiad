<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-slate-800" data-i18n="profileDataTitle">
            Данные профиля
        </h2>
        <p class="mt-1 text-sm text-slate-500" data-i18n="profileDataDesc">
            Обновите информацию вашего аккаунта и адрес электронной почты.
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
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1" data-i18n="labelName">Имя</label>
            <input id="name" name="name" type="text"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                   value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-xs text-red-500" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1" data-i18n="labelEmail">Email</label>
            <input id="email" name="email" type="email"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                   value="{{ old('email', $user->email) }}"
                   required autocomplete="username" />
            <x-input-error class="mt-2 text-xs text-red-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 border border-amber-100 rounded-xl">
                    <p class="text-sm text-amber-800">
                        <span data-i18n="emailUnverified">Ваш адрес электронной почты не подтвержден.</span>
                        <button form="send-verification" class="block mt-1 underline font-bold hover:text-amber-900 transition-colors" data-i18n="btnResendVerify">
                            Нажмите здесь, чтобы отправить письмо снова.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 italic" data-i18n="verifyLinkSent">
                            Новая ссылка отправлена на ваш email.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Телефон --}}
        <div class="mt-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1" data-i18n="labelPhone">Телефон</label>
            <input name="phone" type="text" id="phone" required
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none shadow-sm text-black font-bold"
                   value="{{ old('phone', $user->phone ?? '+992 ') }}"
                   placeholder="+992 00 000 0000">
            <x-input-error class="mt-2 text-xs text-red-500" :messages="$errors->get('phone')" />
        </div>

        {{-- Кнопка --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-95" data-i18n="btnSaveProfile">
                Сохранить профиль
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm font-medium text-emerald-600 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span data-i18n="statusSaved">Сохранено</span>
                </p>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const phoneInput = document.getElementById('phone');
        const form = phoneInput.closest('form');
        const prefix = '+992 ';

        const lang = localStorage.getItem('app-lang') || 'ru';
        const alerts = {
            ru: "Пожалуйста, введите номер телефона полностью (9 цифр после +992)",
            tj: "Лутфан, рақами телефонро пурра ворид кунед (9 рақам пас аз +992)",
            en: "Please enter the full phone number (9 digits after +992)"
        };

        // Логика переводов для этого блока
        const profileTranslations = {
            ru: {
                profileDataTitle: "Данные профиля",
                profileDataDesc: "Обновите информацию вашего аккаунта и адрес электронной почты.",
                labelName: "Имя",
                labelEmail: "Email",
                labelPhone: "Телефон",
                emailUnverified: "Ваш адрес электронной почты не подтвержден.",
                btnResendVerify: "Нажмите здесь, чтобы отправить письмо снова.",
                verifyLinkSent: "Новая ссылка отправлена на ваш email.",
                btnSaveProfile: "Сохранить профиль",
                statusSaved: "Сохранено"
            },
            tj: {
                profileDataTitle: "Маълумоти профил",
                profileDataDesc: "Маълумоти аккаунт ва суроғаи почтаи электронии худро навсозӣ кунед.",
                labelName: "Ном",
                labelEmail: "Email",
                labelPhone: "Телефон",
                emailUnverified: "Суроғаи почтаи электронии шумо тасдиқ нашудааст.",
                btnResendVerify: "Барои дубора фиристодани мактуб инҷоро пахш кунед.",
                verifyLinkSent: "Пайванди нав ба почтаи электронии шумо фиристода шуд.",
                btnSaveProfile: "Захираи профил",
                statusSaved: "Захира шуд"
            },
            en: {
                profileDataTitle: "Profile Information",
                profileDataDesc: "Update your account's profile information and email address.",
                labelName: "Name",
                labelEmail: "Email",
                labelPhone: "Phone",
                emailUnverified: "Your email address is unverified.",
                btnResendVerify: "Click here to re-send the verification email.",
                verifyLinkSent: "A new verification link has been sent to your email address.",
                btnSaveProfile: "Save Profile",
                statusSaved: "Saved"
            }
        };

        const t = profileTranslations[lang];

        // Применяем переводы
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (t[key]) el.textContent = t[key];
        });

        // Форматирование телефона
        phoneInput.addEventListener('input', function (e) {
            if (!e.target.value.startsWith(prefix)) e.target.value = prefix;
            let digits = e.target.value.substring(prefix.length).replace(/\D/g, '').substring(0, 9);
            let formatted = '';
            if (digits.length > 0) formatted += digits.substring(0, 2);
            if (digits.length >= 3) formatted += ' ' + digits.substring(2, 5);
            if (digits.length >= 6) formatted += ' ' + digits.substring(5, 7);
            if (digits.length >= 8) formatted += ' ' + digits.substring(7, 9);
            e.target.value = prefix + formatted;
        });

        if (form) {
            form.addEventListener('submit', function (e) {
                let digitsOnly = phoneInput.value.substring(prefix.length).replace(/\D/g, '');
                if (digitsOnly.length < 9) {
                    e.preventDefault();
                    phoneInput.style.border = '2px solid #ef4444';
                    phoneInput.focus();
                    alert(alerts[lang]);
                }
            });
        }
    });
</script>
