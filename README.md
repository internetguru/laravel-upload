# Laravel Upload Component

A modern, drag-and-drop file upload component for Laravel applications using Livewire and Alpine.js with Bootstrap 5.3 styling.

## Features

- 🎯 **Drag & Drop** - Intuitive drag-and-drop interface
- 📱 **Responsive** - Mobile-friendly design
- 🎨 **Bootstrap 5.3** - Modern styling with Bootstrap components
- ⚡ **Livewire** - Real-time file processing without page refresh
- 🏔️ **Alpine.js** - Lightweight JavaScript interactions
- 🌍 **Multilingual** - Support for multiple languages (EN/CS included)
- 📁 **Single File Upload** - Clean single file upload with named storage
- 🛡️ **Validation** - File type and size validation
- 🗂️ **Storage** - Configurable storage disks and paths
- 🔒 **Named Files** - Files stored with custom names for easy identification

## Installation

Install the package via Composer:

```bash
composer require internetguru/laravel-upload
```

The package will be automatically registered via Laravel's service provider discovery.

## Usage

### Basic Usage in Forms

The primary usage is within HTML forms. The component automatically generates hidden fields for uploaded files:

```html
<form action="/submit" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Upload Document</label>
        <livewire:upload name="document" />
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
```

### Advanced Usage

Customize the component with parameters:

```html
<form action="/submit" method="POST">
    @csrf

    <livewire:upload
        name="avatar"
        max-file-size="5"
        :allowed-extensions="['jpg', 'png']"
        disk="local"
        path="avatars"
    />

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
```

### Form Data Access

In your controller, access the uploaded file paths:

```php
public function store(Request $request)
{
    $filePath = $request->input('document'); // Single file path

    // Process your file...
}
```

### Listening to Upload Events

You can listen to file upload events in your parent Livewire component:

```php
class MyComponent extends Component
{
    protected $listeners = ['fileUploaded' => 'handleFileUploaded'];

    public function handleFileUploaded($fileData)
    {
        // Handle the uploaded file data
        // $fileData contains: name, path, size, type, url

        // Save to database, send notifications, etc.
    }
}
```
