document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".clickable-row").forEach(row => {
        row.addEventListener("click", () => {
            window.location.href = row.dataset.href;
        });
    });
});

document.querySelectorAll('.btn-choice').forEach(group => {
    const input = group.querySelector('input[type=hidden]');
    group.querySelectorAll('button').forEach(btn => {
        btn.onclick = () => {
            group.querySelectorAll('button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            input.value = btn.dataset.value;
        };
    });
});

document.querySelector('.pill-item.active')?.scrollIntoView({
    behavior: 'smooth',
    inline: 'center'
});

function openModal(modalId, id = null, name = null) {

    const modal = document.getElementById(modalId);
    modal.style.display = 'block';

    if (id !== null && document.getElementById('id_from_modal')) {
        document.getElementById('id_from_modal').value = id;
    }

    if (name !== null && document.getElementById('name_from_modal')) {
        document.getElementById('name_from_modal').value = name;
    }

    const firstInput = modal.querySelector('input[type="number"], input[type="text"]');
    if (firstInput) {
        firstInput.focus();
        firstInput.select();
    }
}

// close suggestions when clicking outside
document.addEventListener("click", function (e) {
    if (!e.target.closest(".autocomplete")) {
        suggestions.innerHTML = "";
    }
});
