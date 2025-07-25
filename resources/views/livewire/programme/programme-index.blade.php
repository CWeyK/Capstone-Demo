<?php

use Livewire\Volt\Component;

new class extends Component {

}; ?>

<div>
    @role("Super-Admin")
    @section('toolbar')
    <x-modal-button name="Add Programme" modal="createProgrammeModal" />
    @endsection
    @endrole
   
    <div class="card">
        <div class="card-body pt-0">
            <br>    
            <livewire:tables.programmestable/>
        </div>
    </div>
    
    @role("Super-Admin")
    <livewire:programme.programme-modal />
    @endrole
</div>
