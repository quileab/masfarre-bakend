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

  // Table headers
  public function headers(): array
  {
    return [
      ['key' => 'avatar', 'label' => '', 'class' => 'w-1'],
      ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
      ['key' => 'name', 'label' => 'Name', 'class' => 'w-64'],
      ['key' => 'role', 'label' => 'Role', 'class' => 'w-32'],
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
      ->paginate(20);

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
  <x-header title="Usuarios" separator progress-indicator>
    <x-slot:middle class="!justify-end">
      <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
    </x-slot:middle>
    <x-slot:actions>
      <x-badge value="{{ $records_count }}" class="badge-primary" />
      <x-button label="Nuevo" icon="o-plus" link="/user" class="btn-primary" />
    </x-slot:actions>
  </x-header>

  <!-- TABLE  -->
  <x-card>
    <x-table :headers="$headers" :rows="$users" :sort-by="$sortBy" link="user/{id}" with-pagination>
      @scope('cell_avatar', $user)
      <x-avatar image="{{ $user->avatar ?? 'assets/images/empty-' . $user->role . '.jpg' }}" class="!w-10" />
      @endscope
    </x-table>
  </x-card>

</div>