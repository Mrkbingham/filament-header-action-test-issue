<?php

use App\Filament\Resources\Customers\Pages\EditCustomer;
use App\Models\Customer;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\HtmlString;

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
        ->assertHasNoFormErrors()
        ->assertActionExists(DeleteAction::class, checkActionUsing: function (Action $action) {
            // Ensure the modal is properly set up
            expect($action->getModalContent()->toHtml())->toBe('Header modal content');

            return true;
        })
        ->mountAction(DeleteAction::class)
        // ->callAction(DeleteAction::class)
        ->assertActionMounted(DeleteAction::class)
        ->assertSee('Header modal content');
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
        ->assertHasNoFormErrors()
        ->assertActionExists(TestAction::make(DeleteAction::class), checkActionUsing: function (Action $action) {
            // Ensure the modal is properly set up
            expect($action->getModalContent()->toHtml())->toBe('Header modal content');

            return true;
        })
        ->mountAction(TestAction::make(DeleteAction::class))
        // ->callAction(TestAction::make(DeleteAction::class))
        ->assertActionMounted(TestAction::make(DeleteAction::class))
        ->assertSee('Header modal content');
});

it('cannot delete customer without confirmation - form delete action', function () {
    // Create a customer
    $customer = Customer::factory()->create([
        'name' => 'Non-Deletable Customer',
    ]);

    // Try to delete the customer
    livewire(EditCustomer::class, [
        'record' => $customer->id,
    ])
        ->assertHasNoFormErrors()
        // This fails - but the action should be accessible?
        ->assertActionExists(TestAction::make('formDeleteAction'), checkActionUsing: function (Action $action) {
            // Ensure the modal is properly set up
            expect($action->getModalContent()->toHtml())->toBe('Form action modal content');

            return true;
        })
        ->mountAction(TestAction::make('formDeleteAction'))
        // ->callAction(TestAction::make('formDeleteAction'))
        ->assertActionMounted(TestAction::make('formDeleteAction'))
        ->assertSee('Form action modal content');
});

it('cannot delete customer without confirmation - nested form delete action', function () {
    // Create a customer
    $customer = Customer::factory()->create([
        'name' => 'Non-Deletable Customer',
    ]);

    // Try to delete the customer
    livewire(EditCustomer::class, [
        'record' => $customer->id,
    ])
        ->assertHasNoFormErrors()
        ->assertActionExists(TestAction::make('nestedFormDeleteAction')->schemaComponent('group'), checkActionUsing: function (Action $action) {
            // Ensure the modal is properly set up
            expect($action->getModalContent()->toHtml())->toBe('Nested form action modal content');

            return true;
        })
        ->mountAction(TestAction::make('nestedFormDeleteAction')->schemaComponent('group'))
        ->assertActionMounted(TestAction::make('nestedFormDeleteAction')->schemaComponent('group'))
        ->assertSee('Nested form action modal content');
});
