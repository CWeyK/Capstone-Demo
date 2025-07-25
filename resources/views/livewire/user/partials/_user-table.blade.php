<?php

use Livewire\Volt\Component;


new class extends Component {


}; ?>

<div>
    <div class="d-flex align-items-center">
        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
            <img src={{ $row->profileImg() }} class="rounded"/>
        </div>
        <div class="d-flex flex-column">
            <strong>{{ $row->name }}</strong>
            <small>{{ $row->email }}</small>
        </div>
    </div>

</div>
