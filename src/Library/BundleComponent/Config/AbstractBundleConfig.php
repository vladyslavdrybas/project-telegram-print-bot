<?php

declare(strict_types=1);

namespace App\Library\BundleComponent\Config;

use App\Library\Traits\ConfigAwareTrait;

abstract class AbstractBundleConfig implements ConfigBundleInterface
{
    use ConfigAwareTrait;
}
