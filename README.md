DesignmovesStrictViewVars
=========================

In Zend Framework 2 view scripts variables can be used like `$this->myVar`. However when a variable does not
exist, there is no warning and it simply returns `null`.

## The `strict_vars` option
The class `Zend\View\Variables` has the ability to set an option called `strict_vars` through the
[`setStrictVars` method](https://github.com/zendframework/zf2/blob/master/library/Zend/View/Variables.php#L70-L80).
With this option activated (set to `true`), an undefined variable will trigger a notice.
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

## The solution
This module makes it possible to set `strict_vars` and allows debugging your code more thoroughly.
