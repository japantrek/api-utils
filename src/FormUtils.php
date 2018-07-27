<?php

namespace nvbooster\ApiUtils;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;

/**
 * @author nvb <nvb@aproxima.ru>
 */
class FormUtils
{
    /**
     * @param FormInterface $form
     * @param string        $divisor
     *
     * @return array
     */
    public static function collectErrors(FormInterface $form, $divisor = '_')
    {
        $errors = [];

        /**
         * @var FormError $formError
         */
        foreach ($form->getErrors(true, true) as $formError) {
            $key = self::getErrorKey($formError, $divisor);
            if (empty($errors[$key])) {
                $errors[$key] = [];
            }
            $errors[$key][] = $formError->getMessage();
        }

        return $errors;
    }

    /**
     * @param FormError $error
     * @param string    $divisor
     *
     * @return string
     */
    private static function getErrorKey(FormError $error, $divisor = '_')
    {
        $form = $error->getOrigin();
        $prefixes = [$form->getConfig()->getName()];

        while ($form = $form->getParent()) {
            $prefixes[] = $form->getConfig()->getName();
        }

        return implode($divisor, array_reverse($prefixes));
    }
}
