<?php

use Livewire\Volt\Component;


new class extends Component {


}; ?>

<div>
    @foreach($row->roles as $role)
        @php
            $badge = match($role->name) {
                'Super-Admin' => 'danger',
                'Administrator' => 'primary',
                'Agent' => 'info',
                'Manager' => 'success',
            };
        @endphp
        <a href="{{ route('admin.roles.show', $role->id) }}" class="badge badge-light-{{ $badge }} fs-7 m-1" wire:navigate>{{ $role->name }}</a>
    @endforeach
</div>
