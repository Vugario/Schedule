@extends('app')

@section('content')
    <h4>Agenda</h4>
    <p><a href="{{ url('entry/create') }}">Klik hier</a> om een bezoek in te plannen.</p>

    @if (Session::has('message'))
        <p class="text-success">{{ Session::get('message') }}</p>
    @endif

    @if ($days)
        @foreach ($days as $day => $entries)
            <div class="panel panel-entry">
                <h4>
                    {{ App\Library\Karbon::fromFormat($day, 'd-m')->toHumanFormat() }}
                    <small class="pull-right">{{ App\Library\Karbon::createFromFormat('d-m', $day)->format('j F') }}</small>
                </h4>

                <ul>
                    @foreach ($entries as $entry)
                        <li>
                            <small>om {{ $entry->visit_at->format('H:i') }}</small>
                            {{ $entry->description }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @else
        <p></p>
    @endif

@endsection()
