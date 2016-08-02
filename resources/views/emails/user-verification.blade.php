Click here to verify your account:
<a href="{{ $link = route('auth.get.verification', $user->verification_token) . '?email=' . urlencode($user->email) }}">
    {{ $link }}
</a>