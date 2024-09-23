@extends('layout')

@section('content')
<div class="container" style="padding: 15px;">
  <h3>Crea un nuovo record di ferie</h3>

  <!-- Success and error messages -->

  <!-- Form -->
  <form action="{{ route('employee_times.store') }}" method="POST">
    @csrf

    <div class="form-row align-items-end">
      <!-- Starts At -->
      <div class="form-group col-md-4">
        <label for="starts_at">Inizia a</label>
        <input
          type="text"
          name="starts_at"
          id="starts_at"
          class="form-control datetimepicker"
          value="{{ old('starts_at') }}"
          required
        />
      </div>

      <!-- Ends At -->
      <div class="form-group col-md-4">
        <label for="ends_at">Termina alle</label>
        <input
          type="text"
          name="ends_at"
          id="ends_at"
          class="form-control datetimepicker"
          value="{{ old('ends_at') }}"
          required
        />
      </div>

      <!-- Submit Button -->
      <div class="form-group col-md-4">
        <button type="submit" class="btn btn-primary btn-block">Crea</button>
      </div>
    </div>
  </form>
  <div style="background-color: white; padding: 15px;">

  <h3 class="mt-5">Ferie registrate</h3>
    @if ($schedules->isEmpty())
        <p>Nessuna ferie trovata.</p>
    @else
    <table class="table table-bordered mt-3" >

            <thead>
                <tr>
                    <th>Inizia a</th>
                    <th>Termina alle</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->starts_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $schedule->ends_at->format('d-m-Y H:i') }}</td>
                        <td>
                            
                            <form action="{{ route('employee_times.destroy', $schedule->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questa pianificazione?')">Elimina</button>
                            </form>
                           
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
     <!-- Pagination and Results Info -->
     <p>
        {{ __('pagination.showing') }} {{ $schedules->firstItem() }} 
        {{ __('pagination.to') }} {{ $schedules->lastItem() }} 
        {{ __('pagination.of') }} {{ $schedules->total() }} 
        {{ __('pagination.results') }}
    </p>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-center">
                    {{ $schedules->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<!-- Initialize Flatpickr -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    flatpickr('.datetimepicker', {
      enableTime: true,
      dateFormat: 'Y-m-d H:i',
      time_24hr: true,
    });
  });
</script>
@endsection
