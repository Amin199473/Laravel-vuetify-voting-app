<x-mail::message>
# Idea Status Updated

The Idea : {{ $idea->title }}

has been updated to status of : {{ $idea->status->name }}
<x-mail::button :url="'http://127.0.0.1:8000/ideas/{{ $idea->slug }}'">
View Idea
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
