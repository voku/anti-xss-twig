<?php

declare(strict_types=1);

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
  private $options = [
      'is_safe'           => ['html'],
      'needs_environment' => false,
  ];

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
    $this->callable = [$this, 'xss_clean'];
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
  public function getFilters(): array
  {
    return [
        new \Twig_SimpleFilter('xss_clean', $this->callable, $this->options),
    ];
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function getFunctions(): array
  {
    return [
        new \Twig_SimpleFunction('xss_clean', $this->callable, $this->options),
    ];
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function getTokenParsers(): array
  {
    return [
        new AntiXssTokenParser(),
    ];
  }
}
