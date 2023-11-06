<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:dns'],
        ];
    }
}
