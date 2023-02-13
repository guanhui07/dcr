<?php
declare(strict_types = 1);
/**
 * The file is part of Dcr/framework
 */

namespace App\Repository;

//不能用laravel的门面 Illuminate\Support\Facades\DB;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Collection;

class TestRepository
{
    public function fromRepos(): void
    {
        echo PHP_EOL;
        echo 'test Di';
    }

    public function test(): Collection
    {
        $allProject = DB::table('airdrop_log_detail')->where('id', '>', 1)
            ->orderBy('id', 'desc')->get();
        //        $allProject = objToArray($allProject);
        debug($allProject);
        return $allProject;
    }

    public static function test2(): bool
    {
        return true;
    }
}
