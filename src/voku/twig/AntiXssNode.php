<?php

declare(strict_types=1);

namespace voku\twig;

use Twig\Compiler;
use Twig\Node\Node;

/**
 * Class AntiXssNode
 */
class AntiXssNode extends Node
{
  /**
   * AntiXssNode constructor.
   */
  public function __construct(array $nodes = [], array $attributes = [], int $lineno = 0, ?string $tag = null)
  {
    parent::__construct($nodes, $attributes, $lineno, $tag);
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function compile(Compiler $compiler): void
  {
    $compiler
        ->addDebugInfo($this)
        ->write("ob_start();\n")
        ->subcompile($this->getNode('body'))
        ->write('$extension = $this->env->getExtension(\'' . AntiXssExtension::class . '\');' . "\n")
        ->write('echo $extension->xss_clean(ob_get_clean());' . "\n");
  }
}
