<x-mail::message>

Hello,

Thank you for participating. Please click the button below to be taken to the secure voting page.

This link is valid for 30 minutes.

<x-mail::button :url="$url">
    Go to Voting Page
</x-mail::button>

If you did not request this link, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
