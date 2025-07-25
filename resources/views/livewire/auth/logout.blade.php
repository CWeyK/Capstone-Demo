<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/hub/login', navigate: true);
    }
}; ?>

<div>
    <div class="menu-item px-5">
        <a href="javascript:void(0)" wire:click="logout" class="menu-link px-5">Sign Out</a>
    </div>
</div>
