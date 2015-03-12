<?php

namespace PServerCMS\Validator;

class RecordExists extends AbstractRecord
{
    /**
     * @param mixed $value
     *
     * @return bool
     * @throws \Exception
     */
    public function isValid( $value )
    {
        $valid = true;
        $this->setValue( $value );

        $result = $this->query( $value );
        if (!$result) {
            $valid = false;
            $this->error( self::ERROR_NO_RECORD_FOUND );
        }

        return $valid;
    }
}
