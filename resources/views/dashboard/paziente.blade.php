@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Nome: {{ $patient->name }}</h2>
    <p><strong>Codice Fiscale:</strong> {{ $patient->Codice_Fiscale }}</p>
    <p><strong>Email:</strong> {{ $patient->email }}</p>
    <p><strong>Telefono:</strong> {{ $patient->phone }}</p>

    <h3 class="mt-4">appuntamenti</h3>
    @if($appointments && count($appointments) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <th>Annulato</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->starts_at }}</td>
                        <td>{{ $appointment->ends_at }}</td>
                        <td>{{ $appointment->cancelled_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Non è stata trovata alcuno appuntamento per questo paziente.</p>
    @endif

    <!-- Back Button -->
    <a href="{{ route('pazienti') }}" class="btn btn-secondary mt-3">Torna all'elenco dei pazienti</a>
</div>
@endsection
