@extends('app')

@section('content')
    <h4>Log in</h4>
    <p>Vul hier je persoonlijke e-mailadres in.</p>

    {!! Form::open() !!}

        <div class="form-group{{ count($errors) > 0 ? ' has-error' : '' }}">
            {!! Form::label('email', 'E-mailadres', ['class' => 'control-label hidden']) !!}
            {!! Form::input('email', 'email', old('email'), ['class' => 'form-control input-lg', 'placeholder' => 'E-mailadres']) !!}
        </div>

        {!! Form::submit('Inloggen', ['class' => 'btn-lg btn btn-primary btn-block']) !!}<br>

        <a href="#" class="btn btn-link btn-block text-muted">E-mailadres vergeten?</a>

    {!! Form::close() !!}
@endsection
