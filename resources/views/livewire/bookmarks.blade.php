<?php
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $sessionsToShow = ['user'];

    #[On('bookmark')]
    public function updateBookmarks(string $name, array $bookmarks)
    {
        if ($bookmarks == []) {
            session()->forget($name);
            return;
        }
        session()->put($name, $bookmarks);
    }
}; ?>

<div>
    {{-- if user is admin show --}}
    @if(auth()->user()->role == "admin")
        @foreach($sessionsToShow as $key => $session)
            @if (session()->has($session))
                <x-icon name="s-user-circle" label="{{ session()->get($session)['name'] }}" class="text-primary" />
            @endif
        @endforeach
    @endif
</div>