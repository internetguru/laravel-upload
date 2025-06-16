<?php

namespace InternetGuru\LaravelUpload\View\Components;

use Illuminate\View\Component;

class UploadComponent extends Component
{
    public $maxFileSize;
    public $allowedExtensions;
    public $multiple;
    public $disk;
    public $path;
    public $name;
    public $id;

    public function __construct(
        $maxFileSize = null,
        $allowedExtensions = null,
        $multiple = true,
        $disk = null,
        $path = null,
        $name = 'upload',
        $id = null
    ) {
        $this->maxFileSize = $maxFileSize ?? config('upload.max_file_size', 10);
        $this->allowedExtensions = $allowedExtensions ?? config('upload.allowed_extensions', ['jpg', 'jpeg', 'png', 'pdf']);
        $this->multiple = $multiple;
        $this->disk = $disk ?? config('upload.default_disk', 'public');
        $this->path = $path ?? config('upload.default_path', 'uploads');
        $this->name = $name;
        $this->id = $id ?? uniqid('upload_');
    }

    public function render()
    {
        return <<<'blade'
<div>
    @livewire('upload', [
        'maxFileSize' => $maxFileSize,
        'allowedExtensions' => $allowedExtensions,
        'multiple' => $multiple,
        'disk' => $disk,
        'path' => $path
    ], key($id))
</div>
blade;
    }
}
