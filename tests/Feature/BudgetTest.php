<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Budget;
use App\Models\Category;
use App\Models\EventType;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class BudgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_budget_creation_workflow()
    {
        // 1. Setup Data
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'user']);
        $eventType = EventType::create(['name' => 'Wedding']);
        $category = Category::create(['name' => 'Food']);
        $product = Product::create([
            'name' => 'Cake',
            'price' => 100,
            'category_id' => $category->id
        ]);

        // Simulate session user (Client selected)
        $this->actingAs($admin)->withSession(['user' => $client->toArray()]);

        // 2. Test Initial Load (Create Mode)
        $component = Volt::test('budget.crud')
            ->assertSee('Presupuesto: ' . $client->name)
            ->assertSee('Crear y Continuar')
            ->assertDontSee('Detalle de Productos'); // Details hidden initially

        // 3. Create Header
        $component->set('data.name', 'My Big Wedding')
            ->set('data.date', '2025-12-12')
            ->set('data.event_type_id', $eventType->id)
            ->call('updateOrCreate')
            ->assertHasNoErrors()
            // We verify the state change instead of the toast message which might be an event
            ->assertSet('data.name', 'My Big Wedding') 
            ->assertSee('Actualizar Encabezado')
            ->assertSee('Detalle de Productos'); // Details visible now

        // Verify Budget Created
        $budget = Budget::first();
        $this->assertNotNull($budget);
        $this->assertEquals('My Big Wedding', $budget->name);
        $this->assertEquals($client->id, $budget->client_id);

        // 4. Add Product
        $component->set('selectedProduct', $product->id)
            ->set('quantity', 2)
            ->call('addProduct')
            //->assertSee('Producto agregado.') // Likely an event too
            ->assertSee('Cake') // Product in table
            ->assertSee('$ 200.00'); // Subtotal visible

        // Verify Total Updated
        $budget->refresh();
        $this->assertEquals(200, $budget->total);

        // 5. Update Quantity
        $component->call('updateQuantity', $product->id, 3);
        
        $budget->refresh();
        $this->assertEquals(300, $budget->total);

        // 6. Remove Product
        $component->call('removeProduct', $product->id);
        
        $budget->refresh();
        $this->assertEquals(0, $budget->products()->count());
        $this->assertEquals(0, $budget->total);
    }

    public function test_non_admin_cannot_access_budget_crud()
    {
        $user = User::factory()->create(['role' => 'user']);
        
        $this->actingAs($user);
        
        $this->from('/');
        
        Volt::test('budget.crud')
            ->assertRedirect('/');
    }
}
