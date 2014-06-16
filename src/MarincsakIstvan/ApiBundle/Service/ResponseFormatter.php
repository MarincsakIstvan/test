<?php

namespace MarincsakIstvan\ApiBundle\Service;

use JMS\Serializer\Annotation\Accessor;
use Symfony\Component\Form\Form;

/**
 * Class ResponseFormatter
 * @package MarincsakIstvan\ApiBundle\Service
 */
class ResponseFormatter {

    /**
     * OK státusz kód
     */
    const STATUS_OK = 'OK';

    /**
     * CREATED státusz kód
     */
    const STATUS_CREATED = 'CREATED';

    /**
     * FOUND státusz kód
     */
    const STATUS_FOUND = 'FOUND';

    /**
     * ERROR státusz kód
     */
    const STATUS_ERROR = 'ERROR';

    /**
     * DELETED státusz kód
     */
    const STAUS_DELETED = 'DELETED';

    /**
     * UPDATED státusz kód
     */
    const STATUS_UPDATED = 'UPDATED';

    /**
     * NOT-FOUND státusz
     */
    const STATUS_NOT_FOUND = 'NOT-FOUND';

    /**
     * NOT-FOUND üzenet
     */
    const MSG_NOT_FOUND = 'Entry does not exists';

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * Tárolja a response adat részét, amit majd serializálásra kerül
     *
     * @Accessor(getter="getDataAsArray")
     *
     * @var mixed
     */
    private $data;

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Visszaadja egy tömbben az adattartalmat, akkor is, ha az csak egy elemet tartalmaz
     *
     * @see http://jmsyst.com/libs/serializer/master/reference/annotations
     * @return null|array
     */
    public function getDataAsArray() {
        if($this->data === null) {
            return null;
        }

        if(!is_array($this->data)) {
            return array($this->data);
        }

        return $this->data;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getAllErrorAsString(Form $form) {
        $errors = array();
        foreach($form->getIterator() as $element) {
            $fieldErrors = $element->getErrors();
            if(count($fieldErrors) > 0) {
                foreach($fieldErrors as $fieldError) {
                    $errors[] = $fieldError->getMessage();
                }
            }
        }

        return implode('. ', $errors);
    }


}