<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
// ИСПОЛЬЗУЙ СВОЮ МОДЕЛЬ ТУТ:
use App\Models\DocumentSignature as Signature;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('query'));

        if (empty($query)) {
            $results = collect();
            return view('search.results', compact('results', 'query'));
        }

        // 1. Поиск по пользователям
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();

        // 2. Поиск по документам
        $documents = Document::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->get();

        // 3. Поиск по подписям (DocumentSignature)
        $signatures = Signature::with(['document', 'user'])
            ->where('id', 'LIKE', "%{$query}%")
            ->orWhereHas('document', function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%");
            })
            ->get();

        // Объединяем всё в одну коллекцию для единой таблицы
        $results = collect()
            ->concat($users)
            ->concat($documents)
            ->concat($signatures)
            ->sortByDesc('created_at');

        return view('search.results', compact('results', 'query'));
    }
}
