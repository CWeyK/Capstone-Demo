<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <livewire:auth.profile.overview />
    <livewire:auth.profile.update-profile-information-form :user="Auth::user()"/>
    <livewire:auth.profile.sign-in-method :user="Auth::user()"/>
</div>
