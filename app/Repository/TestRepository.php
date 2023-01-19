<?php
declare(strict_types = 1);

namespace app\Repository;
//不能用laravel的门面 Illuminate\Support\Facades\DB;
use app\Model\UserModel;
use Illuminate\Database\Capsule\Manager as DB;

class TestRepository
{
    public function fromRepos()
    {
        echo PHP_EOL;
        echo 'test Di';
    }

    public function test1()
    {
        //不推荐
//        return DB::table('user')->where('id', '>', 1)
//            ->orderBy('id', 'desc')->get();
        return UserModel::query()->where('id',11211)->first();
    }

    public static function test2(): bool
    {
        return true;
    }
}