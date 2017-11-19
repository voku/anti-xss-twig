<?php

declare(strict_types=1);

namespace voku\twig;

use Twig_Token;
use Twig_TokenParser;

/**
 * Class AntiXssTokenParser
 */
class AntiXssTokenParser extends Twig_TokenParser
{
  /**
   * @param Twig_Token $token
   *
   * @return bool
   */
  public function decideAntiXssEnd(Twig_Token $token): bool
  {
    return $token->test('end_xss_clean');
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function getTag(): string
  {
    return 'xss_clean';
  }

  /**
   * @param Twig_Token $token
   *
   * @return AntiXssNode
   */
  public function parse(Twig_Token $token): AntiXssNode
  {
    $lineNumber = $token->getLine();
    $stream = $this->parser->getStream();
    $stream->expect(Twig_Token::BLOCK_END_TYPE);
    $body = $this->parser->subparse([$this, 'decideAntiXssEnd'], true);
    $stream->expect(Twig_Token::BLOCK_END_TYPE);
    $nodes = ['body' => $body];

    return new AntiXssNode($nodes, [], $lineNumber, $this->getTag());
  }
}
