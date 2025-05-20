document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();

    const btnAddAdmin = document.getElementById('btnAddAdmin');
    const addAdminSection = document.getElementById('addAdminSection');
    const btnCancelAdd = document.getElementById('btnCancelAdd');
    const editButtons = document.querySelectorAll('.btn-edit');
    const cancelEditButtons = document.querySelectorAll('.btn-cancel-edit');
    let openEditId = null;

    btnAddAdmin.addEventListener('click', () => {
        if (addAdminSection.classList.contains('d-none')) {
            addAdminSection.classList.remove('d-none');
            addAdminSection.scrollIntoView({ behavior: 'smooth' });
        } else {
            addAdminSection.classList.add('d-none');
        }

        if(openEditId) {
            document.getElementById('editFormRow-' + openEditId).classList.add('d-none');
            openEditId = null;
        }
    });

    btnCancelAdd.addEventListener('click', () => {
        addAdminSection.classList.add('d-none');
    });

    editButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');

            if(!addAdminSection.classList.contains('d-none')) {
                addAdminSection.classList.add('d-none');
            }

            if(openEditId && openEditId !== id) {
                document.getElementById('editFormRow-' + openEditId).classList.add('d-none');
            }

            const editFormRow = document.getElementById('editFormRow-' + id);
            if(editFormRow.classList.contains('d-none')) {
                editFormRow.classList.remove('d-none');
                editFormRow.scrollIntoView({ behavior: 'smooth' });
                openEditId = id;
            } else {
                editFormRow.classList.add('d-none');
                openEditId = null;
            }
        });
    });

    cancelEditButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            document.getElementById('editFormRow-' + id).classList.add('d-none');
            openEditId = null;
        });
    });
});
