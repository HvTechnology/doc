@extends('layout') 
@section('content')

<!-- Success Notification -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="active-member">
                        <div class="table-responsive">
                            <div class="d-flex align-items-center mb-3">
                                <!-- Add Patient Button -->
                                <button type="button" class="btn btn-success me-3" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                                    Nuovo Paziente
                                </button>
                            
                                <!-- Search Form -->
                                <form method="GET" action="{{ route('patients.search') }}" id="searchForm" class="d-flex">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Cerca Paziente" value="{{ request('search') }}" id="searchInput" style="width: 250px;">
                                        <button type="submit" class="btn btn-primary ms-2">Cerca</button>
                                    </div>
                                </form>
                            </div>
                            
                            
                            <!-- Patients Table -->
                            <table class="table table-xs mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Codice Fiscale</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody id="patientsTableBody">
                                    @if($patients && count($patients) > 0)
                                        @foreach ($patients as $patient)
                                        <tr>
                                            <td>{{ $patient->id }}</td>
                                            <td>{{ $patient->name }}</td>
                                            <td>{{ $patient->Codice_Fiscale }}</td>
                                            <td>{{ $patient->email }}</td>
                                            <td>{{ $patient->phone }}</td>
                                            <td>
                                           
                                                    <button class="btn btn-primary btn-sm edit-patient-btn" data-id="{{ $patient->id }}" style="width: 80px; margin-bottom: 5px;">
                                                        <i class="fas fa-pen"></i> Modifica
                                                    </button>
                                                    <a href="{{ route('patients.view', $patient->id) }}" class="btn btn-info btn-sm" style="width: 80px; margin-bottom: 5px;">
                                                        <i class="fas fa-eye"></i> Vedi
                                                    </a>
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">
                                                <p>No patients found</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            
                            <!-- Pagination and Results Info -->
                            <p>
                                {{ __('pagination.showing') }} {{ $patients->firstItem() }} 
                                {{ __('pagination.to') }} {{ $patients->lastItem() }} 
                                {{ __('pagination.of') }} {{ $patients->total() }} 
                                {{ __('pagination.results') }}
                            </p>
                            
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="d-flex justify-content-center">
                                            {{ $patients->links('vendor.pagination.bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                        
        </div>
    </div>    
</div>

<!-- Modal for Adding Patient -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPatientModalLabel">Aggiungi Paziente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Patient Form -->
                <form id="addPatientForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <span class="text-danger" id="nameError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Codice_Fiscale" class="form-label">Codice Fiscale</label>
                        <input type="text" class="form-control" id="Codice_Fiscale" name="Codice_Fiscale" required>
                        <span class="text-danger" id="CodiceFiscaleError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <span class="text-danger" id="emailError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefono</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                        <span class="text-danger" id="phoneError"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Aggiungi</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Editing Patient -->
<div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPatientModalLabel">Modifica Paziente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Patient Form -->
                <form id="editPatientForm">
                    @csrf
                    <input type="hidden" id="edit_patient_id"> <!-- Hidden field to hold patient ID -->
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                        <span class="text-danger" id="editNameError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="edit_Codice_Fiscale" class="form-label">Codice Fiscale</label>
                        <input type="text" class="form-control" id="edit_Codice_Fiscale" name="Codice_Fiscale" required>
                        <span class="text-danger" id="editCodiceFiscaleError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                        <span class="text-danger" id="editEmailError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="edit_phone" class="form-label">Telefono</label>
                        <input type="text" class="form-control" id="edit_phone" name="phone" required>
                        <span class="text-danger" id="editPhoneError"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Aggiorna</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery for AJAX submission -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

// Use event delegation for the submit event
$(document).on('submit', '#addPatientForm', function(event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = {
        _token: $('input[name="_token"]').val(),
        name: $('#name').val(),
        Codice_Fiscale: $('#Codice_Fiscale').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
    };

    // AJAX request to submit the form
    $.ajax({
        url: '{{ route("patients.store") }}', // URL for form submission
        type: 'POST',
        data: formData,
        success: function(response) {
            // Clear form fields
            $('#name').val('');
            $('#Codice_Fiscale').val('');
            $('#email').val('');
            $('#phone').val('');

            // Clear validation error messages
            $('#nameError').text('');
            $('#CodiceFiscaleError').text('');
            $('#emailError').text('');
            $('#phoneError').text('');

            // Close the modal
            $('#addPatientModal').modal('hide');

            // Reload the page to reflect the new patient data
            location.reload(); 
        },
        error: function(response) {
            // Handle validation errors
            var errors = response.responseJSON.errors;
            if (errors.name) {
                $('#nameError').text(errors.name[0]);
            }
            if (errors.Codice_Fiscale) {
                $('#CodiceFiscaleError').text(errors.Codice_Fiscale[0]);
            }
            if (errors.email) {
                $('#emailError').text(errors.email[0]);
            }
            if (errors.phone) {
                $('#phoneError').text(errors.phone[0]);
            }
        }
    });
});

// Rest of your code...
});




$(document).ready(function() {
    // Open the Edit Modal when clicking on the "Modifica" button
    $('.edit-patient-btn').on('click', function() {
        var patientId = $(this).data('id');

        // Fetch the patient's current data using AJAX
        $.ajax({
            url: '/patients/' + patientId,  // Adjust this route according to your routes file
            type: 'GET',
            success: function(response) {
                // Populate the modal with the existing patient data
                $('#edit_patient_id').val(response.id);
                $('#edit_name').val(response.name);
                $('#edit_Codice_Fiscale').val(response.Codice_Fiscale);
                $('#edit_email').val(response.email);
                $('#edit_phone').val(response.phone);

                // Show the edit modal
                $('#editPatientModal').modal('show');
            },
            error: function(response) {
                alert('Error fetching patient data.');
            }
        });
    });

    // Handle form submission for editing the patient
    $('#editPatientForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        var patientId = $('#edit_patient_id').val(); // Get the patient ID
        var formData = {
            _token: $('input[name="_token"]').val(),
            name: $('#edit_name').val(),
            Codice_Fiscale: $('#edit_Codice_Fiscale').val(),
            email: $('#edit_email').val(),
            phone: $('#edit_phone').val(),
        };

        // Send the updated data via AJAX
        $.ajax({
            url: '/patients/' + patientId,  // The route to update the patient
            type: 'PUT',  // PUT method for updating resources
            data: formData,
            success: function(response) {
                // Close the modal and reload the page to reflect the changes
                $('#editPatientModal').modal('hide');
                location.reload();
            },
            error: function(response) {
                var errors = response.responseJSON.errors;
                if (errors.name) {
                    $('#editNameError').text(errors.name[0]);
                }
                if (errors.Codice_Fiscale) {
                    $('#editCodiceFiscaleError').text(errors.Codice_Fiscale[0]);
                }
                if (errors.email) {
                    $('#editEmailError').text(errors.email[0]);
                }
                if (errors.phone) {
                    $('#editPhoneError').text(errors.phone[0]);
                }
            }
        });
    });
});

</script>

@endsection
