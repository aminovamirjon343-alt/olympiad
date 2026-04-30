<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;

class SearchController extends Controller
{
    /**
     * Выполняет глобальный поиск по пользователям и документам.
     */
    public function index(Request $request)
    {
        // Очищаем запрос от лишних пробелов по краям
        $query = trim($request->input('query'));

        // Если запрос пустой, возвращаем пустые коллекции
        if (empty($query)) {
            return view('search.results', [
                'users' => collect(),
                'documents' => collect(),
                'query' => ''
            ]);
        }

        // Поиск по пользователям: имя или почта
        // Используем импортированный класс User
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->take(15)
            ->get();

        // Поиск по документам: заголовок
        // Используем импортированный класс Document
        $documents = Document::where('title', 'LIKE', "%{$query}%")
            ->take(15)
            ->get();

        // Передаем данные в твой красивый шаблон на Tailwind
        return view('search.results', compact('users', 'documents', 'query'));
    }
}
