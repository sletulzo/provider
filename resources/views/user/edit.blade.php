<x-form-page
    :back="route('users')"
    eyebrow="Utilisateurs"
    :title="$user->name"
    subtitle="Modifiez le compte et ses accès."
    icon="fa-regular fa-circle-user"
>
    <form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}" class="form-page__form">
        @csrf

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-regular fa-id-badge"></i> Identité</h2>
                <p class="form-page__card-desc">Coordonnées et accès de l'utilisateur.</p>
            </div>

            <div class="form-page__grid">
                <div class="form-field">
                    <label for="name" class="form-field__label">Nom <span class="req">*</span></label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" placeholder="Nom de l'utilisateur" required>
                </div>

                <div class="form-field">
                    <label for="email" class="form-field__label">Email <span class="req">*</span></label>
                    <input type="text" name="email" id="email" value="{{ $user->email }}" required placeholder="Email de l'utilisateur">
                </div>

                <div class="form-field">
                    <label for="user_type_id" class="form-field__label">Groupe utilisateur <span class="req">*</span></label>
                    <select id="user_type_id" name="user_type_id" required>
                        <option value="">Choisir dans la liste</option>
                        @foreach($userTypes as $userType)
                            <option value="{{ $userType->id }}" {{ $user->user_type_id == $userType->id ? 'selected' : '' }}>{{ $userType->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-field">
                    <label for="tenant_id" class="form-field__label">Société <span class="req">*</span></label>
                    <select id="tenant_id" name="tenant_id" required>
                        <option value="">Choisir dans la liste</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" {{ $user->tenant_id == $tenant->id ? 'selected' : '' }}>{{ $tenant->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-page__card">
            <div class="form-page__card-head">
                <h2 class="form-page__card-title"><i class="fa-solid fa-key"></i> Mot de passe</h2>
                <p class="form-page__card-desc">Envoyez un e-mail permettant à l'utilisateur de définir ou réinitialiser son mot de passe.</p>
            </div>

            <div class="form-page__inline-action">
                <button type="submit" form="userResetForm" class="btn-default">
                    <span class="btn-loader"></span>
                    <span class="btn-text"><i class="fa-regular fa-paper-plane"></i> Envoyer le lien de création / réinitialisation</span>
                </button>
            </div>
        </div>

        <div class="form-page__footer">
            <a href="{{ route('users.delete', ['user' => $user->id]) }}" class="btn-delete confirm-delete">Supprimer</a>
            <a wire:navigate href="{{ route('users') }}" class="btn-default">Annuler</a>
            <button type="submit" class="btn-primary">
                <span class="btn-loader"></span>
                <span class="btn-text">Mettre à jour</span>
            </button>
        </div>
    </form>

    <form id="userResetForm" action="{{ route('users.sendReset', $user) }}" method="POST" hidden>
        @csrf
    </form>
</x-form-page>
