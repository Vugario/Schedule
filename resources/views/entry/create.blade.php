@extends('app')

@section('content')
    <h4>Bezoek inplannen</h4>
    <p>Geef aan met wie je komt en wanneer.</p>

    {!! Form::open(['url' => 'entry', 'method' => 'POST']) !!}
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Aanwezigen', ['class' => 'control-label hidden']) !!}
            {!! Form::input('text', 'description', old('description'), ['class' => 'form-control input-lg', 'placeholder' => 'Wie gaat op bezoek?']) !!}
        </div>

        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
            {!! Form::label('date', 'Wanneer', ['class' => 'control-label hidden']) !!}
            {!! Form::select('date', $dates, old('date'), ['class' => 'form-control input-lg', 'placeholder' => 'Welke datum?']) !!}
        </div>

        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
            {!! Form::label('time', 'Hoelaat', ['class' => 'control-label hidden']) !!}
            {!! Form::select('time', $times, old('time'), ['class' => 'form-control input-lg', 'placeholder' => 'Vanaf hoelaat?']) !!}
        </div>

        {!! Form::submit('Toevoegen', ['class' => 'btn-lg btn btn-primary btn-block']) !!}<br>

        <a href="{{ url('/') }}" class="btn btn-link btn-block text-muted">Annuleren</a>
    {!! Form::close() !!}
@endsection