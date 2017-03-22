<?php

namespace voku\twig;

use voku\helper\AntiXSS;

/**
 * Class AntiXssExtension
 */
class AntiXssExtension extends \Twig_Extension
{
  /**
   * @var array
   */
  private $options = array(
      'is_safe'           => array('html'),
      'needs_environment' => false,
  );

  /**
   * @var callable
   */
  private $callable;

  /**
   * @var AntiXss
   */
  private $antiXss;

  /**
   * AntiXssExtension constructor.
   *
   * @param AntiXSS $antiXss
   */
  public function __construct(AntiXSS $antiXss)
  {
    $this->antiXss = $antiXss;
    $this->callable = array($this, 'xss_clean');
  }

  /**
   * @param string $html
   *
   * @return mixed
   */
  public function xss_clean($html)
  {
    return $this->antiXss->xss_clean($html);
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  /**
   * @return array
   */
  public function getFilters()
  {
    return array(
        new \Twig_SimpleFilter('xss_clean', $this->callable, $this->options),
    );
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function getFunctions()
  {
    return array(
        new \Twig_SimpleFunction('xss_clean', $this->callable, $this->options),
    );
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function getTokenParsers()
  {
    return array(
        new AntiXssTokenParser(),
    );
  }
}
