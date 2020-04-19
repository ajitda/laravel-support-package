@component('mail::message')

{!!$message!!}
@if(!empty($button))
@component('mail::button', ['url' => $button['url']])
{{$button['text']}}
@endcomponent
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
