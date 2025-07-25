<?php

use Livewire\Volt\Component;


new class extends Component {

}; ?>

<div>
    @section('title', 'Permissions')
    @section('breadcrumbs')
    {{ Breadcrumbs::render('permission') }}
    @endsection

    <div class="card">
        <div class="card-body pt-0">
            <br>    
            <livewire:tables.permissionstable/>
        </div>
    </div>
        
</div>
