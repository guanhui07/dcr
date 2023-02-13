## model 模型

和laravel orm 一致 
## orm model ，使用和laravel orm一致
```php
<?php
declare(strict_types = 1);


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @see https://github.com/illuminate/database
 */
class UserModel extends Model
{
    protected $table = 'user';
}


```

