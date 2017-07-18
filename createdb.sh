#!/usr/bin/env bash

sqlite3 dss_acceptance.db "CREATE TABLE test (id INT NOT NULL PRIMARY KEY, value VARCHAR(255));"
sqlite3 dss_acceptance.db "INSERT INTO test (id, value) VALUES (1, 'value 1'), (2, 'value 2'), (3, 'value 3'), (4, 'value 4'), (5, 'value 5');"
