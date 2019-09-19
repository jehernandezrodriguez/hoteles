<?php
public function up()
    {
        $ret = this - > DB - > createCommand ("SELECT * FROM information_schema. columns WHERE table_schema = DATABASE () and table_name ='user'and column_name ='access_token') - > queryOne (); //Determine whether the user table has the field'access_token'.
        if (empty($ret)) {
            This - > addColumn ('user','access_token', $this - > string (255) - > defaultValue (NULL) - > comment ('token');
        }
    }

    public function down()
    {
        $this->dropColumn('user', 'access_token');
        return true;
    }
    
 ?>
