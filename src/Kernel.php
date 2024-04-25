<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * The kernel is the heart of the Symfony system.
 */
class Kernel extends BaseKernel {
  use MicroKernelTrait;

}
