<?php

namespace Tests;

trait RefreshDatabase
{
    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function refreshDatabase()
    {
        $this->dropAllCollections();
    }

    /**
     * Drop all collections of the testing database.
     *
     * @return void
     */
    public function dropAllCollections()
    {
        $database = $this->app->make('db');

        $this->beforeApplicationDestroyed(function () use ($database) {
            // list all collections here
            $database->dropCollection('users');
        });
    }
}
