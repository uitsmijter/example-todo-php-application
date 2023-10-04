@props(['todos' => []])

@forelse ($todos as $todo)
    <div class="shadow-md px-6 py-4">
        <div class="mt-4 mb-4 text-sm text-gray-600 relative">
            {{ $todo->name }}
            @if ($todo->user)
                <span class="absolute top-0 right-0">by {{ $todo->user?->name }}</span>
            @endif
        </div>

        @if (!$todo->done)
            <form method="POST" action="{{ route('todo.update', ['todo' => $todo]) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="name" value="{{ $todo->name }}">

                <div class="flex items-center justify-end mt-4">
                    <input type="checkbox" name="done" value="1" {{ $todo->done ? 'checked' : '' }} onChange="submit()">
                    <!--
                    <x-primary-button class="ml-3" name="done" value="1">
                        {{ __('Done') }}
                    </x-primary-button>
                    -->
                </div>
            </form>
        @endif
    </div>
@empty
    {{ __('Create your first ToDo!') }}
@endforelse
