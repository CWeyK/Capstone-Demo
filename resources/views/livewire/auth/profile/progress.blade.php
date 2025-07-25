<?php

use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Model;

new class extends Component
{
    public int $profileCompletion = 0;

    public Model $user;

    public function mount(): void
    {
        $this->calculateProfileCompletion();
    }

    public function calculateProfileCompletion(): void
    {
        $user = $this->user;
        $totalFields = 5;
        $profileCompletion = 0;

        // Fields to check for profile completion
        $fieldsToCheck = ['email', 'profile.name', 'profile.phone_number', 'profile.gender', 'profile.date_of_birth'];

        foreach ($fieldsToCheck as $field) {
            if ($this->isFieldCompleted($user, $field)) {
                $profileCompletion++;
            }
        }

        $this->profileCompletion = round(($profileCompletion / $totalFields) * 100);
    }

    private function isFieldCompleted(Model $user, string $field): bool
    {
        $fieldParts = explode('.', $field);
        $value = $user;

        foreach ($fieldParts as $part) {
            if (!isset($value->{$part})) {
                return false;
            }

            $value = $value->{$part};
        }

        return !empty($value);
    }
}; ?>

<div>
    <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
            <span class="fw-semibold fs-6 text-gray-500">Profile Compleation</span>
            <span class="fw-bold fs-6">{{ $profileCompletion }}%</span>
        </div>

        <div class="h-5px mx-3 w-100 bg-light mb-3">
            <div class="bg-success rounded h-5px" role="progressbar" style="width: {{ $profileCompletion }}%;" aria-valuenow="{{ $profileCompletion }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</div>
