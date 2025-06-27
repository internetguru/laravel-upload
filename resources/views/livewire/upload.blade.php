<div class="upload-component"
     x-data="{
         dragActive: false,
         files: [],
         handleDrop(e) {
             this.dragActive = false;
             const files = Array.from(e.dataTransfer.files);
             if (files.length > 0) {
                 e.preventDefault();
                 // Only take the first file for single file upload
                 const file = files[0];
                 // Use the file input to trigger Livewire's file upload handling
                 const fileInput = this.$refs.fileInput;
                 const dataTransfer = new DataTransfer();
                 dataTransfer.items.add(file);
                 fileInput.files = dataTransfer.files;
                 // Trigger the change event to activate Livewire file upload
                 fileInput.dispatchEvent(new Event('change', { bubbles: true }));
             }
         },
         handleDragOver(e) {
             e.preventDefault();
             this.dragActive = true;
         },
         handleDragLeave(e) {
             e.preventDefault();
             this.dragActive = false;
         }
     }"
     x-on:drop="handleDrop($event)"
     x-on:dragover="handleDragOver($event)"
     x-on:dragleave="handleDragLeave($event)">

    <div class="upload-area"
         :class="{ 'drag-active': dragActive }"
         wire:loading.class="uploading">

        <!-- Upload Zone -->
        <div class="upload-zone border-2 border-dashed border-secondary bg-light text-center p-4"
             x-on:click="$refs.fileInput.click()"
             :class="{ 'border-primary bg-primary-subtle': dragActive, 'has-files': {{ count($uploadedFiles) > 0 ? 'true' : 'false' }} }">

            @if(count($uploadedFiles) === 0)
                <!-- Empty state -->
                <x-upload::empty-state />
            @else
                <!-- Files uploaded state -->
                <div class="upload-files-state">
                    <div class="upload-icon mb-3">
                        <i class="fa-solid fa-2x fa-cloud-upload-alt text-secondary"></i>
                    </div>
                    <div class="uploaded-files-inside">
                        @foreach($uploadedFiles as $index => $file)
                            <div class="uploaded-file-item d-flex justify-content-between align-items-center px-2 py-1 bg-white rounded shadow-sm mb-2">
                                <div class="file-info d-flex align-items-center">
                                    <div class="file-icon me-3">
                                        <i class="fa-solid fa-file text-primary"></i>
                                    </div>
                                    <div>
                                        <span class="file-name fw-medium">{{ $file['name'] }}</span>
                                        <small class="text-muted d-block text-start">
                                            {{ number_format($file['size'] / 1024, 2) }} KB
                                        </small>
                                    </div>
                                </div>
                                <button type="button"
                                        wire:click.stop="removeFile({{ $index }})"
                                        class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div class="upload-again-text mt-3">
                        <small>
                            {{ __('ig-upload::upload.click_to_replace') }}
                        </small>
                    </div>
                </div>
            @endif

            <input type="file"
                   x-ref="fileInput"
                   wire:model="file"
                   accept="{{ implode(',', array_map(fn($ext) => '.' . $ext, $allowedExtensions)) }}"
                   style="display: none;">
        </div>

        <!-- File Requirements -->
        {{-- <div class="upload-requirements">
            <small class="text-muted">
                {{ __('ig-upload::upload.max_file_size') }}: {{ $maxFileSize }}MB<br>
                {{ __('ig-upload::upload.allowed_types') }}: {{ implode(', ', $allowedExtensions) }}
            </small>
        </div> --}}
    </div>

    <!-- Hidden form fields for uploaded files -->
    @if(count($uploadedFiles) > 0)
        <input type="hidden" name="{{ $name }}-tmp" value="{{ $uploadedFiles[0]['path'] ?? '' }}">
    @endif

    <!-- Error Messages -->
    @error('file')
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
