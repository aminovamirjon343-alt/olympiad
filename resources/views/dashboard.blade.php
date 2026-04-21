
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Добро пожаловать, {{ Auth::user()->name }}!</h3>
                    <p>Ваша роль: <span class="badge bg-blue-500">{{ Auth::user()->role }}</span></p>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-100 p-4 rounded shadow">Мои баллы: 0</div>
                        <div class="bg-green-100 p-4 rounded shadow">Активные тесты: 5</div>
                        <div class="bg-yellow-100 p-4 rounded shadow">Уведомления: 2</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
