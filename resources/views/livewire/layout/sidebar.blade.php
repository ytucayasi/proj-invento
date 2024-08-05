<?php

use Livewire\Volt\Component;

new class extends Component {

}; ?>
<nav class="w-80 h-full overflow-hidden select-none">
    <div class="overflow-y-auto h-full px-4 py-6 flex flex-col space-y-6">
        <x-input placeholder="Buscar" />
        <ul class="flex flex-col space-y-2">
            @foreach (config('sidebar') as $group)
                <li
                    cslass="flex w-full h-fit pt-2 dark:border-t-[1px] dark:border-slate-700 border-t-[1px] border-slate-200">
                    <h2 class="text-xs uppercase">{{ $group['title'] }}</h2>
                </li>
                @foreach ($group['links'] as $link)
                    <li class="flex w-full h-fit">
                        <a href="{{ $link['href'] }}"
                            class="w-full ps-2 py-1 border-s-2 border-transparent hover:border-primary-500 hover:text-primary-500 dark:hover:text-primary-300"
                            wire:navigate>{{ $link['label'] }}</a>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>
</nav>