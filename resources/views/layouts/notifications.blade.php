<script>
    document.addEventListener('livewire:navigated', () => {
        @if(session('success'))
            toastr.clear();
            toastr.success(@json(session('success')), 'Succès');
        @endif
        @if(session('error'))
            toastr.clear();
            toastr.error(@json(session('error')), 'Erreur');
        @endif
        @if(session('info'))
            toastr.clear();
            toastr.info(@json(session('info')), 'Information');
        @endif
        @if(session('warning'))
            toastr.clear();
            toastr.warning(@json(session('warning')), 'Attention');
        @endif
    });
</script>