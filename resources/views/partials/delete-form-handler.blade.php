<!-- Delete Form Handler Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-form .delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            const message = this.dataset.confirmMessage || 'Сигурни ли сте, че искате да изтриете този запис?';
            
            showConfirmModal(message, function() {
                form.submit();
            });
        });
    });
});
</script>
