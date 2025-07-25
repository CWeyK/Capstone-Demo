<?php

use Livewire\Volt\Component;

new class extends Component {

}; ?>

<div>
    @section('toolbar')
    @role("Super-Admin")
    <x-modal-button name="Add Room" modal="createRoomModal" />
    @endrole
    @endsection
   
    <div class="card">
        <div class="card-body pt-0">
            <br>    
            <livewire:tables.roomstable/>
        </div>
    </div>
    
    @role("Super-Admin")
    <livewire:room.room-modal />
    @endrole
</div>
