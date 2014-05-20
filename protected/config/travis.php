<?php

return CMap::mergeArray(
        require(dirname(__FILE__) . '/test.php'), array(
            'components' => array(
                'db' => array(
                    'connectionString' => 'mysql:host=localhost;dbname=cmstest',
                ),
            ),
        )
);
