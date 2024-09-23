@extends('layout') 
@section('content')



<div class="container">
    <h3>Orario di lavoro</h3><br>
    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')
    
        <!-- Lunedì -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="monday_starts_at"><h4>Lunedì</h4></label>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="monday_starts_at"
                    id="monday_starts_at"
                    class="form-control"                    
                    value="{{ old('monday_starts_at', substr($schedule->monday_starts_at, 0, 5)) }}"

                >
            </div>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="monday_ends_at"
                    id="monday_ends_at"
                    class="form-control"                    
                    value="{{ old('monday_ends_at', substr($schedule->monday_ends_at, 0, 5)) }}"
                >
            </div>
        </div>
    
        <!-- Martedì -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="tuesday_starts_at"><h4>Martedì</h4></label>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="tuesday_starts_at"
                    id="tuesday_starts_at"
                    class="form-control"

                    value="{{ old('tuesday_starts_at', substr($schedule->tuesday_starts_at, 0, 5)) }}"
                >
            </div>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="tuesday_ends_at"
                    id="tuesday_ends_at"
                    class="form-control"
 
                    value="{{ old('tuesday_ends_at', substr($schedule->tuesday_ends_at, 0, 5)) }}"
                >
            </div>
        </div>
    
        <!-- Mercoledì -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="wednesday_starts_at"><h4>Mercoledì</h4></label>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="wednesday_starts_at"
                    id="wednesday_starts_at"
                    class="form-control"
                    value="{{ old('wednesday_starts_at', substr($schedule->wednesday_starts_at, 0, 5)) }}"
                >
            </div>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="wednesday_ends_at"
                    id="wednesday_ends_at"
                    class="form-control"

                    value="{{ old('wednesday_ends_at', substr($schedule->wednesday_ends_at, 0, 5)) }}"
                >
            </div>
        </div>
    
        <!-- Giovedì -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="thursday_starts_at"><h4>Giovedì</h4></label>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="thursday_starts_at"
                    id="thursday_starts_at"
                    class="form-control"
                    value="{{ old('thursday_starts_at', substr($schedule->thursday_starts_at, 0, 5)) }}"
                >
            </div>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="thursday_ends_at"
                    id="thursday_ends_at"
                    class="form-control"
                    
                    value="{{ old('thursday_ends_at', substr($schedule->thursday_ends_at, 0, 5)) }}"
                >
            </div>
        </div>
    
        <!-- Venerdì -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="friday_starts_at"><h4>Venerdì</h4></label>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="friday_starts_at"
                    id="friday_starts_at"
                    class="form-control"                    
                    value="{{ old('friday_starts_at', substr($schedule->friday_starts_at, 0, 5)) }}"
                >
            </div>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="friday_ends_at"
                    id="friday_ends_at"
                    class="form-control"
                    value="{{ old('friday_ends_at', substr($schedule->friday_ends_at, 0, 5)) }}"
                >
            </div>
        </div>
    
        <!-- Sabato -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="saturday_starts_at"><h4>Sabato</h4></label>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="saturday_starts_at"
                    id="saturday_starts_at"
                    class="form-control"
                    value="{{ old('saturday_starts_at', substr($schedule->saturday_starts_at, 0, 5)) }}"
                >
            </div>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="saturday_ends_at"
                    id="saturday_ends_at"
                    class="form-control"
                    value="{{ old('saturday_starts_at', substr($schedule->saturday_ends_at, 0, 5)) }}"
                >
            </div>
        </div>
    
        <!-- Domenica -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="sunday_starts_at"><h4>Domenica</h4></label>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="sunday_starts_at"
                    id="sunday_starts_at"
                    class="form-control"                    
                    value="{{ old('sunday_starts_at', substr($schedule->sunday_starts_at, 0, 5)) }}"
                >
            </div>
            <div class="col-sm-5">
                <input
                    type="time"
                    name="sunday_ends_at"
                    id="sunday_ends_at"
                    class="form-control"
                    
                    value="{{ old('sunday_ends_at', substr($schedule->sunday_ends_at, 0, 5)) }}"
                >
            </div>
        </div>
    
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Aggiorna Orario</button>
    </form>
    
    
    
</div>


@endsection