@extends('layouts.auth')

@section('title', 'Забыли пароль')

@section('content')
    <x-forms.form-container>
        @csrf

        <x-slot:title>Забыли пароль</x-slot:title>
        <x-slot:action>POST</x-slot:action>

        <x-forms.text-input
            type="email"
            name="email"
            placeholder="E-mail"
            required="true"
            :isError="$errors->has('email')"
        />
        @error('email')
        <x-forms.error-message>{{ $message }}</x-forms.error-message>
        @enderror

        <x-forms.primary-button>Восстановить пароль</x-forms.primary-button>
    </x-forms.form-container>
@endsection
