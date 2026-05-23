<?php

declare(strict_types=1);

namespace voku\twig;

use Stringable;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use voku\helper\AntiXSS;

final class AntiXssExtension extends AbstractExtension
{
  private array $options = [
      'is_safe'           => ['html'],
      'needs_environment' => false,
  ];

  private AntiXSS $antiXss;

  public function __construct(AntiXSS $antiXss)
  {
    $this->antiXss = $antiXss;
  }

  public function xssClean(string|Stringable $html): string
  {
    return $this->antiXss->xss_clean((string) $html);
  }

  public function getFilters(): array
  {
    return [
        new TwigFilter('xss_clean', [$this, 'xssClean'], $this->options),
    ];
  }

  public function getFunctions(): array
  {
    return [
        new TwigFunction('xss_clean', [$this, 'xssClean'], $this->options),
    ];
  }

  public function getTokenParsers(): array
  {
    return [
        new AntiXssTokenParser(),
    ];
  }
}
