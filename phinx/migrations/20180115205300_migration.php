<?php

use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration {
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change() {
		$this->table('auth_token', ['id' => false, 'primary_key' => ['auth_token_id']])
			->addColumn('auth_token_id', 'uuid',     [])
			->addColumn('user_id',       'integer',  ['null' => false])
			->addColumn('token',         'string',   ['limit' => 255, 'null' => false])
			->addColumn('browser',       'text',     ['null' => false])
			->addColumn('created_at',    'datetime', ['null' => false])
			->addColumn('updated_at',    'datetime', ['null' => false])
			->addColumn('deleted_at',    'datetime', ['default' => null, 'null' => true])
			->save();

		$this->table('booking', ['id' => false, 'primary_key' => ['booking_id']])
			->addColumn('booking_id',  'integer',  ['identity' => true])
			->addColumn('room_id',     'integer',  ['null' => false])
			->addColumn('user_id',     'integer',  ['null' => false])
			->addColumn('couple',      'boolean',  ['default' => false, 'null' => false])
			->addColumn('couple_code', 'uuid',     [])
			->addColumn('confirmed',   'boolean',  ['default' => false, 'null' => false])
			->addColumn('paid',        'boolean',  ['default' => false, 'null' => false])
			->addColumn('created_at',  'datetime', ['null' => false])
			->addColumn('updated_at',  'datetime', ['null' => false])
			->addColumn('deleted_at',  'datetime', ['default' => null, 'null' => true])
			->save();

		$this->table('booking_info', ['id' => false, 'primary_key' => ['booking_info_id']])
			->addColumn('booking_info_id', 'integer',  ['identity' => true])
			->addColumn('booking_id',      'integer',  ['null' => false])
			->addColumn('allergies',       'text',     ['null' => false])
			->addColumn('stuff',           'text',     ['null' => false])
			->addColumn('wishes',          'text',     ['null' => false])
			->addColumn('night_hike',      'boolean',  ['default' => false, 'null' => false])
			->addColumn('created_at',      'datetime', ['null' => false])
			->addColumn('updated_at',      'datetime', ['null' => false])
			->save();

		$this->table('gender', ['id' => false, 'primary_key' => ['gender_id']])
			->addColumn('gender_id',   'integer',  ['identity' => true])
			->addColumn('name',        'string',   ['limit' => 255, 'null' => false])
			->addColumn('gender_code', 'string',   ['limit' => 255, 'null' => false])
			->addColumn('created_at',  'datetime', ['null' => false])
			->addColumn('updated_at',  'datetime', ['null' => false])
			->save();

		$this->table('gender')
			->insert([
				[
					'name' => 'männlich',
					'gender_code' => 'male',
				],
				[
					'name' => 'weiblich',
					'gender_code' => 'female'
				]
			])
			->save();

		$this->table('recovery_code', ['id' => false, 'primary_key' => ['recovery_code_id']])
			->addColumn('recovery_code_id', 'integer',  ['identity' => true])
			->addColumn('user_id',          'integer',  ['null' => false])
			->addColumn('code',             'string',   ['limit' => 255, 'null' => false])
			->addColumn('created_at',       'datetime', ['null' => false])
			->addColumn('updated_at',       'datetime', ['null' => false])
			->addColumn('deleted_at',       'datetime', ['default' => null, 'null' => true])
			->save();

		$this->table('room', ['id' => false, 'primary_key' => ['room_id']])
			->addColumn('room_id',      'integer',  ['identity' => true])
			->addColumn('room_type_id', 'integer',  ['null' => false])
			->addColumn('name',         'string',   ['limit' => 255, 'null' => false])
			->addColumn('bed_count',    'integer',  ['null' => false])
			->addColumn('created_at',   'datetime', ['null' => false])
			->addColumn('updated_at',   'datetime', ['null' => false])
			->addColumn('deleted_at',   'datetime', ['default' => null, 'null' => true])
			->save();

		$this->table('room_type', ['id' => false, 'primary_key' => ['room_type_id']])
			->addColumn('room_type_id', 'integer',  ['identity' => true])
			->addColumn('type_code',    'string',   ['limit' => 255, 'null' => false])
			->addColumn('name',         'string',   ['limit' => 255, 'null' => false])
			->addColumn('created_at',   'datetime', ['null' => false])
			->addColumn('updated_at',   'datetime', ['null' => false])
			->addColumn('deleted_at',   'datetime', ['default' => null, 'null' => true])
			->save();

		$this->table('room_type')
			->insert([
				[
					'type_code' => 'normal',
					'name' => 'Normales Zimmer',
				],
				[
					'type_code' => 'female',
					'name' => 'Damenzimmer'
				],
				[
					'type_code' => 'couple',
					'name' => 'Pärchenzimmer'
				]
			])
			->save();

		$this->table('setting', ['id' => false, 'primary_key' => ['setting_id']])
			->addColumn('setting_id',   'integer',  ['identity' => true])
			->addColumn('setting_code', 'string',   ['limit' => 255, 'null' => false])
			->addColumn('value',        'text',     ['null' => false])
			->addColumn('created_at',   'datetime', ['null' => false])
			->addColumn('updated_at',   'datetime', ['null' => false])
			->save();

		$this->table('setting')
			->insert([
				[
					'setting_code' => 'booking_active',
					'value' => '0'
				],
				[
					'setting_code' => 'waiting_list_active',
					'value' => '0'
				]
			])
			->save();

		$this->table('user', ['id' => false, 'primary_key' => ['user_id']])
			->addColumn('user_id',     'integer',  ['identity' => true])
			->addColumn('username',    'string',   ['limit' => 255, 'null' => false])
			->addColumn('password',    'string',   ['limit' => 255, 'null' => false])
			->addColumn('email',       'string',   ['limit' => 255, 'null' => false])
			->addColumn('is_admin',    'boolean',  ['default' => false, 'null' => false])
			->addColumn('created_at',  'datetime', ['null' => false])
			->addColumn('updated_at',  'datetime', ['null' => false])
			->addColumn('deleted_at',  'datetime', ['default' => null, 'null' => true])
			->save();

		$this->table('user_info', ['id' => false, 'primary_key' => ['user_info_id']])
			->addColumn('user_info_id', 'integer',  ['identity' => true])
			->addColumn('user_id',      'integer',  ['null' => false])
			->addColumn('first_name',   'string',   ['limit' => 255, 'null' => false])
			->addColumn('last_name',    'string',   ['limit' => 255, 'null' => false])
			->addColumn('birthday',     'date',     ['null' => false])
			->addColumn('gender_id',    'integer',  ['null' => false])
			->addColumn('created_at',   'datetime', ['null' => false])
			->addColumn('updated_at',   'datetime', ['null' => false])
			->save();

		$this->table('waiting_list', ['id' => false, 'primary_key' => ['waiting_list_id']])
			->addColumn('waiting_list_id', 'integer',  ['identity' => true])
			->addColumn('username',        'string',   ['limit' => 255, 'null' => false])
			->addColumn('email',           'string',   ['limit' => 255, 'null' => false])
			->addColumn('notice',          'text',     ['null' => false])
			->addColumn('created_at',      'datetime', ['null' => false])
			->addColumn('updated_at',      'datetime', ['null' => false])
			->addColumn('deleted_at',      'datetime', ['default' => null, 'null' => true])
			->save();
    }
}
