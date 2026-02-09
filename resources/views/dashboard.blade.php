@extends('layouts.app')

@section('title', 'Dashboard - Health Tracker')

@section('content')
<div class="container">
    <script>
        (function() {
            const username = "{{ $username }}";
            const medsKey = `medications-${username}`;
            const vitalsKey = `vitals-${username}`;
            const existingMeds = JSON.parse(localStorage.getItem(medsKey) || '[]');
            const existingVitals = JSON.parse(localStorage.getItem(vitalsKey) || '[]');
            
            const successAlert = document.querySelector('.alert-success');
            if (successAlert && (existingMeds.length > 0 || existingVitals.length > 0)) {
                successAlert.innerHTML = successAlert.textContent.replace(
                    /Welcome,.*?!/,
                    `Welcome back, {{ $username }}! Your data from previous sessions has been restored.`
                );
            }
        })();
    </script>
    
    <div class="row mb-3">
        <div class="col-md-6 mx-auto">
            <div class="btn-group w-100" role="group">
                <button 
                    type="button" 
                    class="btn btn-primary btn-sm active" 
                    id="btnMedications"
                    onclick="switchView('medications')"
                >
                    💊 Medications
                </button>
                <button 
                    type="button" 
                    class="btn btn-outline-primary btn-sm" 
                    id="btnVitals"
                    onclick="switchView('vitals')"
                >
                    ❤️ Vital Signs
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Medication Management Section -->
        <div class="col-lg-8 mx-auto mb-4" id="medicationsSection">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">💊 Medication Management</h5>
                </div>
                <div class="card-body">
                    <form id="medicationForm" class="mb-4">
                        <div class="mb-3">
                            <label for="medName" class="form-label fw-bold">Medication Name</label>
                            <input type="text" class="form-control" id="medName" 
                                placeholder="e.g., Lisinopril" required>
                        </div>
                        <div class="mb-3">
                            <label for="medDosage" class="form-label fw-bold">Dosage</label>
                            <input type="text" class="form-control" id="medDosage" 
                                placeholder="e.g., 20mg" required>
                        </div>
                        <div class="mb-3">
                            <label for="medFrequency" class="form-label fw-bold">Frequency</label>
                            <input type="text" class="form-control" id="medFrequency" 
                                placeholder="e.g., Once daily in the morning" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Medication</button>
                    </form>

                    <div id="medicationList">
                        <h6 class="fw-bold mb-3">Your Medications</h6>
                        <div id="medicationsContainer">
                            <p class="text-muted text-center">No medications added yet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vitals Logging Section -->
        <div class="col-lg-8 mx-auto mb-4" id="vitalsSection" style="display: none;">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">❤️ Vital Signs Logging</h5>
                </div>
                <div class="card-body">
                    <form id="vitalsForm" class="mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="systolic" class="form-label fw-bold">Systolic BP (mmHg)</label>
                                <input type="number" class="form-control" id="systolic" 
                                    placeholder="e.g., 120" max="999" min="1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="diastolic" class="form-label fw-bold">Diastolic BP (mmHg)</label>
                                <input type="number" class="form-control" id="diastolic" 
                                    placeholder="e.g., 80" max="999" min="1" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="heartRate" class="form-label fw-bold">Heart Rate (BPM)</label>
                                <input type="number" class="form-control" id="heartRate" 
                                    placeholder="e.g., 65" max="999" min="1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="weight" class="form-label fw-bold">Weight (Kg)</label>
                                <input type="number" class="form-control" id="weight" 
                                    placeholder="e.g., 70" step="0.1" max="999" min="1" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Log Vitals</button>
                    </form>

                    <div id="vitalsList">
                        <h6 class="fw-bold mb-3">Vitals History</h6>
                        <div id="vitalsContainer" style="max-height: 400px; overflow-y: auto; overflow-x: hidden;">
                            <p class="text-muted text-center">No vitals logged yet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const currentUser = "{{ $username }}";
    const MEDS_KEY = `medications-${currentUser}`;
    const VITALS_KEY = `vitals-${currentUser}`;
    const logoutRoute = "{{ route('logout') }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const INACTIVITY_TIMEOUT = 10 * 60 * 1000;
    let inactivityTimer;

    function switchView(view) {
        const medicationsSection = document.getElementById('medicationsSection');
        const vitalsSection = document.getElementById('vitalsSection');
        const btnMedications = document.getElementById('btnMedications');
        const btnVitals = document.getElementById('btnVitals');
        
        if (view === 'medications') {
            medicationsSection.style.display = 'block';
            vitalsSection.style.display = 'none';
            btnMedications.classList.add('active', 'btn-primary');
            btnMedications.classList.remove('btn-outline-primary');
            btnVitals.classList.remove('active', 'btn-primary');
            btnVitals.classList.add('btn-outline-primary');
        } else {
            medicationsSection.style.display = 'none';
            vitalsSection.style.display = 'block';
            btnVitals.classList.add('active', 'btn-primary');
            btnVitals.classList.remove('btn-outline-primary');
            btnMedications.classList.remove('active', 'btn-primary');
            btnMedications.classList.add('btn-outline-primary');
        }
    }

    function loadMedications() {
        const meds = JSON.parse(localStorage.getItem(MEDS_KEY) || '[]');
        const container = document.getElementById('medicationsContainer');
        
        if (meds.length === 0) {
            container.innerHTML = '<p class="text-muted text-center">No medications added yet</p>';
            return;
        }
        
        container.innerHTML = meds.map((med, index) => `
            <div class="list-group-item mb-2 d-flex justify-content-between align-items-center">
                <div class="flex-grow-1">
                    <strong style="color: #357abd;">${escapeHtml(med.name)}</strong>
                    <span class="text-muted mx-2">•</span>
                    <span>${escapeHtml(med.dosage)}</span>
                    <span class="text-muted mx-2">•</span>
                    <span class="text-muted">${escapeHtml(med.frequency)}</span>
                </div>
                <button 
                    class="btn btn-danger btn-sm ms-3" 
                    onclick="removeMedication(${index})"
                    style="font-size: 0.75rem; padding: 4px 12px;">
                    Remove
                </button>
            </div>
        `).join('');
    }

    function addMedication(name, dosage, frequency) {
        const meds = JSON.parse(localStorage.getItem(MEDS_KEY) || '[]');
        meds.push({ name, dosage, frequency });
        localStorage.setItem(MEDS_KEY, JSON.stringify(meds));
        loadMedications();
    }

    function removeMedication(index) {
        const meds = JSON.parse(localStorage.getItem(MEDS_KEY) || '[]');
        meds.splice(index, 1);
        localStorage.setItem(MEDS_KEY, JSON.stringify(meds));
        loadMedications();
    }

    function loadVitals() {
        const vitals = JSON.parse(localStorage.getItem(VITALS_KEY) || '[]');
        const container = document.getElementById('vitalsContainer');
        
        if (vitals.length === 0) {
            container.innerHTML = '<p class="text-muted text-center">No vitals logged yet</p>';
            return;
        }
        
        vitals.sort((a, b) => b.timestamp - a.timestamp);
        
        container.innerHTML = vitals.map(vital => `
            <div class="list-group-item mb-2">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-primary">${formatDate(vital.timestamp)}</span>
                </div>
                <div class="row g-2">
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block">Blood Pressure</small>
                        <strong>${vital.systolic}/${vital.diastolic}</strong>
                        <small class="text-muted">mmHg</small>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block">Heart Rate</small>
                        <strong>${vital.heartRate}</strong>
                        <small class="text-muted">BPM</small>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block">Weight</small>
                        <strong>${vital.weight}</strong>
                        <small class="text-muted">Kg</small>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function addVital(systolic, diastolic, heartRate, weight) {
        const vitals = JSON.parse(localStorage.getItem(VITALS_KEY) || '[]');
        vitals.push({ systolic, diastolic, heartRate, weight, timestamp: Date.now() });
        localStorage.setItem(VITALS_KEY, JSON.stringify(vitals));
        loadVitals();
    }

    function formatDate(timestamp) {
        return new Date(timestamp).toLocaleString('en-US', {
            month: 'short', day: 'numeric', year: 'numeric',
            hour: 'numeric', minute: '2-digit', hour12: true
        });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function capitalizeFirst(text) {
        return text ? text.charAt(0).toUpperCase() + text.slice(1) : text;
    }

    function limitDigits(input) {
        if (input.value.length > 3) input.value = input.value.slice(0, 3);
    }

    function resetInactivityTimer() {
        clearTimeout(inactivityTimer);
        inactivityTimer = setTimeout(() => {
            alert('You have been logged out due to inactivity.');
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = logoutRoute;
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = csrfToken;
            form.appendChild(tokenInput);
            document.body.appendChild(form);
            form.submit();
        }, INACTIVITY_TIMEOUT);
    }

    document.addEventListener('DOMContentLoaded', function() {
        ['systolic', 'diastolic', 'heartRate', 'weight'].forEach(id => {
            const input = document.getElementById(id);
            if (input) input.addEventListener('input', () => limitDigits(input));
        });
        
        document.getElementById('medicationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = capitalizeFirst(document.getElementById('medName').value.trim());
            const dosage = document.getElementById('medDosage').value.trim();
            const frequency = document.getElementById('medFrequency').value.trim();
            
            if (name && dosage && frequency) {
                addMedication(name, dosage, frequency);
                this.reset();
            }
        });
        
        document.getElementById('vitalsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const systolic = parseInt(document.getElementById('systolic').value);
            const diastolic = parseInt(document.getElementById('diastolic').value);
            const heartRate = parseInt(document.getElementById('heartRate').value);
            const weight = parseFloat(document.getElementById('weight').value);
            
            if (systolic && diastolic && heartRate && weight) {
                addVital(systolic, diastolic, heartRate, weight);
                this.reset();
            }
        });
        
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
            document.addEventListener(event, resetInactivityTimer, true);
        });
        
        loadMedications();
        loadVitals();
        resetInactivityTimer();
    });
</script>
@endsection
