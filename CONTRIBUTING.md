# How to Contribute

## Pull Requests

1. Create your own [fork](https://help.github.com/articles/fork-a-repo) of this repo
2. Create a new branch for each feature or improvement
3. Send a pull request from each feature branch to the **master** branch

It is very important to separate new features or improvements into separate
feature branches, and to send a pull request for each branch. This allows me to
review and pull in new features or improvements individually.

## Style Guide

All pull requests must adhere to the [PSR-12 standard](https://www.php-fig.org/psr/psr-12/).

## Unit Testing

All pull requests must be accompanied by passing PHPUnit unit tests.

[Learn about PHPUnit](https://github.com/sebastianbergmann/phpunit/)

Run the current test suite with:

```sh
composer install
composer test
```
