document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('send-invite').addEventListener('click', function () {
        const email = document.getElementById('invite-email').value;
        const commonEmailPart = document.getElementById('common_email_part').value;

        fetch('/events/{{ $event->id ?? 0 }}/invite', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                email: email,
                common_email_part: commonEmailPart
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.status);
        });
    });
});
