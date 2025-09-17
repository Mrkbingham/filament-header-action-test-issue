<?php

use App\Filament\Resources\Customers\Pages\EditCustomer;
use App\Models\Customer;
use Filament\Actions\Testing\TestAction;

use function Pest\Livewire\livewire;

it('cannot delete customer without confirmation', function () {
    // Create a customer
    $customer = Customer::factory()->create([
        'name' => 'Non-Deletable Customer',
    ]);

    // Try to delete the customer
    livewire(EditCustomer::class, [
        'record' => $customer->id,
    ])->mountAction(TestAction::make(DeleteAction::class))
        ->assertSee('You cannot delete this customer because it is linked to inventory items and recipes.')
        ->assertSee('Use the form at the bottom of this page to see which items need to be un-linked before deleting this customer.');
});
