@extends('emails.layout')

@section('content')
<h2 class="size-30" style="Margin-top: 0;Margin-bottom: 16px;font-style: normal;font-weight: normal;color: #fff;font-size: 26px;line-height: 34px;" lang="x-size-30">
    Willkommen bei Photo-Wiki!
</h2>

<p style="Margin-top: 0;Margin-bottom: 20px;">
    Bitte klicke den nachfolgenden Link um deine Registrierung abzuschließen.
</p>
<p style="Margin-top: 0;Margin-bottom: 20px;">
    <a href="{{ $link = route('auth.get.verification', $user->verification_token) . '?email=' . urlencode($user->email) }}" style="color: #FFFFFF;">
        {{ $link }}
    </a>
</p>
<p style="Margin-top: 0;Margin-bottom: 20px;">
    Wir freuen uns dich bei uns begrüßen zu dürfen und wünschen dir viel Spaß! Solltest du bei irgendwas einmal Probleme haben melde dich doch einfach bei uns.
</p>
@endsection