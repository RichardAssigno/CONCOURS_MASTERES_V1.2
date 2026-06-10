<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ResultatsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('admisconcoursidsi', function (Blueprint $table): void {
            $table->id();
            $table->string('matricule')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenoms')->nullable();
            $table->string('genre', 2)->nullable();
            $table->string('concours')->nullable();
            $table->string('annee')->nullable();
        });
    }

    public function test_results_page_is_public_and_only_contains_the_requested_year(): void
    {
        DB::table('admisconcoursidsi')->insert([
            [
                'matricule' => 'CM20260001',
                'nom' => 'KOUASSI',
                'prenoms' => 'Awa',
                'genre' => 'F',
                'concours' => 'Cycle ingénieur',
                'annee' => '2026-2027',
            ],
            [
                'matricule' => 'CM20250001',
                'nom' => 'YAO',
                'prenoms' => 'Jean',
                'genre' => 'M',
                'concours' => 'Cycle ingénieur',
                'annee' => '2025-2026',
            ],
            [
                'matricule' => 'CM20260002',
                'nom' => 'TRAORE',
                'prenoms' => 'Mariam',
                'genre' => 'F',
                'concours' => 'MASTER EN SECURITE, CYBERSECURITE ET INTELLIGENCE ARTIFICIELLE',
                'annee' => '2026-2027',
            ],
        ]);

        $response = $this->get(route('resultats.index'));

        $response
            ->assertOk()
            ->assertSee('CM20260001')
            ->assertSee('CM20260002')
            ->assertSee('MASTER EN SECURITE, CYBERSECURITE ET INTELLIGENCE ARTIFICIELLE')
            ->assertDontSee('CM20250001')
            ->assertSee('const ADMIS_2026_2027', false);
    }

    public function test_each_page_request_reads_the_current_database_contents(): void
    {
        DB::table('admisconcoursidsi')->insert([
            'matricule' => 'CM20260002',
            'nom' => 'KOFFI',
            'prenoms' => 'Nadia',
            'genre' => 'F',
            'concours' => 'Mastère',
            'annee' => '2026-2027',
        ]);

        $firstResponse = $this->get(route('resultats.index'));

        $firstResponse
            ->assertOk()
            ->assertSee('CM20260002')
            ->assertDontSee('CM20260003');

        DB::table('admisconcoursidsi')->insert([
            'matricule' => 'CM20260003',
            'nom' => 'YAO',
            'prenoms' => 'Armand',
            'genre' => 'M',
            'concours' => 'Mastère',
            'annee' => '2026-2027',
        ]);

        $this->get(route('resultats.index'))
            ->assertOk()
            ->assertSee('CM20260002')
            ->assertSee('CM20260003');
    }
}
