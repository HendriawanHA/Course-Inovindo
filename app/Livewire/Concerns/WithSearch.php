<?php

namespace App\Livewire\Concerns;

use Livewire\Attributes\Url;

trait WithSearch
{
    #[Url(as: 'search', except: '')]
    public string $search = '';

    public function clearSearch(): void
    {
        $this->search = '';
    }

    protected function searchTerm(): string
    {
        return trim($this->search);
    }
}
