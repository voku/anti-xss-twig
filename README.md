[![Build Status](https://travis-ci.org/voku/anti-xss-twig.svg?branch=master)](https://travis-ci.org/voku/anti-xss-twig)
[![Coverage Status](https://coveralls.io/repos/github/voku/anti-xss-twig/badge.svg?branch=master)](https://coveralls.io/github/voku/anti-xss-twig?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/voku/anti-xss-twig/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/voku/anti-xss-twig/?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/0497e1f5be2d43a08c0a108dc7192287)](https://www.codacy.com/app/voku/anti-xss-twig?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=voku/anti-xss-twig&amp;utm_campaign=Badge_Grade)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/40d6318a-64fc-4927-8438-c57b0f546949/mini.png)](https://insight.sensiolabs.com/projects/40d6318a-64fc-4927-8438-c57b0f546949)
[![Latest Stable Version](https://poser.pugx.org/voku/anti-xss-twig/v/stable)](https://packagist.org/packages/voku/anti-xss-twig) 
[![Total Downloads](https://poser.pugx.org/voku/anti-xss-twig/downloads)](https://packagist.org/packages/voku/anti-xss-twig) 
[![Latest Unstable Version](https://poser.pugx.org/voku/anti-xss-twig/v/unstable)](https://packagist.org/packages/voku/anti-xss-twig)
[![License](https://poser.pugx.org/voku/anti-xss-twig/license)](https://packagist.org/packages/voku/anti-xss-twig)

# AntiXSS for Twig

## Description

A [Twig](http://twig.sensiolabs.org/) extension for [voku/anti-xss](https://github.com/voku/anti-xss).

Currently supported Twig features are:

* Tag
    * `{% xss_clean %} <foo>bar</foo> {% end_xss_clean %}`
* Function
    * `{{ xss_clean(' <foo>bar</foo>') }}`
* Filter
    * `{{ '<foo>bar</foo>' | xss_clean }}`

* [Installation](#installation)
* [Usage](#usage)
* [History](#history)
* [License](#license)

## Installation

1. Install and use [composer](https://getcomposer.org/doc/00-intro.md) in your project.
2. Require this package via composer:

```sh
composer require voku/anti-xss-twig
```

## Usage

First register the extension with Twig:

```php
use voku\helper\AntiXSS;
use voku\twig\AntiXssExtension;

$twig = new Twig_Environment($loader);
$antiXss = new AntiXSS();
$twig->addExtension(new AntiXssExtension($antiXss));
```

Then use it in your templates:

```
{% xss_clean %} <foo>bar</foo> {% end_xss_clean %}
{{ xss_clean(' <foo>bar</foo>') }}
{{ '<foo>bar</foo>' | xss_clean }}
```

```php
$twig->addExtension(new AntiXssExtension($antiXss));
```

## History
See [CHANGELOG](CHANGELOG.md) for the full history of changes.
