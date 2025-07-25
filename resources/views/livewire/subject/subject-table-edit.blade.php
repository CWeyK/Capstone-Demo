<?php

use Livewire\Volt\Component;


new class extends Component {


}; ?>

<div>
    <x-modal-button name="Update Grouping" modal="updateGroupingModal" icon="" wire:click="$dispatch('editGrouping', { id : {{ $row }}, subject : {{ $subject }}})"/>
</div>

