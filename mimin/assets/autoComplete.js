function initAutocomplete({
    inputId,
    suggestionId,
    data,
    searchField,
    idField,
    paramName,
    limit = 10
}) {
    const input = document.getElementById(inputId);
    const suggestions = document.getElementById(suggestionId);

    if (!input || !suggestions) return;

    input.addEventListener("input", function () {
        const value = this.value.toLowerCase().trim();
        suggestions.innerHTML = "";

        if (!value) return;

        data.filter(item =>
            String(item[searchField]).toLowerCase().includes(value)
        )
            .slice(0, limit)
            .forEach(item => {

                const link = document.createElement("a");
                link.textContent = item[searchField];

                const url = new URL(window.location.href);
                url.searchParams.set(paramName, item[idField]);
                link.href = url.toString();

                link.style.display = "block";
                link.style.padding = "8px";
                link.style.textDecoration = "none";
                link.style.color = "#000";

                suggestions.appendChild(link);
            });
    });
}
