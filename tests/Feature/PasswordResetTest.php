<?php

namespace Tests\Feature;

use App\Models\Personne;
use App\Notifications\ReinitialisationMotDePasse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('personnes', function (Blueprint $table): void {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function test_candidate_can_request_a_password_reset_link(): void
    {
        Notification::fake();

        $personne = Personne::query()->create([
            'email' => 'candidat@example.com',
            'password' => Hash::make('ancien-mot-de-passe'),
        ]);

        $response = $this->post(route('password.email'), [
            'email' => $personne->email,
        ]);

        $response->assertSessionHas('status');
        Notification::assertSentTo($personne, ReinitialisationMotDePasse::class);
        $this->assertDatabaseHas('password_reset_tokens', ['email' => $personne->email]);
    }

    public function test_candidate_can_reset_their_password_with_a_valid_token(): void
    {
        $personne = Personne::query()->create([
            'email' => 'candidat@example.com',
            'password' => Hash::make('ancien-mot-de-passe'),
        ]);
        $token = Password::broker('personnes')->createToken($personne);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $personne->email,
            'password' => 'nouveau-mot-de-passe',
            'password_confirmation' => 'nouveau-mot-de-passe',
        ]);

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHas('succes');
        $this->assertTrue(Hash::check(
            'nouveau-mot-de-passe',
            $personne->fresh()->password
        ));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $personne->email]);
    }

    public function test_reset_request_rejects_unknown_email_addresses(): void
    {
        Notification::fake();

        $response = $this->post(route('password.email'), [
            'email' => 'inconnu@example.com',
        ]);

        $response
            ->assertSessionHasErrors([
                'email' => 'Cette adresse email n’est associée à aucun compte. Vous n’êtes pas encore inscrit.',
            ])
            ->assertSessionMissing('status');
        Notification::assertNothingSent();
    }

    public function test_password_reset_pages_include_submission_loaders(): void
    {
        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('data-submit-loader="Envoi du lien de réinitialisation..."', false);

        $this->get(route('password.reset', [
            'token' => 'test-token',
            'email' => 'candidat@example.com',
        ]))
            ->assertOk()
            ->assertSee('data-submit-loader="Réinitialisation du mot de passe..."', false);
    }

    public function test_password_reset_email_uses_a_text_header_without_logo(): void
    {
        $personne = new Personne([
            'email' => 'candidat@example.com',
        ]);

        $html = (string) (new ReinitialisationMotDePasse('test-token'))
            ->toMail($personne)
            ->render();

        $this->assertStringContainsString('Concours Masteres INP-HB', $html);
        $this->assertStringNotContainsString('<img', $html);
        $this->assertStringNotContainsString(
            'laravel.com/img/notification-logo.png',
            $html
        );
    }
}
