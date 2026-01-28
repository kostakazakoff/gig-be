@props(['btnSelector', 'bgFieldSelector', 'enFieldSelector'])

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.querySelector('{{ $btnSelector }}');
        const textBg = document.querySelector('{{ $bgFieldSelector }}');
        const textEn = document.querySelector('{{ $enFieldSelector }}');

        if (!btn || !textBg || !textEn) {
            console.error('Translation elements not found');
            return;
        }

        btn.addEventListener('click', function() {
            const textBgText = textBg.value.trim();
            if (!textBgText) {
                alert('Моля, попълнете полето на български');
                return;
            }

            fetch('{{ route('admin.translate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    text: textBgText
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.translatedText) {
                    textEn.value = data.translatedText;
                } else {
                    alert('Грешка при превода');
                }
            })
            .catch(error => {
                console.error('Translation error:', error);
                alert('Възникна грешка при превода');
            });
        });
    });
</script>