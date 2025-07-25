<?php

use Livewire\Volt\Component;

new class extends Component {

}; ?>

<div>
    @can("Create User")
        @section('toolbar')
        <x-modal-button name="Create User" modal="createUserModal" />
        @endsection
    @endcan
   
    <div class="card">
        <!--Table part-->
        <div class="card-body pt-0">
            <br>    
            <livewire:tables.userstable/>
        </div>
    </div>
    
    @can("Create User")
    <livewire:user.user-modal />
    @endcan
</div>
