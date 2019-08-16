<?php

use yii\db\Expression;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    const USER = 'user';
    const ROLE = 'roles';
    const EDUCATION = 'education';
    const SCIENTIFIC_ACHIEVEMENT = 'scientific_achievements';
    const USER_HAS_ADDRESS = 'user_has_address';
    const USER_HAS_WORK = 'user_has_work';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable( self::USER, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Имя'),
            'patronymic' => $this->string()->notNull()->comment('Отчество'),
            'surname' => $this->string()->notNull()->comment('Фамилия'),
            'brithday' => $this->integer()->notNull()->comment('День рождения'),
            'sex' => $this->integer()->notNull()->comment('Пол'),
            'education_id' => $this->integer(),
            'role_id' => $this->integer(),
            'username' => $this->string()->notNull()->unique(),
            'scientific achievement_id' => $this->integer(),
            'entity_id' => $this->string()->notNull(),

            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'verification_token' => $this->string()->defaultValue(null),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'is_admin' => $this->boolean()->notNull()->defaultValue(false),


            'date_created' => $this->integer()->notNull(),
            'date_modified' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'modified_by' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
        ], $tableOptions);


        $this->createTable( self::ROLE, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Название'),
            'date_created' => $this->integer()->notNull(),
            'date_modified' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'modified_by' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
        ]);

        $this->batchInsert(self::ROLE, ['title', 'date_created', 'date_modified', 'author_id','modified_by'], [
            ['Участник', new Expression('NOW()'), new Expression('NOW()'),1,1],
            ['Эксперт', new Expression('NOW()'), new Expression('NOW()'),1,1]
            ]);

        $this->createTable( self::EDUCATION, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Название'),
            'date_created' => $this->integer()->notNull(),
            'date_modified' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'modified_by' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
        ]);

        $this->batchInsert(self::ROLE, ['title', 'date_created', 'date_modified', 'author_id','modified_by'], [
            ['Нет', new Expression('NOW()'), new Expression('NOW()'),1,1],
            ['Бакалавр', new Expression('NOW()'), new Expression('NOW()'),1,1],
            ['Магистр', new Expression('NOW()'), new Expression('NOW()'),1,1],
            ['Аспирант', new Expression('NOW()'), new Expression('NOW()'),1,1],
        ]);



        $this->createTable( self::SCIENTIFIC_ACHIEVEMENT, [
            'id' => $this->primaryKey(),
            'academic_degree' => $this->string()->notNull()->comment('Ученая степень'),
            'title' => $this->string()->comment('Научные достижения(премии награды)'),
            'date_created' => $this->integer()->notNull(),
            'date_modified' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'modified_by' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
        ]);



        $this->createTable( self::USER_HAS_ADDRESS, [
            'id' => $this->primaryKey(),
            'user_id'=> $this->integer()->notNull(),
            'region' => $this->string()->comment('Регион проживания'),
            'city' => $this->string()->comment('Город/Населенный пункт'),
            'address' => $this->string()->comment('Адресс регистрации'),
            'date_created' => $this->integer()->notNull(),
            'date_modified' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'modified_by' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
        ]);


        $this->createTable( self::USER_HAS_WORK, [
            'id' => $this->primaryKey(),
            'user_id'=> $this->integer()->notNull(),
            'organization' => $this->string()->notNull()->comment('Организация'),
            'position' => $this->string()->comment('Должность'),
            'phone_number' => $this->string()->comment('Контактный телефон'),
            'is_work abroad' => $this->boolean()->comment('В настоящее время не работаю в РФ'),
            'date_created' => $this->integer()->notNull(),
            'date_modified' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'modified_by' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
        ]);
    }

    public function down()
    {
        if (YII_ENV != 'dev')
            return false;

        $this->dropTable(self::USER);
        $this->dropTable(self::ROLE);
        $this->dropTable(self::ROLE);
        $this->dropTable(self::ROLE);
        $this->dropTable(self::ROLE);
    }
}
