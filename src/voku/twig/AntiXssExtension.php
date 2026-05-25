<?php

declare(strict_types=1);

namespace voku\twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use voku\helper\AntiXSS;

/**
 * Class AntiXssExtension
 */
class AntiXssExtension extends AbstractExtension
{
  /**
   * @var array<string, bool|array<int, string>>
   */
  private array $options = [
      'is_safe'           => ['html'],
      'needs_environment' => false,
  ];

  private AntiXSS $antiXss;

  /**
   * AntiXssExtension constructor.
   *
   * @param AntiXSS $antiXss
   */
  public function __construct(AntiXSS $antiXss)
  {
    $this->antiXss = $antiXss;
  }

  /**
   * @param string|null $html
   */
  public function xss_clean(?string $html): string
  {
    if ($html === null) {
      return '';
    }

    return $this->antiXss->xss_clean($html);
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  /**
   * @return array<int, TwigFilter>
   */
  public function getFilters(): array
  {
    return [
        new TwigFilter('xss_clean', [$this, 'xss_clean'], $this->options),
    ];
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  /**
   * @return array<int, TwigFunction>
   */
  public function getFunctions(): array
  {
    return [
        new TwigFunction('xss_clean', [$this, 'xss_clean'], $this->options),
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
