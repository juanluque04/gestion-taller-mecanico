document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.table-sortable th[data-sort]').forEach((header, index) => {

        let asc = true;

        header.addEventListener('click', () => {

            const table = header.closest('table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            const type = header.dataset.sort;

            // Reset iconos
            table.querySelectorAll('th').forEach(th => {
                th.classList.remove('sorted-asc', 'sorted-desc');
            });

            rows.sort((a, b) => {

                let A = a.children[index].innerText.trim();
                let B = b.children[index].innerText.trim();

                if (type === 'number') {
                    A = parseFloat(A.replace(',', '.')) || 0;
                    B = parseFloat(B.replace(',', '.')) || 0;
                }

                if (type === 'date') {
                    A = new Date(A.split('/').reverse().join('-'));
                    B = new Date(B.split('/').reverse().join('-'));
                }

                if (A < B) return asc ? -1 : 1;
                if (A > B) return asc ? 1 : -1;
                return 0;
            });

            rows.forEach(row => tbody.appendChild(row));

            header.classList.add(asc ? 'sorted-asc' : 'sorted-desc');
            asc = !asc;
        });
    });

});
