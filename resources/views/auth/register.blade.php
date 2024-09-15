<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nom -->
        <div>
            <label for="nom">Nom</label>
            <input id="nom" type="text" name="nom" value="{{ old('nom') }}" required autofocus>
            @error('nom')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Prénom -->
        <div>
            <label for="prenom">Prénom</label>
            <input id="prenom" type="text" name="prenom" value="{{ old('prenom') }}" required>
            @error('prenom')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Mot de Passe -->
        <div>
            <label for="pwd">Mot de Passe</label>
            <input id="pwd" type="password" name="pwd" required>
            @error('pwd')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirmation du Mot de Passe -->
        <div>
            <label for="pwd-confirm">Confirmer le Mot de Passe</label>
            <input id="pwd-confirm" type="password" name="pwd_confirmation" required>
        </div>

        <!-- Bouton d'Enregistrement -->
        <div>
            <button type="submit">S'inscrire</button>
        </div>
    </form>
</x-guest-layout>
