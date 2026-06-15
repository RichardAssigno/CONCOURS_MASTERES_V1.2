<?php

namespace App\Http\Controllers;

use App\Models\Personne;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;
use Throwable;

class PasswordResetController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'L’adresse email est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
        ]);

        $email = mb_strtolower(trim($validated['email']));
        $personne = Personne::query()->where('email', $email)->first();

        if (is_null($personne)) {
            return back()
                ->withInput(['email' => $email])
                ->withErrors([
                    'email' => 'Cette adresse email n’est associée à aucun compte. Vous n’êtes pas encore inscrit.',
                ]);
        }

        if ($this->mailIsNotConfigured()) {
            return back()
                ->withInput(['email' => $email])
                ->withErrors([
                    'email' => 'Le service d’envoi d’emails n’est pas complètement configuré. Veuillez contacter l’administration.',
                ]);
        }

        try {
            $status = Password::broker('personnes')->sendResetLink(['email' => $email]);
        } catch (Throwable $exception) {
            Log::error('Échec de l’envoi du lien de réinitialisation.', [
                'email' => $email,
                'exception' => $exception,
            ]);

            return back()
                ->withInput(['email' => $email])
                ->withErrors([
                    'email' => 'Le lien n’a pas pu être envoyé. Vérifiez la configuration du service mail ou contactez l’administration.',
                ]);
        }

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'Un lien de réinitialisation a été envoyé à '.$email.'. Pensez à vérifier vos courriers indésirables.'
            );
        }

        return back()
            ->withInput(['email' => $email])
            ->withErrors(['email' => $this->messageForStatus($status)]);
    }

    public function edit(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->string('email')->toString(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ], [
            'email.required' => 'L’adresse email est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $status = Password::broker('personnes')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Personne $personne, string $password): void {
                $personne->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($personne));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with(
                'succes',
                'Votre mot de passe a été réinitialisé. Vous pouvez maintenant vous connecter.'
            );
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => $this->messageForStatus($status)]);
    }

    private function messageForStatus(string $status): string
    {
        return match ($status) {
            Password::INVALID_TOKEN => 'Ce lien de réinitialisation est invalide ou a expiré.',
            Password::INVALID_USER => 'Cette adresse email n’est associée à aucun compte. Vous n’êtes pas encore inscrit.',
            Password::RESET_THROTTLED => 'Un lien a déjà été demandé récemment. Veuillez patienter avant de réessayer.',
            default => 'Impossible de réinitialiser le mot de passe. Veuillez réessayer.',
        };
    }

    private function mailIsNotConfigured(): bool
    {
        if (app()->environment('testing')) {
            return false;
        }

        $mailer = config('mail.default');

        if (in_array($mailer, ['log', 'array'], true)) {
            return true;
        }

        if ($mailer !== 'smtp') {
            return false;
        }

        return blank(config('mail.mailers.smtp.host'))
            || blank(config('mail.mailers.smtp.username'))
            || blank(config('mail.mailers.smtp.password'));
    }
}
