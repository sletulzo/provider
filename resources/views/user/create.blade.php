<x-form-page
    :back="route('users')"
    eyebrow="Utilisateurs"
    title="Nouvel utilisateur"
    subtitle="Créez un compte et rattachez-le à une société."
    icon="fa-regular fa-circle-user"
>
    <form method="POST" action="{{ route('users.store') }}" class="form-page__form">
        @csrf

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-regular fa-id-badge"></i> Identité</h2>
                <p class="form-page__card-desc">Coordonnées et accès de l'utilisateur.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field">
                    <label for="name" class="form-field__label">Nom <span class="req">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Nom de l'utilisateur" required>
                </div>

                <div class="form-field">
                    <label for="email" class="form-field__label">Email <span class="req">*</span></label>
                    <input type="text" name="email" id="email" required placeholder="Email de l'utilisateur">
                </div>

                <div class="form-field">
                    <label for="user_type_id" class="form-field__label">Groupe utilisateur <span class="req">*</span></label>
                    <select id="user_type_id" name="user_type_id" required>
                        <option value="">Choisir dans la liste</option>
                        @foreach($userTypes as $userType)
                            <option value="{{ $userType->id }}">{{ $userType->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-field">
                    <label for="tenant_id" class="form-field__label">Société <span class="req">*</span></label>
                    <select id="tenant_id" name="tenant_id" required>
                        <option value="">Choisir dans la liste</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-page__footer">
            <a wire:navigate href="{{ route('users') }}" class="btn-default">Annuler</a>
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Créer l'utilisateur</span>
            </button>
        </div>
    </form>
</x-form-page>
