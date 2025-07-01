<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

new #[Layout('components.layouts.empty')]       // <-- Here is the `empty` layout
    #[Title('Login')]
    class extends Component {

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    public function mount()
    {
        // It is logged in
        if (auth()->user()) {
            return redirect('/');
        }
    }

    public function login()
    {
        $credentials = $this->validate();

        if (auth()->attempt($credentials)) {
            request()->session()->regenerate();

            $user = auth()->user();

            if ($user->role === 'user') {
                session([
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'phone' => $user->phone,
                        'email' => $user->email,
                    ]
                ]);
                return redirect('/budgets');
            }
            return redirect()->intended('/dashboard');
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }
}; ?>

<div>
    <x-form wire:submit="login">
        <x-input label="E-mail" wire:model="email" icon="o-envelope" inline />
        <x-input label="Password" wire:model="password" type="password" icon="o-key" inline />

        <x-slot:actions>
            {{-- <x-button label="Create an account" class="btn-ghost" link="/register" /> --}}
            <x-button label="LOGIN" type="submit" icon="o-lock-closed" class="btn-primary" spinner="login" />
        </x-slot:actions>
    </x-form>
</div>