<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ResultatsController extends Controller
{
    public const ANNEE = '2026-2027';

    public const CACHE_KEY = 'resultats.admis.2026-2027.v1';

    public function index(): View
    {
        $admis = Cache::store('file')->rememberForever(self::CACHE_KEY, function (): array {
            return DB::table('admisconcoursidsi')
                ->select(['matricule', 'nom', 'prenoms', 'genre', 'concours', 'annee'])
                ->where('annee', self::ANNEE)
                ->orderBy('nom')
                ->orderBy('prenoms')
                ->get()
                ->map(static fn (object $admis): array => [
                    'matricule' => (string) ($admis->matricule ?? ''),
                    'nom' => (string) ($admis->nom ?? ''),
                    'prenoms' => (string) ($admis->prenoms ?? ''),
                    'genre' => (string) ($admis->genre ?? ''),
                    'concours' => (string) ($admis->concours ?? ''),
                    'annee' => (string) ($admis->annee ?? ''),
                ])
                ->all();
        });

        return view('resultats.index', [
            'admis' => $admis,
            'annee' => self::ANNEE,
        ]);
    }
}
