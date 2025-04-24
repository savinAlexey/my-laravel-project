<?php

namespace App\Livewire\Admin\Settings\Platforms;

use App\Models\Platform;
use Livewire\Component;

class PlatformManager extends Component
{
    public $platforms;
    public $name, $code, $description;
    public $editingId = null;

    public function mount()
    {
        $this->loadPlatforms();
    }

    public function loadPlatforms()
    {
        $this->platforms = Platform::latest()->get();
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:platforms,code,' . $this->editingId,
            'description' => 'nullable|string',
        ]);

        Platform::updateOrCreate(
            ['id' => $this->editingId],
            $validated
        );

        $this->reset(['name', 'code', 'description', 'editingId']);
        $this->loadPlatforms();
    }

    public function edit($id)
    {
        $platform = Platform::findOrFail($id);
        $this->name = $platform->name;
        $this->code = $platform->code;
        $this->description = $platform->description;
        $this->editingId = $platform->id;
    }

    public function delete($id)
    {
        Platform::findOrFail($id)->delete();
        $this->loadPlatforms();
    }

    public function render()
    {
        return view('livewire.admin.settings.platforms.platform-manager')
            ->layout('layouts.admin');
    }
}

