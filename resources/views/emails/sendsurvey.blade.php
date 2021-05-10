@component('mail::message')
# Greetings of peace and prosperity!

@component('mail::panel')
We would appreciate it if you could take some time to complete the survey below.
@endcomponent


@component('mail::button', ['url' => 'https://docs.google.com/forms/d/e/1FAIpQLSemZhHb4mz99oW8OrhS5-Iv8HUmPZTClP1O6xUIwQVX_BaFqQ/viewform', 'color' => 'success'])
GO TO SURVEY
@endcomponent

## Thank you very much!

---
If the button above does not work, you may copy and paste this link to your browser.
@component('mail::panel')
https://docs.google.com/forms/d/e/1FAIpQLSemZhHb4mz99oW8OrhS5-Iv8HUmPZTClP1O6xUIwQVX_BaFqQ/viewform
@endcomponent

@endcomponent
