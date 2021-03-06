[![Build Status](https://travis-ci.org/Designmoves/DesignmovesStrictViewVars.svg?branch=master)](https://travis-ci.org/Designmoves/DesignmovesStrictViewVars)
[![Coverage Status](https://coveralls.io/repos/Designmoves/DesignmovesStrictViewVars/badge.svg?branch=master)](https://coveralls.io/r/Designmoves/DesignmovesStrictViewVars?branch=master)

DesignmovesStrictViewVars
=========================

In Zend Framework 2 view scripts variables can be used like `$this->myVar`. However when a variable does not
exist, there is no warning and it simply returns `null`.

## The `strict_vars` option
The class `Zend\View\Variables` has the ability to set an option called `strict_vars` through the
[`Zend\View\Variables::setStrictVars`](https://github.com/zendframework/zf2/blob/master/library/Zend/View/Variables.php#L70-L80)
method:
```php
/**
 * Set status of "strict vars" flag
 *
 * @param bool $flag
 * @return Variables
 */
public function setStrictVars($flag)
{
    $this->strictVars = (bool) $flag;
    return $this;
}
```
With this option activated (set to `true`), an undefined variable will trigger a notice.
This module makes it possible to set `strict_vars` and allows debugging your code more thoroughly.

## How to use
Copy `designmoves-strict-view-vars.global.php.dist` to your `config/autoload` folder and rename it to
`designmoves-strict-view-vars.global.php`. You can now change the contents of that file to your needs.
