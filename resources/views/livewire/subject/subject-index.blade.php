<?php

use Livewire\Volt\Component;

new class extends Component {

}; ?>

<div>
    @section('toolbar')
    @role("Super-Admin")
    <x-modal-button name="Add Subject" modal="createSubjectModal" />
    @endrole
    @endsection
   
    <div class="card">
        <div class="card-body pt-0">
            <br>    
            @role('Super-Admin')
            <livewire:tables.subjectstable/>
            @endrole
            @role("Student")
            <livewire:tables.subjectstable :userId="auth()->user()->id"/>
            @endrole
            @role ("Lecturer")
            <livewire:tables.subjectstable :lecturerId="auth()->user()->id"/>
            @endrole
        </div>
    </div>
    
    @role("Super-Admin")
    <livewire:subject.subject-modal />
    @endrole
</div>
