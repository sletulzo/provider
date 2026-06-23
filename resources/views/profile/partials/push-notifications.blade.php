<section class="profile-v2__card" id="push-card" data-push-card>
    <div class="profile-v2__card-head">
        <div class="profile-v2__card-icon"><i class="fa-solid fa-bell"></i></div>
        <div>
            <h2 class="profile-v2__card-title">Notifications push</h2>
            <p class="profile-v2__card-desc">
                Recevez une alerte sur cet appareil
                @if (Auth::user()->isProvider())
                    dès qu'un client passe une commande.
                @else
                    dès qu'un fournisseur répond à votre commande.
                @endif
            </p>
        </div>
    </div>

    <div class="profile-v2__form">
        <p data-push-status class="profile-v2__card-desc" style="margin-bottom: 1rem;">
            Vérification de l'état des notifications…
        </p>

        <div class="profile-v2__actions">
            <button type="button" class="btn-primary" data-push-enable hidden>
                <span class="btn-text"><i class="fa-solid fa-bell"></i> Activer les notifications</span>
            </button>

            <button type="button" class="btn-secondary" data-push-disable hidden>
                <span class="btn-text"><i class="fa-solid fa-bell-slash"></i> Désactiver</span>
            </button>
        </div>
    </div>
</section>
