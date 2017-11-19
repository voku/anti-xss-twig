<?php

declare(strict_types=1);

namespace voku\twig;

use Twig_Node;

/**
 * Class AntiXssNode
 */
class AntiXssNode extends Twig_Node
{
  /**
   * AntiXssNode constructor.
   *
   * @param array $nodes
   * @param array $attributes
   * @param int   $lineno
   * @param null  $tag
   */
  public function __construct(array $nodes = [], array $attributes = [], $lineno = 0, $tag = null)
  {
    parent::__construct($nodes, $attributes, $lineno, $tag);
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  /**
   * @param \Twig_Compiler $compiler
   */
  public function compile(\Twig_Compiler $compiler)
  {
    $compiler
        ->addDebugInfo($this)
        ->write("ob_start();\n")
        ->subcompile($this->getNode('body'))
        ->write('$extension = $this->env->getExtension(\'\\voku\\twig\\AntiXssExtension\');' . "\n")
        ->write('echo $extension->xss_clean(ob_get_clean());' . "\n");
  }
}
