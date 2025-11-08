{{-- Modal & Alert Handlers --}}
<script>
document.addEventListener('livewire:initialized', () => {
    // Handle modals
    window.addEventListener('showModal', (e) => {
        const id = e?.detail?.id || e?.detail;
        if (!id) return;
        
        const modalEl = document.getElementById(id);
        if (modalEl) {
            const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modalInstance.show();
        }
    });

    window.addEventListener('closeModal', (e) => {
        const id = e?.detail?.id || e?.detail;
        if (!id) return;
        
        const modalEl = document.getElementById(id);
        if (modalEl) {
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
        }
    });

    // Handle Bootstrap modals closing
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', () => {
            // Emit a Livewire event in a version-compatible way.
            // Livewire v2 exposed `Livewire.emit`, v3 may use `Livewire.dispatch` or the
            // `window.livewire` namespace. Fallback to a CustomEvent so Livewire PHP
            // components can listen via browser events if needed.
            try {
                if (window.Livewire && typeof window.Livewire.emit === 'function') {
                    window.Livewire.emit('modalClosed', modal.id);
                } else if (window.Livewire && typeof window.Livewire.dispatch === 'function') {
                    // some versions expose dispatch instead of emit
                    window.Livewire.dispatch('modalClosed', modal.id);
                } else if (window.livewire && typeof window.livewire.emit === 'function') {
                    window.livewire.emit('modalClosed', modal.id);
                } else {
                    window.dispatchEvent(new CustomEvent('modalClosed', { detail: modal.id }));
                }
            } catch (e) {
                // If anything goes wrong, still dispatch a DOM event so listeners can react
                window.dispatchEvent(new CustomEvent('modalClosed', { detail: modal.id }));
            }
        });
    });

    // Handle alerts (requires SweetAlert2)
    window.addEventListener('showAlert', (e) => {
        const { type = 'success', message, title } = e?.detail || {};
        if (!message) return;

        Swal.fire({
            title: title || (type === 'success' ? 'Berhasil!' : 'Perhatian!'),
            text: message,
            icon: type,
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
});
</script>