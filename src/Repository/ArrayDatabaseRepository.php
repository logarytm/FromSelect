<?php

namespace FromSelect\Repository;

use FromSelect\Repository\Exception\DatabaseNotFoundException;

class ArrayDatabaseRepository implements DatabaseRepository
{
    private $array =[
        'information_schema' => [
            'ALL_PLUGINS',
            'APPLICABLE_ROLES',
            'CHANGED_PAGE_BITMAPS',
            'CHARACTER_SETS',
            'CLIENT_STATISTICS',
            'COLLATIONS',
            'COLLATIONS',
            'COLUMNS',
            'COLUMN_PRIVILEGES',
            'ENABLED_ROLES',
            'ENGINES',
            'EVENTS',
            'FILES',
            'GEOMETRY_COLUMNS',
            'GLOBAL_STATUS',
            'GLOBAL_VARIABLES',
            'INDEX_STATISTICS',
            'INNODB_BUFFER_PAGE',
            'INNODB_BUFFER_PAGE_LRU',
            'INNODB_BUFFER_POOL_STATS',
            'INNODB_CHANGED_PAGES',
            'INNODB_CMP',
            'INNODB_CMPMEM',
            'INNODB_CMPMEM_RESET',
            'INNODB_CMP_PER_INDEX',
            'INNODB_CMP_PER_INDEX_RESET',
            'INNODB_CMP_RESET',
            'INNODB_FT_BEING_DELETED',
            'INNODB_FT_CONFIG',
            'INNODB_FT_DEFAULT_STOPWORD',
            'INNODB_FT_DELETED',
            'INNODB_FT_INDEX_CACHE',
            'INNODB_FT_INDEX_TABLE',
            'INNODB_LOCKS',
            'INNODB_LOCK_WAITS',
            'INNODB_METRICS',
            'INNODB_MUTEXES',
            'INNODB_SYS_COLUMNS',
            'INNODB_SYS_DATAFILES',
            'INNODB_SYS_FIELDS',
            'INNODB_SYS_FOREIGN',
            'INNODB_SYS_FOREIGN_COLS',
            'INNODB_SYS_INDEXES',
            'INNODB_SYS_SEMAPHORE_WAITS',
            'INNODB_SYS_TABLES',
            'INNODB_SYS_TABLESPACES',
            'INNODB_SYS_TABLESTATS',
            'INNODB_TABLESPACES_ENCRYPTION',
            'INNODB_TABLESPACES_SCRUBBING',
            'INNODB_TRX',
            'KEY_CACHES',
            'KEY_COLUMN_USAGE',
            'PARAMETERS',
            'PARTITIONS',
            'PLUGINS',
            'PROCESSLIST',
            'PROFILING',
            'REFERENTIAL_CONSTRAINTS',
            'ROUTINES',
            'SCHEMATA',
            'SCHEMA_PRIVILEGES',
            'SESSION_STATUS',
            'SESSION_VARIABLES',
            'SPATIAL_REF_SYS',
            'STATISTICS',
            'SYSTEM_VARIABLES',
            'TABLES',
            'TABLESPACES',
            'TABLE_CONSTRAINTS',
            'TABLE_PRIVILEGES',
            'TABLE_STATISTICS',
            'TRIGGERS',
            'USER_PRIVILEGES',
            'USER_STATISTICS',
            'VIEWS',
            'XTRADB_INTERNAL_HASH_TABLES',
            'XTRADB_READ_VIEW',
            'XTRADB_RSEG'
        ],
        'performance_schema' => [
            'accounts',
            'cond_instances',
            'events_stages_current',
            'events_stages_history',
            'events_stages_history_long',
            'events_stages_summary_by_account_by_event_name',
            'events_stages_summary_by_host_by_event_name',
            'events_stages_summary_by_thread_by_event_name',
            'events_stages_summary_by_user_by_event_name',
            'events_stages_summary_global_by_event_name',
            'events_statements_current',
            'events_statements_history',
            'events_statements_history_long',
            'events_statements_summary_by_account_by_event_name',
            'events_statements_summary_by_digest',
            'events_statements_summary_by_host_by_event_name',
            'events_statements_summary_by_thread_by_event_name',
            'events_statements_summary_by_user_by_event_name',
            'events_statements_summary_global_by_event_name',
            'events_waits_current',
            'events_waits_history',
            'events_waits_history_long',
            'events_waits_summary_by_account_by_event_name',
            'events_waits_summary_by_host_by_event_name',
            'events_waits_summary_by_instance',
            'events_waits_summary_by_thread_by_event_name',
            'events_waits_summary_by_user_by_event_name',
            'events_waits_summary_global_by_event_name',
            'file_instances',
            'file_summary_by_event_name',
            'file_summary_by_instance',
            'hosts',
            'host_cache',
            'mutex_instances',
            'objects_summary_global_by_type',
            'performance_timers',
            'rwlock_instances',
            'session_account_connect_attrs',
            'session_connect_attrs',
            'setup_actors',
            'setup_consumers',
            'setup_instruments',
            'setup_objects',
            'setup_timers',
            'socket_instances',
            'socket_summary_by_event_name',
            'socket_summary_by_instance',
            'table_io_waits_summary_by_index_usage',
            'table_io_waits_summary_by_table',
            'table_lock_waits_summary_by_table',
            'threads',
            'users'
        ],
        'ranking' => [
            'servers',
            'server_history',
            'server_info',
            'server_votes',
            'server_votes_modifiers',
            'users',
            'user_logs'
        ],
        'test' => [
            ''
        ]
    ];

    /**
     * Returns associative array of database => table[] pairs.
     *
     * @return array
     */
    public function getTree()
    {
        return $this->array;
    }

    /**
     * Returns an array of table's objects in the specified database.
     *
     * @param $name string Database name
     * @return array
     * @throws DatabaseNotFoundException when database with specified name does not exists.
     */
    public function getTablesInDatabase($name)
    {
        if (! array_key_exists($name, $this->array)) {
            throw new DatabaseNotFoundException(sprintf(
                'Database \'%s\' does not exists.',
                $name
            ));
        }

        $tables = $this->array[$name];
        $newTables = [];

        array_walk($tables, function ($table) use (&$newTables) {
            $newTables[$table] = [
                'engine' => rand(0, 1) ? 'MyISAM' : 'InnoDB',
                'collation' => 'utf8_general_ci'
            ];
        });

        return $newTables;
    }
}
