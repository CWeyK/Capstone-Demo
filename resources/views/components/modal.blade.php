@props([
    'id' => null,
    'title' => null,
    'action' => null,
    'button' => null,
    'defaultButton' => true,
    'header' => true,
    'size' => 'mw-700px',
])

<div wire:ignore.self class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true" data-bs-focus="false">
    <div {{ $attributes->merge(['class' => 'modal-dialog modal-dialog-centered modal-dialog-scrollable '.$size ]) }}>
        <div class="modal-content">
            @if($header)
                <div class="modal-header" id="kt_modal_header">
                    <h2 class="fw-bold">{{ $title ?? '' }}</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary"
                         data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
            @endif
            <div class="modal-body py-10 px-lg-17">
                <form wire:submit.prevent="{{ $action }}">
                    <div class="scroll-y me-n7 pe-7"
                         id="kt_modal_scroll"
                         data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_header"
                         data-kt-scroll-wrappers="#kt_modal_scroll"
                         data-kt-scroll-offset="300px">
                        {{ $slot }}
                    </div>

                    @if($defaultButton)
                        <div class="text-center pt-10">
                            <x-button type="button" class="btn-light me-3"
                                      data-bs-dismiss="modal">{{ __('Discard') }}
                            </x-button>
                            {{ $button }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

@script
    <script data-navigate-once>
        document.addEventListener('livewire:navigated', () => {
            $wire.on('close-modal', () => {
                $('#{{ $id }}').modal('hide');
                $('.modal-backdrop').remove();
            });

            $('#{{ $id }}').on('hidden.bs.modal', function () {
                document.getElementById('kt_app_body').removeAttribute("style");
                @this.call('resetForm');
            });
        }, { once: true })

        window.addEventListener('openModal', function(event) {
            const modalId = event.detail.modal;
            const selectedItems = event.detail.selectedItems;
            const modal = $('#' + modalId);

            Livewire.dispatch('set-selected-items', {
                selectedItems: selectedItems
            });

            modal.modal('show');
        });
    </script>
@endscript
