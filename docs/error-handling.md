# Error handling
By default Phlow is completely transparent when it comes to Exceptions, meaning that Phlow will not attempt to catch or modify any raised Exception. On the contrary, any raised Exceptions are left un-caught and it is up to you on how they can be handled. There are two options to catch and handle Exceptions: 1) using PHP `try-catch` or 2) using Builder's fluent API.

## PHP try-catch
Of course, the first option is to wrap the `execute` method in a try-catch block. 

``` php
// Setup your workflow
try {
  $workflow->execute();
} catch (\Exception $e) {
  // Handle the exception here
}
```

## `catch`, `catchAll` methods
Another option is to define an error handler using Workflow Builder. This will allow you to define an alternative execution path when an Exception is raised.
In such case, the raised Exception will be caught by Phlow and attached to the newly created Error.

``` php
$builder
  ->catchAll()
    ->callback()
    ->end();

```
