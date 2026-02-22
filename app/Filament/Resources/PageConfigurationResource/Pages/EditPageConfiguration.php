<?php

namespace App\Filament\Resources\PageConfigurationResource\Pages;

use App\Filament\Resources\PageConfigurationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPageConfiguration extends EditRecord
{
    protected static string $resource = PageConfigurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Ensure content is properly formatted for the form
        if (isset($data['content']) && \is_string($data['content'])) {
            $data['content'] = json_decode($data['content'], true);
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure content is stored as JSON
        if (isset($data['content']) && \is_array($data['content'])) {
            // Remove empty values from arrays
            $data['content'] = $this->cleanEmptyValues($data['content']);
        }

        return $data;
    }

    private function cleanEmptyValues(array $data): array
    {
        foreach ($data as $key => $value) {
            if (\is_array($value)) {
                $data[$key] = $this->cleanEmptyValues($value);
                if (empty($data[$key])) {
                    unset($data[$key]);
                }
            } elseif ($value === null || $value === '') {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
