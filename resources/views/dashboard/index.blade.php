@extends('layout') 
@section('content')


<div class="container" style="padding: 5px; background-color: white; margin-top: 5px;"
>
    <div id='calendar'></div>

    <!-- Optional: Toast Container for Notifications -->
    <div aria-live="polite" aria-atomic="true" class="position-relative">
      <div class="toast-container position-absolute top-0 end-0 p-3">
        <!-- Toasts will be appended here -->
      </div>
    </div>
</div>   
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Retrieve CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
            var calendarEl = document.getElementById('calendar');
    
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '{{ route('appointments.events') }}',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                eventDidMount: function(info) {
                    // Determine if the appointment is in the future
                    var isFuture = new Date(info.event.start) > new Date();
    
                    // Prepare tooltip content
                    var tooltipContent = `
                        <strong>Nome:</strong> ${info.event.title}<br>
                        <strong>Codice fiscale:</strong> ${info.event.extendedProps.codice_fiscale}<br>
                        <strong>Email:</strong> ${info.event.extendedProps.email}
                    `;
    
                    // If the appointment is in the future, add a Cancel button
                    if (isFuture) {
                        tooltipContent += `<br><button class="btn btn-sm btn-danger mt-2 cancel-button" data-id="${info.event.id}">Annulla</button>`;
                    }
    
                    // Initialize Tippy.js tooltip
                    tippy(info.el, {
                        content: tooltipContent,
                        allowHTML: true,
                        animation: 'scale',
                        theme: 'light-border',
                        interactive: true, // Allows interaction with the tooltip content
                    });
                },
            });
    
            calendar.render();
    
            // Event delegation for dynamically added Cancel buttons
            document.body.addEventListener('click', function(e) {
                if (e.target && e.target.matches('button.cancel-button')) {
                    var appointmentId = e.target.getAttribute('data-id');
                    // Confirm cancellation
                    var confirmCancel = confirm('Sei sicuro di voler annullare questo appuntamento?');
                    if (confirmCancel) {
                        // Send DELETE request via AJAX
                        $.ajax({
                            url: `/appointments/${appointmentId}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                // Show success notification (using Bootstrap Toast)
                                var toastHTML = `
                                    <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                        <div class="d-flex">
                                            <div class="toast-body">
                                                ${response.message}
                                            </div>
                                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                        </div>
                                    </div>`;
                                $('.toast-container').append(toastHTML);
                                $('.toast').toast({ delay: 3000 });
                                $('.toast').toast('show');
    
                                // Remove the event from the calendar
                                var event = calendar.getEventById(appointmentId);
                                if (event) {
                                    event.remove();
                                }
                            },
                            error: function(xhr) {
                                var errorMessage = 'An error occurred while canceling the appointment.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                // Show error notification (using Bootstrap Toast)
                                var toastHTML = `
                                    <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                        <div class="d-flex">
                                            <div class="toast-body">
                                                ${errorMessage}
                                            </div>
                                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                        </div>
                                    </div>`;
                                $('.toast-container').append(toastHTML);
                                $('.toast').toast({ delay: 5000 });
                                $('.toast').toast('show');
                            }
                        });
                    }
                }
            });
        });
    </script>


@endsection