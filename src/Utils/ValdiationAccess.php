<?php

namespace App\Utils;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ValdiationAccess extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction("admin", [$this, 'admin'], [
                'is_safe' => ['html'],
                'needs_context' => true
            ])
        ];
    }

    public function admin()
    {
        if (isset($_SESSION['userRole'])) {
            return $_SESSION['userRole'];
        }
        return null;
    }
}
