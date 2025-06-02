function toggleWitnessFields(show) {
    const witnessFieldsDiv = document.getElementById('witness_fields');
    const witnessNameInput = document.getElementById('witness_name');
    const witnessRelationSelect = document.getElementById('witness_relation');

    if (witnessFieldsDiv) { // Pastikan elemen utama ada
        witnessFieldsDiv.style.display = show ? 'block' : 'none';
        if (!show) {
            // Kosongkan nilai jika field disembunyikan
            if (witnessNameInput) witnessNameInput.value = '';
            if (witnessRelationSelect) witnessRelationSelect.value = '';
        }
    }
}

function togglePerpetratorFields(show) {
    const perpetratorFieldsDiv = document.getElementById('perpetrator_fields');
    const perpetratorNameInput = document.getElementById('perpetrator_name');
    const perpetratorRoleSelect = document.getElementById('perpetrator_role');

    if (perpetratorFieldsDiv) { // Pastikan elemen utama ada
        perpetratorFieldsDiv.style.display = show ? 'block' : 'none';
        if (!show) {
            // Kosongkan nilai jika field disembunyikan
            if (perpetratorNameInput) perpetratorNameInput.value = '';
            if (perpetratorRoleSelect) perpetratorRoleSelect.value = '';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const witnessYesRadio = document.getElementById('witness_yes');
    const witnessNoRadio = document.getElementById('witness_no');
    if (witnessYesRadio) {
        // Inisialisasi awal berdasarkan old input atau default 'no'
        if (witnessYesRadio.checked) {
            toggleWitnessFields(true);
        } else {
            if (witnessNoRadio && !witnessYesRadio.checked) witnessNoRadio.checked = true;
            toggleWitnessFields(false);
        }
        // Listener untuk perubahan
        document.querySelectorAll('input[name="has_witness"]').forEach(radio => {
            radio.addEventListener('change', function() {
                toggleWitnessFields(this.value === 'yes');
            });
        });
    }

    const knowsPerpetratorYesRadio = document.getElementById('perpetrator_yes');
    const knowsPerpetratorNoRadio = document.getElementById('perpetrator_no');
    if (knowsPerpetratorYesRadio) {
        // Inisialisasi awal
        if (knowsPerpetratorYesRadio.checked) {
            togglePerpetratorFields(true);
        } else {
            if (knowsPerpetratorNoRadio && !knowsPerpetratorYesRadio.checked) knowsPerpetratorNoRadio.checked = true;
            togglePerpetratorFields(false);
        }
        // Listener untuk perubahan
        document.querySelectorAll('input[name="knows_perpetrator"]').forEach(radio => {
            radio.addEventListener('change', function() {
                togglePerpetratorFields(this.value === 'yes');
            });
        });
    }
});
