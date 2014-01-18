# M6 Web SF2 Http Kernel

Add some features to Symfony 2 HttpKernel

## Features

- getKStartTime() method which give the application start time.

In your app/AppKernel.php:

```php
<?php
use M6Web\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    // ...
}
```

- KernelExceptionListener listener catch kernel exceptions events and dispatch another event with status code / response
- KernelTerminateListener listener catch kernel terminate events and dispatch another with start time, route and method

## Launch tests

```shell
$ ./vendor/bin/atoum
```