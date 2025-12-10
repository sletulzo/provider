<script>
    window.__toastrAlreadyShown = window.__toastrAlreadyShown || {};

    document.addEventListener('livewire:navigated', () => {

        @if(session('success') && !session('success') == "")
            if (!window.__toastrAlreadyShown['success']) {
                toastr.remove();
                toastr.clear();
                toastr.success(@json(session('success')), 'Succès');
                window.__toastrAlreadyShown['success'] = true;
            }
        @endif

        @if(session('error'))
            if (!window.__toastrAlreadyShown['error']) {
                toastr.remove();
                toastr.clear();
                toastr.error(@json(session('error')), 'Erreur');
                window.__toastrAlreadyShown['error'] = true;
            }
        @endif

        @if(session('info'))
            if (!window.__toastrAlreadyShown['info']) {
                toastr.remove();
                toastr.clear();
                toastr.info(@json(session('info')), 'Information');
                window.__toastrAlreadyShown['info'] = true;
            }
        @endif

        @if(session('warning'))
            if (!window.__toastrAlreadyShown['warning']) {
                toastr.remove();
                toastr.clear();
                toastr.warning(@json(session('warning')), 'Attention');
                window.__toastrAlreadyShown['warning'] = true;
            }
        @endif

    });
</script>
