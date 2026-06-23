<x-app-layout>
    @php
        $user = Auth::user();
        $roleLabel = match (true) {
            $user->isProvider() => 'Fournisseur',
            $user->is_only_order => 'Client commandeur',
            default => 'Administrateur',
        };
        $contextLabel = $user->tenant?->name
            ?? ($user->isProvider() ? 'Espace fournisseur' : 'Espace client');
    @endphp

    <div class="profile-v2">
        <div class="profile-v2__header">
            <div>
                <p class="profile-v2__context">{{ $contextLabel }}</p>
                <h1 class="profile-v2__title">Mon profil</h1>
            </div>
        </div>

        <div class="profile-v2__hero">
            <x-avatar :name="$user->name" size="lg" class="profile-v2__avatar" />
            <div class="profile-v2__hero-body">
                <div class="profile-v2__name">{{ $user->name }}</div>
                <div class="profile-v2__email">{{ $user->email }}</div>
                <span class="profile-v2__badge">{{ $roleLabel }}</span>
            </div>
        </div>

        <div class="profile-v2__sections">
            @include('profile.partials.update-profile-information-form')
            @include('profile.partials.push-notifications')
            @include('profile.partials.update-password-form')
        </div>
    </div>
</x-app-layout>
