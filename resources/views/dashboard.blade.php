<x-layouts.app :title="__('Dashboard')">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item>Home</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:separator class="mb-6" />
    
    <livewire:shopping-summary />
</x-layouts.app>
