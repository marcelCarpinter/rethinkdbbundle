# rethinkdbbundle
This Symfony Bundle is created based on https://github.com/tbolier/php-rethink-ql

From a Symfony App can be installed and Injected as a service, in order to create a connection and do the necesary queries

        //Create a new table: $this->rethinkDbBundle->db()->tableCreate('Table')->run()
        //Table List $this->rethinkDbBundle->db()->tableList()->run()->getData()
        //Create DB: $this->rethinkDbBundle->dbCreate('anotherOne')->run()

        /*$feed = $this->rethinkDbBundle
            ->table('Employee')
            ->changes()
            ->run();*/

        //Probar esto:
        //https://github.com/tbolier/php-rethink-ql/blob/master/test/integration/Operation/ChangesTest.php

TODO:
Create test cases