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
## License & Commercial Terms

### Open Source License

Copyright © 2026 **Internet Guru**

This software is licensed under the [Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)](http://creativecommons.org/licenses/by-nc-sa/4.0/) license.

> **Disclaimer:** This software is provided "as is", without warranty of any kind, express or implied. In no event shall the authors or copyright holders be liable for any claim, damages or other liability.

---

### Commercial Use

The standard CC BY-NC-SA license prohibits commercial use. If you wish to use this software in a commercial environment or product, we offer **flexible commercial licenses** tailored to:

* Your company size.
* The nature of your project.
* Your specific integration needs.

**Note:** In many instances (especially for startups or small-scale tools), this may result in no fees being charged at all. Please contact us to obtain written permission or a commercial agreement.

**Contact for Licensing:** [info@internetguru.io](mailto:info@internetguru.io)

---

### Professional Services

Are you looking to get the most out of this project? We are available for:

* **Custom Development:** Tailoring the software to your specific requirements.
* **Integration & Support:** Helping your team implement and maintain the solution.
* **Training & Workshops:** Seminars and hands-on workshops for your developers.

Reach out to us at [info@internetguru.io](mailto:info@internetguru.io) — we are more than happy to assist you!
