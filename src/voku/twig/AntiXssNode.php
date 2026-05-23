<?php

declare(strict_types=1);

namespace voku\twig;

use Twig\Compiler;
use Twig\Node\Node;

final class AntiXssNode extends Node
{
  public function __construct(array $nodes = [], array $attributes = [], int $lineno = 0, ?string $tag = null)
  {
    parent::__construct($nodes, $attributes, $lineno, $tag);
  }

  public function compile(Compiler $compiler): void
  {
    $compiler
        ->addDebugInfo($this)
        ->write("ob_start();\n")
        ->subcompile($this->getNode('body'))
        ->write('$extension = $this->extensions[\'' . AntiXssExtension::class . '\'];' . "\n")
        ->write('echo $extension->xssClean(ob_get_clean());' . "\n");
  }
}
