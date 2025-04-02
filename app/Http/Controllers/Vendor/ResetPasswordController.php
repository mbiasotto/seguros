<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/vendor/dashboard';

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showResetForm(Request $request, $token = null)
    {
        // Verificar se o token é válido antes de exibir o formulário
        if ($token) {
            try {
                // Verificar se o token existe e é válido
                $isTokenValid = false;

                // Usar o DB diretamente para verificar o token
                $tokenData = DB::table('password_reset_tokens')
                    ->where('token', hash('sha256', $token))
                    ->where('created_at', '>=', now()->subMinutes(config('auth.passwords.vendors.expire', 60)))
                    ->first();

                $isTokenValid = !empty($tokenData);

                if (!$isTokenValid) {
                    // Token inválido ou expirado, redirecionar para a página de solicitação de redefinição
                    return redirect()->route('vendor.password.request')
                        ->withErrors(['email' => __('passwords.token')]);
                }
            } catch (\Exception $e) {
                // Se ocorrer algum erro, tratar como token inválido
                report($e);
                return redirect()->route('vendor.password.request')
                    ->withErrors(['email' => __('passwords.token')]);
            }
        }

        return view('vendor.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('vendors');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('vendor');
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',      // pelo menos uma letra minúscula
                'regex:/[A-Z]/',      // pelo menos uma letra maiúscula
                'regex:/[0-9]/',      // pelo menos um número
                'regex:/[@$!%*#?&]/', // pelo menos um caractere especial
            ],
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.regex' => 'A senha deve conter letras maiúsculas, minúsculas, números e caracteres especiais.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.required' => 'O campo senha é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Por favor, informe um endereço de e-mail válido.',
            'token.required' => 'O token de redefinição é inválido ou expirou.'
        ];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  mixed  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        // Atualizar a senha de forma segura
        if (method_exists($user, 'update')) {
            $user->update([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ]);
        } else {
            // Fallback manual para diferentes implementações de model
            $user->password = Hash::make($password);
            $user->remember_token = Str::random(60);

            if (method_exists($user, 'save')) {
                $user->save();
            }
        }

        // Fazer login se o guard suportar isso
        $guard = $this->guard();
        if ($guard && method_exists($guard, 'login')) {
            // @phpstan-ignore-next-line (para ignorar erros de tipo do linter)
            $guard->login($user);
        }
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return redirect($this->redirectPath())
                            ->with('status', __($response));
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        throw ValidationException::withMessages([
            'email' => [__($response)],
        ]);
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return $this->redirectTo ?? route('vendor.dashboard');
    }
}
