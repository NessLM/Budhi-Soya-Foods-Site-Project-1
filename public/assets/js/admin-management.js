document.addEventListener("DOMContentLoaded", function () {
    const btnAddAdmin = document.getElementById("btnAddAdmin");
    const addAdminSection = document.getElementById("addAdminSection");
    const btnCancelAdd = document.getElementById("btnCancelAdd");
    const allEditForms = document.querySelectorAll(".edit-admin-form");
    const addAdminForm = addAdminSection?.querySelector("form");

    // Fungsi hapus semua error message di form
    function clearErrors(form) {
        form.querySelectorAll('.error-message').forEach(el => el.remove());
    }

    // Fungsi tampilkan error dari response validasi backend
    function showErrors(form, errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                const errorEl = document.createElement('div');
                errorEl.className = 'error-message';
                errorEl.textContent = messages[0];
                input.parentNode.appendChild(errorEl);
            }
        }
    }

    // Tutup semua form edit sekaligus
    function closeAllEditForms() {
        allEditForms.forEach(form => form.closest('tr').classList.add("d-none"));
    }

    // Fungsi submit form add atau edit dengan ajax dan handling error
    async function handleFormSubmit(form, successMessage) {
        clearErrors(form);
        const submitBtn = form.querySelector("button[type='submit']");
        submitBtn.disabled = true;
        submitBtn.textContent = "Processing...";

        try {
            let formData = new FormData(form);

            // Jika form edit dan password kosong, hapus dari formData supaya backend tidak update password
            if (form.classList.contains('edit-admin-form')) {
                const pwd = formData.get('password');
                if (!pwd) {
                    formData.delete('password');
                }
            }

            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await res.json().catch(() => ({}));

            if (!res.ok) {
                if (data.errors) {
                    showErrors(form, data.errors);
                } else if (data.message) {
                    alert(data.message);
                } else {
                    alert('Terjadi kesalahan server.');
                }
            } else {
                alert(successMessage);
                if (form === addAdminForm) {
                    form.reset();
                    addAdminSection.classList.add("d-none");
                } else {
                    form.closest('tr').classList.add("d-none");
                }
                location.reload();
            }
        } catch (error) {
            alert('Gagal terhubung ke server.');
            console.error(error);
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = form === addAdminForm ? "Simpan" : "Update";
        }
    }

    // Validasi sederhana untuk form tambah admin
    if (addAdminForm) {
        addAdminForm.addEventListener("submit", function (e) {
            e.preventDefault();
            clearErrors(addAdminForm);

            const username = addAdminForm.querySelector('input[name="username"]').value.trim();
            const password = addAdminForm.querySelector('input[name="password"]').value;

            let valid = true;

            if (username.length < 4) {
                const usernameInput = addAdminForm.querySelector('input[name="username"]');
                const errorEl = document.createElement('div');
                errorEl.className = 'error-message';
                errorEl.textContent = 'Username minimal 4 karakter.';
                usernameInput.parentNode.appendChild(errorEl);
                valid = false;
            }

            if (password.length < 6) {
                const passwordInput = addAdminForm.querySelector('input[name="password"]');
                const errorEl = document.createElement('div');
                errorEl.className = 'error-message';
                errorEl.textContent = 'Password minimal 6 karakter.';
                passwordInput.parentNode.appendChild(errorEl);
                valid = false;
            }

            if (!valid) return;

            handleFormSubmit(addAdminForm, "Admin berhasil ditambahkan!");
        });
    }

    // Toggle tampilkan form tambah admin
    if (btnAddAdmin && addAdminSection && btnCancelAdd) {
        btnAddAdmin.addEventListener("click", function () {
            closeAllEditForms();
            addAdminSection.classList.toggle("d-none");
            if (!addAdminSection.classList.contains("d-none")) {
                const input = addAdminSection.querySelector("input[name='username']");
                if (input) input.focus();
            }
        });

        btnCancelAdd.addEventListener("click", function () {
            addAdminSection.classList.add("d-none");
            clearErrors(addAdminSection.querySelector("form"));
            addAdminSection.querySelector("form").reset();
        });
    }

    // Tombol edit toggle & fokus
    document.querySelectorAll(".btn-edit").forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const targetFormRow = document.getElementById(`editFormRow-${id}`);

            addAdminSection.classList.add("d-none");
            clearErrors(addAdminSection.querySelector("form"));

            if (targetFormRow && !targetFormRow.classList.contains("d-none")) {
                targetFormRow.classList.add("d-none");
            } else {
                closeAllEditForms();
                if (targetFormRow) {
                    targetFormRow.classList.remove("d-none");
                    const input = targetFormRow.querySelector("input[name='username']");
                    if (input) input.focus();
                }
            }
        });
    });

    // Tombol cancel edit
    document.querySelectorAll(".btn-cancel-edit").forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const formRow = document.getElementById(`editFormRow-${id}`);
            if (formRow) {
                formRow.classList.add("d-none");
                clearErrors(formRow.querySelector("form"));
                formRow.querySelector("form").reset();
            }
        });
    });

    // Submit semua form edit (update admin) dengan validasi tambahan
    allEditForms.forEach(editForm => {
        editForm.addEventListener("submit", function (e) {
            e.preventDefault();
            clearErrors(editForm);

            const username = editForm.querySelector('input[name="username"]').value.trim();
            const password = editForm.querySelector('input[name="password"]').value;

            let valid = true;

            if (username.length < 4) {
                const usernameInput = editForm.querySelector('input[name="username"]');
                const errorEl = document.createElement('div');
                errorEl.className = 'error-message';
                errorEl.textContent = 'Username minimal 4 karakter.';
                usernameInput.parentNode.appendChild(errorEl);
                valid = false;
            }

            if (password.length > 0 && password.length < 6) {
                const passwordInput = editForm.querySelector('input[name="password"]');
                const errorEl = document.createElement('div');
                errorEl.className = 'error-message';
                errorEl.textContent = 'Password minimal 6 karakter jika diisi.';
                passwordInput.parentNode.appendChild(errorEl);
                valid = false;
            }

            if (!valid) return;

            handleFormSubmit(editForm, "Admin berhasil diupdate!");
        });
    });

    // Toggle visibility password icon
    document.querySelectorAll('.password-wrapper').forEach(wrapper => {
        const input = wrapper.querySelector('input[type="password"], input[type="text"]');
        const toggle = wrapper.querySelector('.toggle-password');

        toggle.addEventListener('click', () => {
            if (input.type === 'password') {
                input.type = 'text';
                toggle.classList.add('fa-eye-slash');
                toggle.classList.remove('fa-eye');
            } else {
                input.type = 'password';
                toggle.classList.remove('fa-eye-slash');
                toggle.classList.add('fa-eye');
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const auditList = document.getElementById('auditLogList');
    const items = auditList.querySelectorAll('li');
  
    items.forEach((item, index) => {
      if (index >= 4) {
        item.style.display = 'none'; // sembunyikan item setelah indeks ke-3
      }
    });
  });
  