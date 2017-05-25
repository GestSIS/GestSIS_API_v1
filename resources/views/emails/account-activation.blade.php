@extends('layouts.email')

@section('content')
    <p>
        Bienvenue sur Web Gestsis !<br />

        Pour terminer l'activation de votre compte, veuillez cliquer sur le lien ci-dessous ou copiez-le dans votre navigateur internet.<br />
    </p>
    <p style="text-align:center; line-height:40px">
        <a href="{!! route('user.activate', ['sis_id' => $sisID, 'email' => base64_encode($email), 'key' => base64_encode($key)]) !!}" style="padding:10px; background-color:#3276B1; color:#EEE; border-radius: 4px; text-decoration: none; font-weight: bold;">Valider le compte</a>
    </p>
@stop
