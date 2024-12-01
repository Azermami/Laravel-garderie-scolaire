@extends('layouts.user_type.auth')

@section('content')

<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ajout Personnel
            </h2>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form role="form" method="POST" action="{{ route('admin.addPersonnel') }}">
                @csrf

                <!-- Nom -->
                <div>
                    <label for="nom" class="block font-medium text-sm text-gray-700">Nom</label>
                    <input id="nom" class="block mt-1 w-full form-control" type="text" name="nom" placeholder="Nom" value="{{ old('nom') }}" required autofocus>
                    @error('nom')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Prénom -->
                <div class="mt-4">
                    <label for="prenom" class="block font-medium text-sm text-gray-700">Prénom</label>
                    <input id="prenom" class="block mt-1 w-full form-control" type="text" name="prenom" placeholder="Prénom" value="{{ old('prenom') }}" required>
                    @error('prenom')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input id="email" class="block mt-1 w-full form-control" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div class="mt-4">
                    <label for="telephone" class="block font-medium text-sm text-gray-700">Téléphone</label>
                    <input id="telephone" class="block mt-1 w-full form-control" type="text" name="telephone" placeholder="Téléphone" value="{{ old('telephone') }}" required>
                    @error('telephone')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mot de Passe -->
                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Mot de Passe</label>
                    <input id="password" class="block mt-1 w-full form-control" type="password" name="password" placeholder="Password" required>
                    @error('password')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmation du Mot de Passe -->
                <div class="mt-4">
                    <label for="password-confirm" class="block font-medium text-sm text-gray-700">Confirmer le Mot de Passe</label>
                    <input id="password-confirm" class="block mt-1 w-full form-control" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>

                <!-- Bouton d'Enregistrement -->
                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">
                        Ajout Personnel
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

@endsection
