<?php

declare(strict_types=1);

namespace voku\twig;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Class AntiXssTokenParser
 */
class AntiXssTokenParser extends AbstractTokenParser
{
  /**
   * @param Token $token
   */
  public function decideAntiXssEnd(Token $token): bool
  {
    return $token->test('end_xss_clean');
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function getTag(): string
  {
    return 'xss_clean';
  }

  /**
   * @param Token $token
   */
  public function parse(Token $token): AntiXssNode
  {
    $lineNumber = $token->getLine();
    $stream = $this->parser->getStream();
    $stream->expect(Token::BLOCK_END_TYPE);
    $body = $this->parser->subparse([$this, 'decideAntiXssEnd'], true);
    $stream->expect(Token::BLOCK_END_TYPE);
    $nodes = ['body' => $body];

    return new AntiXssNode($nodes, [], $lineNumber, $this->getTag());
  }
}
