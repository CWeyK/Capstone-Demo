@props([
    'options' => null,
    'placeholder' => null,
    'modal' => null,
    'control' => 'data-select2',
    'clear' => false,
    'search' => true,
    'live' => true,
    'multiple' => false,
])

<div wire:ignore>
    <select {{ $attributes->merge(['class' => 'form-select']) }} id="{{ $attributes->get('id') }}"
        data-control="{{ $control }}" data-placeholder="{{ $placeholder }}" data-allow-clear="{{ $clear }}"
        data-search="{{ $search }}" data-live="{{ $live }}""
        @if ($multiple) multiple @endif
        @if ($modal) data-dropdown-parent="#{{ $modal }}" @endif>
        <option></option>
        @foreach ($options as $key => $option)
            <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
    </select>
</div>

@once
    @push('scripts')
        <script data-navigate-once>
            function initializeSelect2(element) {
                element.select2({
                    'placeholder': '{{ $placeholder }}',
                    'allowClear': '{{ $clear }}',
                    'minimumResultsForSearch': '{{ $search ? 0 : -1 }}',
                });

                element.trigger('change.select2');

                element.on('change', function(e) {
                    const model = $(this).attr('wire:model');
                    if (model) {
                        const componentId = $(this).closest('[wire\\:id]').attr('wire:id');
                        const value = $(this).val();
                        window.Livewire.find(componentId).set(model, value);
                    }
                });
            }

            function updateSelect2Options(element, options) {
                element.empty();
                element.append('<option></option>');

                $.each(options, function(key, value) {
                    element.append(new Option(value, key));
                });

                element.trigger('change');
            }

            function initializeAllSelect2() {
                initializeSelect2($('[data-control="data-select2"]'));
            }

            document.addEventListener('livewire:navigated', () => {
                setTimeout(() => {
                    initializeAllSelect2();
                }, 100);
            });

            document.addEventListener("initSelect2", () => {
                setTimeout(() => {
                    initializeAllSelect2();
                }, 100);
            });

            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    initializeAllSelect2();
                }, 100);
            });

            window.addEventListener('initialize-new-select2', function(event) {
                const newElement = $(event.detail.selector);
                if (newElement.length) {
                    initializeSelect2(newElement, event.detail.allowSearch, event.detail.deferUpdate);
                } else {
                    console.error('Element not found for selector:', event.detail.selector);
                }
            });

            window.addEventListener('select2-options-updated', function(event) {
                const data = event.detail.data;
                const select2 = $('#' + event.detail.selectId);
                const selectedId = event.detail.selectedId || select2.val();
                if (select2.length) {
                    console.log('Updating select2 options:', data);
                    updateSelect2Options(select2, data);

                    // if (selectedId !== undefined && selectedId !== null) {
                    //     select2.val(selectedId).trigger('change');
                    // }
                    if(selectedId !== null) {
                        select2.val(selectedId).trigger('change');
                        console.log('Restored selected value:', selectedId);
                    }
                }
            });
        </script>
    @endpush
@endonce
