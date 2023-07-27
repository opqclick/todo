<x-mail::message>
    Hello {{ $task->assigned_to }},

    You have been assigned a new task:
    Task Name: {{ $task->title }}
    Task Description: {{ $task->description }}
    Task Deadline: {{ $task->deadline }}

<x-mail::button :url="''">
    Please complete the task within the given timeframe.
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

