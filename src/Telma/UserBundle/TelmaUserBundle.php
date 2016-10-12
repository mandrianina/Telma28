<?php

namespace Telma\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TelmaUserBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }
}
