@props(['inputname'])
<div class="my-2" wire:ignore x-data="{pond: null}" x-init="
        FilePond.registerPlugin(FilePondPluginImagePreview);
        pond = FilePond.create($refs.input);
        pond.setOptions({
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                },
            },
        });

    " x-on:remove-files.window="pond.removeFiles()">
    <input {{ $attributes }} x-cloak type="file" name="{{$inputname}}" x-ref="input">
</div>
