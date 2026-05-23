<?php

declare(strict_types=1);

namespace voku\twig;

use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

final class AntiXssTokenParser extends AbstractTokenParser
{
  public function decideAntiXssEnd(Token $token): bool
  {
    return $token->test('end_xss_clean');
  }

  public function getTag(): string
  {
    return 'xss_clean';
  }

  public function parse(Token $token): Node
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
