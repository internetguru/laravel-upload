<?php

namespace InternetGuru\LaravelUpload\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;

    public $file;
    public $uploadedFiles = [];

    #[Locked]
    public $name;

    #[Locked]
    public $maxFileSize = 3; // MB

    #[Locked]
    public $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt'];

    #[Locked]
    public $multiple = false;

    #[Locked]
    public $disk = 'public';

    #[Locked]
    public $path = 'uploads';

    public $showProgress = false;

    protected $listeners = ['fileUploaded' => 'handleFileUploaded'];

    public function mount($name, $maxFileSize = 3, $allowedExtensions = null, $disk = 'public', $path = 'uploads')
    {
        $this->name = $name;
        $this->maxFileSize = $maxFileSize;
        $this->allowedExtensions = $allowedExtensions ?? $this->allowedExtensions;
        $this->disk = $disk;
        $this->path = $path;
    }

    public function updatedFile()
    {
        if (!$this->file) {
            return;
        }

        // Handle case where file might be an array (Livewire file upload behavior)
        $fileToUpload = is_array($this->file) ? reset($this->file) : $this->file;

        if (!$fileToUpload || !method_exists($fileToUpload, 'getClientOriginalExtension')) {
            $this->addError('file', __('ig-upload::upload.invalid_file'));
            return;
        }
        if ($fileToUpload->getSize() > ($this->maxFileSize * 1024 * 1024)) {
            $this->addError('file', __('ig-upload::upload.file_too_large', ['max' => $this->maxFileSize]));
            return;
        }
        $extension = $fileToUpload->getClientOriginalExtension();
        if (!in_array(strtolower($extension), array_map('strtolower', $this->allowedExtensions))) {
            $this->addError('file', __('ig-upload::upload.invalid_file_type', ['types' => implode(', ', $this->allowedExtensions)]));
            return;
        }

        $this->uploadFile($fileToUpload);
        $this->resetErrorBag('file');
        $this->file = null;
    }

    public function uploadFile($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = $this->name . ($extension ? '.' . $extension : '');
        $storedPath = $file->storeAs($this->path, $filename, $this->disk);

        $uploadedFile = [
            'name' => $file->getClientOriginalName(),
            'path' => $storedPath,
            'size' => $file->getSize(),
            'type' => $file->getMimeType(),
            'url' => Storage::disk($this->disk)->url($storedPath),
        ];

        $this->uploadedFiles = [$uploadedFile];

        $this->dispatch('fileUploaded', $uploadedFile);
    }

    public function removeFile($index = 0)
    {
        if (! isset($this->uploadedFiles[$index])) {
            return;
        }
        $file = $this->uploadedFiles[$index];

        Storage::disk($this->disk)->delete($file['path']);
        $this->uploadedFiles = [];
    }

    public function getUploadedFilePaths()
    {
        return array_column($this->uploadedFiles, 'path');
    }

    public function render()
    {
        return view('upload::livewire.upload');
    }

}
