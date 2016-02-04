See tests.php

=============

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use String\CharChain;

$chars = new CharChain('Hi');

$chars[1]->after('!');

echo $chars, PHP_EOL;

// Hi => Hi!
```

