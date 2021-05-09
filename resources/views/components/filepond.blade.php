@props(['inputname'])
<div
    class="my-2 border border-primary-600"
    wire:ignore
    x-data="{pond: null}"
    x-init="
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        pond = FilePond.create($refs.input);
        pond.setOptions({
            labelFileProcessingError: 'Error during upload. Make sure the filename does not exceed 150 characters.',
            maxFileSize: '20MB',
            allowMultiple: {{
        isset($attributes['multiple']) ? 'true' : 'false'
    }},
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{
        $attributes['wire:model']
    }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{
        $attributes['wire:model']
    }}', filename, load)
                },
            },
        });
        pond.onerror = ((error, file, status) => {
            console.log(file.source.name.length);
            if(file.source.name.length > 150) Livewire.emit('filenameTooLong');
        });

    "
    x-on:remove-files.window="pond.removeFiles()"
>
    <input
        {{
        $attributes
        }}
        x-cloak
        type="file"
        name="{{ $inputname }}"
        x-ref="input"
    />
    <!-- if(file.source.name.length > 150) @this.emitSelf('filenameTooLong'); -->
</div>
@once @push('scripts')
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
@endpush @endonce
