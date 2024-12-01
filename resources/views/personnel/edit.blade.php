@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Modifier Personnel</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('admin.personnel.update', $personnel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group mb-3">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom', $personnel->nom) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" class="form-control" value="{{ old('prenom', $personnel->prenom) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $personnel->email) }}" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Modifier
                    </button>
                    <a href="{{ route('admin.personnel.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts for FontAwesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
