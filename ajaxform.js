document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.ajax');

    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {

            event.preventDefault();
            const id = this.dataset.id;
            const handlerUrl = this.dataset.handler;
            const input = document.getElementById('input-' + id).value;

            if (input.trim() === '') {
                alert('Input tidak boleh kosong!!');
                return;
            }

            const formData = new FormData();
            formData.append('input', input);
            formData.append('data_id', id);
            formData.append('action', 'save');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', handlerUrl, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('input-' + id).value = '';
                    loadData(id, handlerUrl);
                } else {
                    alert('An error occurred while saving the input: ' + xhr.responseText);
                }
            };

            xhr.onerror = function() {
                alert('Request failed. Please try again.');
            };
            xhr.send(formData);
        });
    });

    function loadData(id, handlerUrl) {
        const xhr = new XMLHttpRequest();
        const url = handlerUrl + '?data_id=' + id + '&action=get';
        xhr.open('GET', url, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('output-' + id).innerHTML = xhr.responseText;
            } else {
                console.error('Failed to load output for section ' + id + ': ' + xhr.responseText);
            }
        };
        xhr.onerror = function() {
            console.error('Request failed. Please try again.');
        };
        xhr.send();
    }

    document.querySelectorAll('.ajax').forEach(function(form) {
        const id = form.dataset.id;
        loadData(id, form.dataset.handler);
    });
});
