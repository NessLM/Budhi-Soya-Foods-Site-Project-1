document.addEventListener("DOMContentLoaded", function () {
    const btnAddAdmin = document.getElementById("btnAddAdmin");
    const addAdminSection = document.getElementById("addAdminSection");
    const btnCancelAdd = document.getElementById("btnCancelAdd");
    const allEditForms = document.querySelectorAll(".edit-form-row");

    // Cek elemen penting ada dulu
    if (btnAddAdmin && addAdminSection && btnCancelAdd) {
        // Tampilkan/tutup form tambah admin
        btnAddAdmin.addEventListener("click", function () {
            closeAllEditForms(); // Tutup form edit lain dulu
            addAdminSection.classList.toggle("d-none");

            // Fokus ke input username jika form ditampilkan
            if (!addAdminSection.classList.contains("d-none")) {
                const input = addAdminSection.querySelector("input[name='username']");
                if (input) input.focus();
            }
        });

        btnCancelAdd.addEventListener("click", function () {
            addAdminSection.classList.add("d-none");
        });

        // Tombol Edit
        document.querySelectorAll(".btn-edit").forEach(button => {
            button.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                const targetForm = document.getElementById(`editFormRow-${id}`);

                // Tutup form tambah jika sedang terbuka
                addAdminSection.classList.add("d-none");

                // Toggle edit form: jika sudah terbuka, tutup. Kalau belum, tutup semua lalu buka
                if (targetForm && !targetForm.classList.contains("d-none")) {
                    targetForm.classList.add("d-none");
                } else {
                    closeAllEditForms();
                    if (targetForm) {
                        targetForm.classList.remove("d-none");

                        // Fokus otomatis ke input username di form edit
                        const input = targetForm.querySelector("input[name='username']");
                        if (input) input.focus();
                    }
                }
            });
        });

        // Tombol Batal Edit
        document.querySelectorAll(".btn-cancel-edit").forEach(button => {
            button.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                const form = document.getElementById(`editFormRow-${id}`);
                if (form) form.classList.add("d-none");
            });
        });

        // Fungsi untuk menutup semua form edit
        function closeAllEditForms() {
            allEditForms.forEach(form => form.classList.add("d-none"));
        }
    }
});
