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
