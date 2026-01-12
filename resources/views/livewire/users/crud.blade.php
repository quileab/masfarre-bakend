<?php

use Livewire\Volt\Component;
use App\Models\User;
use Mary\Traits\Toast;
//use Livewire\WithFileUploads;

new class extends Component {
    use Toast;//, WithFileUploads;

    public User $user;
    // user attributes name, role (user/admin), email, phone, address, province, password. 

    // #[Rule('nullable|image|max:1024')]
    // public $photo;

    // You could use Livewire "form object" instead.

    public string $name = '';

    public string $role = 'user';
    public $role_id = 1;
    public $changePassword = false;

    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $province = '';
    public string $password = '';
    public string $password_confirmation = '';

    public $id = null;
    public $rules = [
        'id' => 'nullable',
        'name' => 'required',
        'role' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required',
        'province' => 'required',
    ];

    public $roleOptions = [
        ['id' => 1, 'name' => 'user', 'caption' => 'Usuario'],
        ['id' => 2, 'name' => 'admin', 'caption' => 'Administrador'],
    ];

    public function mount(User $user): void
    {
        // set default values if null
        $this->id = $user->exists ? $user->id : null;
        $this->user = $user ?? new User();
        $this->user->phone = $user->phone ?? '';
        $this->user->address = $user->address ?? '';
        $this->user->province = $user->province ?? '';
        $this->role_id = $user->role == 'admin' ? 2 : 1;
        $this->fill($this->user);

        if ($this->user->exists) {
            $this->bookmark();
        }
    }

    public function save(): void
    {
        // id null means new user
        $rules = $this->rules;
        if ($this->id == null || $this->changePassword) {
            // set default id to null
            $rules['password'] = 'required|confirmed';
        }

        // role_id converted to role
        $this->role = $this->role_id == 1 ? 'user' : 'admin';

        $data = $this->validate($rules);
        try {
            $this->user->updateOrCreate(['id' => $this->id], $data);
            $this->success('Guardado con éxito!', redirectTo: '/users');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    // public function save(): void
    // {
    //     $data = $this->validate();// Validate
    //     $this->user->update($data);// Update
    //     // Sync selection 
    //     $this->user->languages()->sync($this->my_languages);
    //     if ($this->photo) {
    //         $url = $this->photo->store('users', 'public');
    public function bookmark(): void
    {
        $data = [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'phone' => $this->user->phone,
            'email' => $this->user->email
        ];

        session()->put('user', $data);

        $this->dispatch('bookmark', 'user', $data);
    }

    public function delete(): void
    {
        $this->user->delete();
        $this->warning("{$this->user->name} deleted", 'Good bye!', position: 'toast-bottom', redirectTo: '/users');
    }
}; ?>

<div>
    <x-header title="Usuario {{ $user->name }}" separator>
        <x-slot:actions>
            @if($user->exists)
                <x-button label="Presupuestos" icon="o-banknotes" link="/budgets?client_id={{ $user->id }}"
                    class="btn-outline btn-info" />
                <x-button label="Pagos" icon="o-currency-dollar" link="/users/{{ $user->id }}/payments"
                    class="btn-outline btn-success" />
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button icon="o-trash" class="btn-outline btn-error" />
                    </x-slot:trigger>
                    <x-button label="Confirmar" icon="o-check" wire:click="delete" spinner
                        class="btn-ghost btn-sm text-red-500" />
                </x-dropdown>
            @endif
        </x-slot:actions>
    </x-header>
    <x-form wire:submit="save">
        {{-- <x-file label="Avatar" wire:model="photo" accept="image/png, image/jpeg">
            <img src="{{ $user->avatar ?? '/empty-user.jpg' }}" class="h-40 rounded-lg" />
        </x-file> --}}
        <div class="grid grid-cols-2 gap-x-4">
            <x-input label="Apellido y Nombre" wire:model="name" />
            <x-group label="Rol" wire:model="role_id" :options="$roleOptions" option-label="caption"
                class="[&:checked]:!btn-primary" />
            <x-input label="Email" wire:model="email" />
            <x-input label="Telefono" wire:model="phone" />
            <x-input label="Dirección" wire:model="address" />
            <x-input label="Provincia" wire:model="province" />
        </div>
        <div class="mt-2">
            @if($this->id)
                <x-toggle label="Cambiar Contraseña" wire:model.live="changePassword" />
            @endif
            @if(!$this->id || $this->changePassword)
                <div class="grid grid-cols-2 gap-x-4">
                    <x-input label="Contraseña" wire:model="password" type="password" />
                    <x-input label="Confirmar Contraseña" wire:model="password_confirmation" type="password"
                        id="password_confirmation" />
                </div>
            @endif
        </div>

        {{-- <x-editor wire:model="bio" label="Bio" hint="The great biography" /> --}}

        <x-slot:actions>
            <x-button label="Volver" link="/users" />
            {{-- The important thing here is `type="submit"` --}}
            {{-- The spinner property is nice! --}}
            <x-button label="Guardar" icon="o-check" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>