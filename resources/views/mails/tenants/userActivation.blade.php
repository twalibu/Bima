@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Welcome to Bima Alert',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

        <p>
            Hello {{ $last_name }}, 
        </p>

        <p>
            Welcome to Bima Alert Platform. You have been registered. To start using the platform please activate your account below.
        </p>

        <p>
            Your Login Details are:-<br>
            <b>E-mail: </b>{{ $email }}<br>
            <b>Password: </b>{{ $password }}
        </p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Activate Account',
            'link' => url('activate/'.$code)
        ])

    @include('beautymail::templates.sunny.contentStart')

        <p>
            <br><i>Or point your browser to this address: <br /> {!! route('auth.activation.attempt', urlencode($code)) !!} </i>
        </p>

        <p>
            Thank you.<br> <b>Bima Alert Team!</b>
        </p>

    @include('beautymail::templates.sunny.contentEnd')
@stop
