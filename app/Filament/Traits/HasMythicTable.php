<?php

namespace App\Filament\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasMythicTable
{
    public function toggleBoolean($id, $field): void
    {
        $model = $this->getResource()::getModel();
        $record = $model::find($id);
        
        if ($record) {
            $record->{$field} = !$record->{$field};
            $record->save();

            \Filament\Notifications\Notification::make()
                ->title('Status updated successfully')
                ->success()
                ->send();
        }
    }

    protected function getTableContentFooter(): ?\Illuminate\Contracts\View\View
    {
        return null; // Prevent double footer if needed
    }
}
