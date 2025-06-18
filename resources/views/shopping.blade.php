<x-layouts.app :title="__('Shopping')">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">Home</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Shopping</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:separator class="mb-6" />
    
    <livewire:shopping-list />

    <form id="shoppingOrder" method="POST" action="/order" style="display: none">
        @csrf

        <input id="order" type="text" name="order">
        <!-- Equivalent to... -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    </form>
</x-layouts.app>
