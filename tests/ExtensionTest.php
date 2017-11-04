<?php

use voku\helper\AntiXSS;
use voku\twig\AntiXssExtension;

/**
 * Class ExtensionTest
 */
class ExtensionTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @return array
   */
  public function htmlWithStylesProvider()
  {
    $original = '<a style="color: red;" href=\"\u0001java\u0003script:alert(1)\">CLICK<a>';
    $cleanHtmlTag = '<a style="color: red;">CLICK<a>';
    $cleanHtml = '<a style="color: red;" href="">CLICK<a>';

    $testData = array();
    $testMethods = array(
        'Twig tag'      => '{% xss_clean %}%s{% end_xss_clean %}',
        'Twig function' => "{{ xss_clean('%s') }}",
        'Twig filter'   => "{{ '%s' | xss_clean }}",
    );

    foreach ($testMethods as $testMethod => $testTemplate) {
      $testData[$testMethod] = array(
          str_replace('%s', $original, $testTemplate),
          $original,
          ($testMethod === 'Twig tag' ? $cleanHtmlTag : $cleanHtml),
      );
    }

    return $testData;
  }

  /**
   * @return array
   */
  public function htmlProvider()
  {
    $originalTag = '<a style="color: red;" href=\"\u0001java\u0003script:alert(1)\">CLICK<a><p>lall</p> \'Hello, i try to <script>alert(\'Hack\');</script> your site" ads="onClick();" 555-666-0606" K696=TobD([!+!]) ody=\"\'';
    $original = '<a style="color: red;" href=\"\u0001java\u0003script:alert(1)\">CLICK<a>';
    $cleanHtmlTag = '<a >CLICK<a><p>lall</p> \'Hello, i try to alert&#40;\'Hack\'&#41;; your site" ads="TobD([!+!]) ody=\"\'';
    $cleanHtml = '<a  href="">CLICK<a>';

    $testData = array();
    $testMethods = array(
        'Twig tag'      => '{% xss_clean %}%s{% end_xss_clean %}',
        'Twig function' => "{{ xss_clean('%s') }}",
        'Twig filter'   => "{{ '%s' | xss_clean }}",
    );

    foreach ($testMethods as $testMethod => $testTemplate) {
      $test = str_replace('%s', $original, $testTemplate);
      $testTag = str_replace('%s', $originalTag, $testTemplate);

      $testData[$testMethod] = array(
          ($testMethod === 'Twig tag' ? $testTag : $test),
          $original,
          ($testMethod === 'Twig tag' ? $cleanHtmlTag : $cleanHtml),
      );
    }

    return $testData;
  }

  /**
   * @dataProvider htmlProvider
   *
   * @param $template
   * @param $original
   * @param $cleanHtml
   */
  public function testExtensionMethod($template, $original, $cleanHtml)
  {
    $loader = new \Twig_Loader_Array(array('test' => $template));
    $twig = new \Twig_Environment($loader);
    $antiXss = new AntiXSS();
    $twig->addExtension(new AntiXssExtension($antiXss));
    static::assertSame($cleanHtml, $twig->render('test'));
  }

  /**
   * @dataProvider htmlWithStylesProvider
   *
   * @param $template
   * @param $original
   * @param $cleanHtml
   */
  public function testAntiXssKeepStyles($template, $original, $cleanHtml)
  {
    $loader = new \Twig_Loader_Array(array('test' => $template));
    $twig = new \Twig_Environment($loader, array('debug' => true));
    $antiXss = new AntiXSS();
    $antiXss->removeEvilAttributes(array('style')); // allow style-attributes
    $twig->addExtension(new AntiXssExtension($antiXss));
    static::assertSame($cleanHtml, $twig->render('test'));
  }
}
