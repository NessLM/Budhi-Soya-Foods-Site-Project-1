<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AtopbarAdmin extends Component
{
    public $title;
    public $icon;

    public function __construct($title = 'Dashboard', $icon = 'fa-user-shield')
    {
        $this->title = $title;
        $this->icon = $icon;
    }
    public function render()
    {
        return view('components.admin.atopbar-admin');
    }
}
