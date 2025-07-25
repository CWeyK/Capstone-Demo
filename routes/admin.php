<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('dashboard', 'dashboard.dashboard')
    ->name('dashboard');

Route::prefix('users')->group(function () {
    Volt::route('/', 'user.user-index')->name('users.index')->middleware('role:Super-Admin');
    Volt::route('/profile/{user}/overview', 'user.user-show')->name('users.show')->middleware('role:Super-Admin|Lecturer');
});

Route::prefix('roles')->group(function () {
    Volt::route('/', 'role.role-index')->name('roles.index')->middleware('can:View Role');
    Volt::route('/show/{role}', 'role.role-show')->name('roles.show')->middleware('can:View Role');
});

Route::prefix('permissions')->group(function () {
    Volt::route('/', 'permission.permission-index')->name('permissions.index')->middleware('can:View Permission');
    Volt::route('/show/{permission}', 'permission.permission-show')->name('permissions.show')->middleware('can:View Permission');
});

Route::prefix('programmes')->group(function () {
    Volt::route('/', 'programme.programme-index')->name('programmes.index')->middleware('role:Super-Admin|Lecturer');
    Volt::route('/show/{programme}', 'programme.programme-show')->name('programmes.show')->middleware('role:Super-Admin|Lecturer');
});

Route::prefix('rooms')->group(function () {
    Volt::route('/', 'room.room-index')->name('rooms.index')->middleware('role:Super-Admin|Lecturer');
    Volt::route('/show/{room}', 'room.room-show')->name('rooms.show')->middleware('role:Super-Admin|Lecturer');
});

Route::prefix('subjects')->group(function () {
    Volt::route('/', 'subject.subject-index')->name('subjects.index');
    Volt::route('/show/{subject}', 'subject.subject-show')->name('subjects.show');
});

Route::prefix('enrollments')->group(function () {
    Volt::route('/', 'enrollment.enrollment-index')->name('enrollments.index')->middleware('role:Super-Admin|Student');;
    Volt::route('/show', 'enrollment.enrollment-show')->name('enrollments.show')->middleware('role:Super-Admin|Student');;
});

Route::prefix('scheduling')->group(function () {
    Volt::route('/', 'scheduling.scheduling-index')->name('scheduling.index')->middleware('role:Super-Admin');
});

Route::prefix('account')->group(function () {
    Volt::route('overview', 'auth.overview')
        ->name('account.overview');

    Volt::route('settings', 'auth.setting')
        ->name('account.settings');
});
