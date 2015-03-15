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

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function query( $value )
    {
        /** @var \PServerCMS\Entity\Repository\Users $repo */
        $repo = $this->getObjectRepository();
        return !(bool) $repo->isUserValid4UserName( $value );
    }
}