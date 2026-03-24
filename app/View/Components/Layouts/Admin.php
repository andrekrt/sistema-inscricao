<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class Admin extends Component
{
    public ?string $title;
    public ?string $pageTitle;
    public ?string $pageSubtitle;

    public function __construct(?string $title = null, ?string $pageTitle = null, ?string $pageSubtitle = null)
    {
        $this->title = $title;
        $this->pageTitle = $pageTitle;
        $this->pageSubtitle = $pageSubtitle;
    }

    public function render(): View
    {
        return view('components.layouts.admin');
    }
}
