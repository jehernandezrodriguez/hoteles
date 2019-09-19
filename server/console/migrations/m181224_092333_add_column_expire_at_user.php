<?php
public function up()
    {
        $ret = $this->db->createCommand("SELECT * FROM information_schema.columns WHERE table_schema = DATABASE()  AND table_name = 'user' AND column_name = 'expire_at'")->queryOne();
        if (empty($ret)) {
            This - > addColumn ('user','expire_at', $this - > integer (11) - > defaultValue (NULL) - > comment ('token expiration time');
        }
    }

    public function down()
    {
        $this->dropColumn('user', 'expire_at');
        return true;
    }
    
 ?>
