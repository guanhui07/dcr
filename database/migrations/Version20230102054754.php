<?php

declare(strict_types=1);

namespace database\migrations;

use app\Model\UserModel;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
//use Illuminate\Support\Facades\DB; // 不能用laravel的门面
use Illuminate\Database\Capsule\Manager as DB;
/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230102054754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
//        $test = DB::connection()->select('select 23');
        $test = DB::connection()->query('select 23');
//        $test  = UserModel::query()->limit(1)->get();
        var_dump($test);
        $arr = 23;
        var_dump($arr);die;
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
