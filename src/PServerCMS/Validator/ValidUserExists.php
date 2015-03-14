<?php


namespace PServerCMS\Validator;


class ValidUserExists extends AbstractRecord
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
        if ($result) {
            $valid = false;
            $this->error( self::ERROR_NOT_ACTIVE );
        }

        return $valid;
    }
}