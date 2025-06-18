<div>
    <div class="grid grid-flow-col grid-columns-3 gap-4 mb-6">
        <div class="flex items-center justify-between rounded-xl bg-white/10 border border-white/10 p-6">
            <flux:heading>Total budget</flux:heading>
            <flux:text>£{{$budget}}</flux:text>
        </div>

        <div class="flex items-center justify-between rounded-xl bg-white/10 border border-white/10 p-6">
            <flux:heading>Total cost</flux:heading>
            <flux:text>£{{$total}}</flux:text>
        </div>

        <!-- change display for budget here -->
        <div class="flex items-center justify-between rounded-xl bg-white/10 border border-white/10 p-6">
            <flux:heading>Total difference</flux:heading>
            
            @if($difference < 0)
                <flux:badge color="red" size="lg">£{{$differenceOver}}</flux:badge>
            @else
                <flux:badge color="green" size="lg">£{{$difference}}</flux:badge>
            @endif

        </div>
    </div>
</div>
