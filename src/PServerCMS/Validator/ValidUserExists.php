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
    public function isValid($value)
    {
        $valid = true;
        $this->setValue($value);

        $result = $this->query($value);
        if (!$result) {
            if ($result === false) {
                $valid = false;
                $this->error(self::ERROR_NOT_ACTIVE);
            } elseif ($this->getKey() != 'NOT_ACTIVE') {
                $valid = false;
                $this->error(self::ERROR_NO_RECORD_FOUND);
            }
        }

        return $valid;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function query($value)
    {
        /** @var \PServerCMS\Entity\Repository\User $repo */
        $repo = $this->getObjectRepository();
        return $repo->isUserValid4UserName($value);
    }
}