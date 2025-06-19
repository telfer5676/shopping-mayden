<div>
    <div class="grid grid-flow-col grid-columns-3 gap-4 mb-6">
        <div class="flex items-center justify-between rounded-xl bg-gray-200/10 dark:bg-white/10 border border-gray-700/10 dark:border-white/10 p-6">
            <flux:heading>Total budget</flux:heading>
            <flux:text>£{{$budget}}</flux:text>
        </div>

        <div class="flex items-center justify-between rounded-xl bg-gray-200/10 dark:bg-white/10 border border-gray-700/10 dark:border-white/10 p-6">
            <flux:heading>Total cost</flux:heading>
            <flux:text>£{{$total}}</flux:text>
        </div>

        <!-- change display for budget here -->
        <div class="flex items-center justify-between rounded-xl bg-gray-200/10 dark:bg-white/10 border border-gray-700/10 dark:border-white/10 p-6">
            <flux:heading>Total difference</flux:heading>
            
            @if($difference < 0)
                <flux:badge color="red" size="lg">£{{$differenceOver}}</flux:badge>
            @else
                <flux:badge color="green" size="lg">£{{$difference}}</flux:badge>
            @endif

        </div>
    </div>

    @if($difference < 0)
        <flux:badge color="red" size="lg" icon="exclamation-triangle" class="mb-4">You have gone over your budget!</flux:badge>
    @endif

    <div x-data="{ expanded: false }">
        <div class="flex items-center gap-4 mb-4">
            <flux:text><strong>You have purchased {{$itemsCompleteCount}} items</flux:text>
            <button type="button" x-on:click="expanded = ! expanded">
                <span class="text-sm" x-show="! expanded">Show</span>
                <span class="text-sm" x-show="expanded">Hide</span>
            </button>
        </div>

        <flux:separator class="mb-6" />
 
        <div x-show="expanded">
            <ul id="shoppingComplete" class="mb-6">
                @foreach($itemsComplete as $item)
                <li class="flex items-center gap-8">
                    <div class="w-80"><flux:text>{{$item->name}}</flux:text></div>
                    <div class="w-12"><flux:text>£{{$item->price}}</flux:text></div>
                    <div><flux:button wire:click="delete({{$item->id}})" size="sm" icon="x-mark" variant="subtle" square></flux:button></div>
                </li>
                @endforeach
            </ul>
        </div>
    </div> 

    <ul id="shoppingList" class="mb-6">
        @foreach($itemsList as $item)
        <li data-id="{{$item->id}}" class="flex items-center gap-8">
            <div class="handle"><flux:icon.grip-vertical /></div>
            <div class="w-80"><flux:text>{{$item->name}}</flux:text></div>
            <div class="w-12"><flux:text>£{{$item->price}}</flux:text></div>
            <div><flux:button wire:click="complete({{$item->id}})" size="sm" icon="check" square></flux:button></div>
            <div><flux:button wire:click="delete({{$item->id}})" size="sm" icon="x-mark" variant="subtle" square></flux:button></div>
        </li>
        @endforeach
    </ul>

    <form wire:submit="add">
        <div class="flex gap-4">
            <flux:field>
                <flux:input wire:model="name" type="text" placeholder="Apples" />

                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:input wire:model="price" type="text" placeholder="2.50" />

                <flux:error name="price" />
            </flux:field>

            <flux:button type="submit">Add Item</flux:button>
        </div>

        <flux:input wire:model="order" type="hidden" />
    </form>
</div>
