<?php

namespace App\Livewire;

use App\Models\Barcode;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;
use Picqer\Barcode\BarcodeGeneratorHTML;

class BarcodeComponent extends Component
{
    use InteractsWithBanner;

    public $deleteName = null;
    public $confirmingDeletion = false;
    public $selectedId = null;

    public function confirmDeletion($id, $name)
    {
        $this->deleteName = $name;
        $this->confirmingDeletion = true;
        $this->selectedId = $id;
    }

    public function delete()
    {
        $barcode = Barcode::find($this->selectedId);
        $barcode->delete();
        $this->confirmingDeletion = false;
        $this->selectedId = null;
        $this->deleteName = null;
        $this->banner(__('Deleted successfully.'));
    }

    public function render()
    {
        $generator = new BarcodeGeneratorHTML();
        $barcodes = Barcode::all()->map(
            fn ($barcode) => $barcode->setAttribute(
                'barcode',
                $generator->getBarcode(
                    $barcode->value,
                    type: $generator::TYPE_CODE_128,
                    height: 75,
                )
            ),
        );
        return view('livewire.barcode', [
            'barcodes' => $barcodes
        ]);
    }
}
