<?php

namespace App;

class Validator
{

    public function isNotEmpty($arValue)
    {

        if (is_array($arValue)) {

            foreach ($arValue as $value) {

                if (empty($value)) {

                    return false;

                }

            }

        } else if (empty($arValue)) {

            return false;

        }

        return true;

    }

    public function isNumeric($arValue)
    {

        if (is_array($arValue)) {

            foreach ($arValue as $value) {

                if (!is_numeric($value)) {

                    return false;

                }

            }

        } else if (!is_numeric($arValue)) {

            return false;

        }

        return true;

    }

}
