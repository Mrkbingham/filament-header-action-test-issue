<?php

use App\Filament\Resources\Customers\Pages\EditCustomer;
use App\Models\Customer;
use Filament\Actions\DeleteAction;
use Filament\Actions\Testing\TestAction;

use function Pest\Livewire\livewire;

it('cannot delete customer without confirmation - action class', function () {
    // Create a customer
    $customer = Customer::factory()->create([
        'name' => 'Non-Deletable Customer',
    ]);

    // Try to delete the customer
    livewire(EditCustomer::class, [
        'record' => $customer->id,
    ])
        ->assertActionExists(DeleteAction::class)
        ->mountAction(DeleteAction::class)
        ->assertActionMounted(DeleteAction::class)
        ->assertSee('Are you sure you want to delete this customer?');
});

it('cannot delete customer without confirmation - test actions', function () {
    // Create a customer
    $customer = Customer::factory()->create([
        'name' => 'Non-Deletable Customer',
    ]);

    // Try to delete the customer
    livewire(EditCustomer::class, [
        'record' => $customer->id,
    ])
        ->assertActionExists(TestAction::make(DeleteAction::class))
        ->mountAction(TestAction::make(DeleteAction::class))
        ->assertActionMounted(TestAction::make(DeleteAction::class))
        ->assertSee('Are you sure you want to delete this customer?');
});
