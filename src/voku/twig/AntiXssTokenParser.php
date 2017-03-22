<?php

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
  public function decideAntiXssEnd(Twig_Token $token)
  {
    return $token->test('end_xss_clean');
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function getTag()
  {
    return 'xss_clean';
  }

  /**
   * @param Twig_Token $token
   *
   * @return AntiXssNode
   */
  public function parse(Twig_Token $token)
  {
    $lineNumber = $token->getLine();
    $stream = $this->parser->getStream();
    $stream->expect(Twig_Token::BLOCK_END_TYPE);
    $body = $this->parser->subparse(array($this, 'decideAntiXssEnd'), true);
    $stream->expect(Twig_Token::BLOCK_END_TYPE);
    $nodes = array('body' => $body);

    return new AntiXssNode($nodes, array(), $lineNumber, $this->getTag());
  }
}
