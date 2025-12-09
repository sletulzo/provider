<x-guest-layout>

    <div class="login-container">
        <div class="login-container-left">
            <div class="login-container-mobile">
                <div class="login-container-logo"></div>
                <div class="login-container-title">{{ config('app.name') }}</div>
            </div>
            
            <div style="display: flex; flex-direction: column">
                <h2>Commande n°{{ $order->id }} acceptée</h2>
                <h3>Merci d'avoir validé la commande, le client est prévenu par email de votre acceptation.</h3>
            </div>
        </div>
        <div class="login-container-right">
            <h1>{{ config('app.name') }}</h1>
        </div>
    </div>

</x-guest-layout>
