function openAddModal(table) {
    document.getElementById('addTableName').value = table;

    fetch('get_table_structure.php?table=' + table)
        .then(response => response.json())
        .then(fields => {
            let formFields = '';
            fields.forEach(field => {
                if (field.Field !== 'id') {
                    const extraAttrs = getExtraAttributes(table, field.Field);

                    if (table === 'applications' && field.Field === 'type') {
                        formFields += `
                            <div class="form-group">
                                <label for="add_${field.Field}">${field.Field}</label>
                                <select id="add_${field.Field}" name="${field.Field}" class="form-control">
                                    <option value="job">Job</option>
                                    <option value="internship">Internship</option>
                                </select>
                            </div>
                        `;
                    } else {
                        formFields += `
                            <div class="form-group">
                                <label for="add_${field.Field}">${field.Field}</label>
                                <input type="${getInputType(field.Type)}" id="add_${field.Field}" name="${field.Field}" class="form-control" ${extraAttrs}>
                            </div>
                        `;
                    }
                }
            });
            document.getElementById('addFormFields').innerHTML = formFields;
            document.getElementById('addModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ошибка при загрузке структуры таблицы');
        });
}

function openEditModal(table, record) {
    document.getElementById('editTableName').value = table;
    document.getElementById('editRecordId').value = record.id || record[Object.keys(record)[0]];

    fetch('get_table_structure.php?table=' + table)
        .then(response => response.json())
        .then(fields => {
            let formFields = '';
            fields.forEach(field => {
                const value = record[field.Field] ?? '';
                if (field.Field === 'id') return;
                const extraAttrs = getExtraAttributes(table, field.Field);

                if (table === 'applications' && field.Field === 'type') {
                    formFields += `
                        <div class="form-group">
                            <label for="edit_${field.Field}">${field.Field}</label>
                            <select id="edit_${field.Field}" name="${field.Field}" class="form-control">
                                <option value="job" ${value === 'job' ? 'selected' : ''}>Job</option>
                                <option value="internship" ${value === 'internship' ? 'selected' : ''}>Internship</option>
                            </select>
                        </div>
                    `;
                } else {
                    formFields += `
                        <div class="form-group">
                            <label for="edit_${field.Field}">${field.Field}</label>
                            <input type="${getInputType(field.Type)}" id="edit_${field.Field}" name="${field.Field}" value="${value}" class="form-control" ${extraAttrs}>
                        </div>
                    `;
                }
            });
            document.getElementById('editFormFields').innerHTML = formFields;
            document.getElementById('editModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ошибка при загрузке структуры таблицы');
        });
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function deleteRecord(table, id) {
    if (confirm('Вы уверены, что хотите удалить эту запись?')) {
        fetch('admin_actions.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=delete&table=${table}&id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Запись успешно удалена');
                window.location.reload();
            } else {
                alert('Ошибка при удалении: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при удалении');
        });
    }
}

function getInputType(fieldType) {
    fieldType = fieldType.toLowerCase();
    if (fieldType.includes('int') || fieldType.includes('decimal') || fieldType.includes('float')) {
        return 'number';
    } else if (fieldType.includes('date') || fieldType.includes('year')) {
        return 'date';
    } else {
        return 'text';
    }
}

function getExtraAttributes(table, fieldName) {
    if (table === 'reviews' && fieldName === 'rating') {
        return 'min="1" max="10" step="1"';
    }
    return '';
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
};

document.getElementById('addForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    submitForm(this);
});

document.getElementById('editForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    submitForm(this);
});

function submitForm(form) {
    const formData = new FormData(form);
    const action = form.getAttribute('action');

    fetch(action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            alert('Ошибка: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при отправке формы');
    });
}

// ====== Маска телефона и очистка email ======

document.addEventListener('focusin', function (e) {
    if (e.target.name === 'phone') {
        if (!e.target.value.startsWith('+7')) {
            e.target.value = '+7 ';
        }
    }
});

document.addEventListener('input', function (e) {
    if (e.target.name === 'phone') {
        let input = e.target.value.replace(/\D/g, '');
        if (input.startsWith('7')) input = input.slice(1);
        input = input.slice(0, 10);

        let formatted = '+7';
        if (input.length > 0) formatted += ' (' + input.slice(0, 3);
        if (input.length >= 3) formatted += ') ' + input.slice(3, 6);
        if (input.length >= 6) formatted += '-' + input.slice(6, 8);
        if (input.length >= 8) formatted += '-' + input.slice(8, 10);

        e.target.value = formatted;
    }

    if (e.target.name === 'email') {
        e.target.value = e.target.value.replace(/[а-яА-Я\s]/g, '');
    }
});
