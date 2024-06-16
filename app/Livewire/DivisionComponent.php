<?php

namespace App\Livewire;

use App\Models\Division;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;

class DivisionComponent extends Component
{
    use InteractsWithBanner;

    public $name;
    public $deleteName = null;
    public $creating = false;
    public $editing = false;
    public $confirmingDeletion = false;
    public $selectedId = null;

    protected $rules = [
        'name' => ['required', 'string', 'max:255', 'unique:divisions'],
    ];

    public function showCreating()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->creating = true;
    }

    public function create()
    {
        $this->validate();
        Division::create(['name' => $this->name]);
        $this->creating = false;
        $this->name = null;
        $this->banner(__('Created successfully.'));
    }

    public function edit($id)
    {
        $this->resetErrorBag();
        $this->editing = true;
        $division = Division::find($id);
        $this->name = $division->name;
        $this->selectedId = $id;
    }

    public function update()
    {
        $this->validate();
        $division = Division::find($this->selectedId);
        $division->update(['name' => $this->name]);
        $this->editing = false;
        $this->selectedId = null;
        $this->banner(__('Updated successfully.'));
    }

    public function confirmDeletion($id, $name)
    {
        $this->deleteName = $name;
        $this->confirmingDeletion = true;
        $this->selectedId = $id;
    }

    public function delete()
    {
        $division = Division::find($this->selectedId);
        $division->delete();
        $this->confirmingDeletion = false;
        $this->selectedId = null;
        $this->deleteName = null;
        $this->banner(__('Deleted successfully.'));
    }

    public function render()
    {
        $divisions = Division::all();
        return view('livewire.division', ['divisions' => $divisions]);
    }
}
