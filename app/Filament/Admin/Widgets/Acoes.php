<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class Acoes extends Widget
{
    protected string $view = 'filament.admin.widgets.acoes';

    public function fichaIscricaoExterna()
    {
        return route('pdf.user_inscricao');
    }
}
