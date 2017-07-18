#!/usr/bin/env bash

sqlite3 dss_acceptance.db "CREATE TABLE test (id INT NOT NULL PRIMARY KEY, value VARCHAR(255)); INSERT INTO test (id, value) VALUES (1, 'foo')";
