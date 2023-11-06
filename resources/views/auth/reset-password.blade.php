@extends('layouts.auth')

@section('title', 'Восстановление пароля')

@section('content')
    <x-forms.form-container>
        @csrf

        <x-slot:title>Восстановление пароля</x-slot:title>
        <x-slot:method>POST</x-slot:method>
        <x-slot:action>{{ route('reset-password-action') }}</x-slot:action>

        <input type="hidden" name="token" value="{{ $token }}"/>

        <x-forms.text-input
            type="email"
            name="email"
            placeholder="E-mail"
            required="true"
            value="{{ request('email') }}"
            :isError="$errors->has('email')"
        />
        @error('email')
        <x-forms.error-message>{{ $message }}</x-forms.error-message>
        @enderror

        <x-forms.text-input
            type="password"
            name="password"
            placeholder="Пароль"
            required="true"
            :isError="$errors->has('password')"
        />
        @error('password')
        <x-forms.error-message>{{ $message }}</x-forms.error-message>
        @enderror

        <x-forms.text-input
            type="password"
            name="password_confirmation"
            placeholder="Повторите пароль"
            required="true"
            :isError="$errors->has('password_confirmation')"
        />
        @error('password_confirmation')
        <x-forms.error-message>{{ $message }}</x-forms.error-message>
        @enderror

        <x-forms.primary-button>Обновить пароль</x-forms.primary-button>
    </x-forms.form-container>
@endsection
