<?php

use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

new class extends Component {
  use Toast;
  use WithPagination;

  public string $search = '';
  public int $records_count = 0;
  public bool $drawer = false;
  public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

  // Clear filters
  public function clear(): void
  {
    $this->reset();
    $this->resetPage();
    $this->success('Filters cleared.', position: 'toast-bottom');
  }

  // Delete action
  public function delete(User $user): void
  {
    $user->delete();
    $this->warning("$user->name deleted", 'Good bye!', position: 'toast-bottom');
  }

  // Table headers
  public function headers(): array
  {
    return [
      ['key' => 'avatar', 'label' => '', 'class' => 'w-1'],
      ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
      ['key' => 'name', 'label' => 'Name', 'class' => 'w-64'],
      ['key' => 'email', 'label' => 'E-mail', 'sortable' => false]
    ];
  }

  /**
   * On real projects you do it with Eloquent collections.
   * Please, refer to maryUI docs to see the eloquent examples.
   */
  public function users(): LengthAwarePaginator
  {
    $result = User::query()
      ->when($this->search, fn($q) => $q->where('name', 'like', "%$this->search%"))
      ->orderBy(...array_values($this->sortBy))
      ->paginate(5);

    $this->records_count = $result->total();

    return $result;
  }

  public function with(): array
  {
    return [
      'users' => $this->users(),
      'headers' => $this->headers(),
    ];
  }

  // Reset pagination when any component property changes
  public function updated($property): void
  {
    if (!is_array($property) && $property != '') {
      $this->resetPage();
    }
  }
}; ?>

<div>
  <!-- HEADER -->
  <x-header title="Hello" separator progress-indicator>
    <x-slot:middle class="!justify-end">
      <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
    </x-slot:middle>
    <x-slot:actions>
      <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
      <x-badge value="{{ $records_count }}" class="badge-primary" />
    </x-slot:actions>
  </x-header>

  <!-- TABLE  -->
  <x-card>
    <x-table :headers="$headers" :rows="$users" :sort-by="$sortBy" link="users/{id}/edit" with-pagination>
      @scope('cell_avatar', $user)
      <x-avatar image="{{ $user->avatar ?? '/empty-user.jpg' }}" class="!w-10" />
      @endscope
      @scope('actions', $user)
      <x-button icon="o-trash" wire:click="delete({{ $user['id'] }})" wire:confirm="Are you sure?" spinner
        class="btn-ghost btn-sm text-red-500" />
      @endscope
    </x-table>
  </x-card>

  <!-- FILTER DRAWER -->
  <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
    <div class="grid gap-5">
      <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass"
        @keydown.enter="$wire.drawer = false" />

    </div>

    <x-slot:actions>
      <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
      <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
    </x-slot:actions>
  </x-drawer>
</div>