# rethinkdbbundle
This Symfony Bundle is created based on https://github.com/tbolier/php-rethink-ql

From a Symfony App can be installed and Injected as a service, in order to create a connection and do the necesary queries

This project started as a personal project to create a symfony's bundle, and since I found RethinkDB and it is an interesting project, I wanted to create a bundle for this.
As base, I researched on already created PHP components to do the connection, and since the code I found is pretty old, and not thought to be used as a bundle, 
I downloaded the project previously mentioned and updated the code to work at Symfony 6 and PHP 8.1.

Test cases:
The test cases are also based on original source, and modified due to deprecated notices.
There are some new methods created for this bundle that will have a test case soon.