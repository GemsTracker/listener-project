<?php

/**
 *
 * @package    UmcuListener
 * @subpackage HL7\Type
 * @author     Matijs de Jong <mjong@magnafacta.nl>
 * @copyright  Copyright (c) 2019, Erasmus MC and MagnaFacta B.V.
 * @license    No free license, do not copy
 */

namespace UmcuListener\HL7\Type;

use Gems\HL7\Type\XTN as GemsXtn;


/**
 *
 * @package    UmcuListener
 * @subpackage HL7\Type
 * @copyright  Copyright (c) 2019, Erasmus MC and MagnaFacta B.V.
 * @license    No free license, do not copy
 * @since      Class available since version 1.8.6 12-Aug-2019 14:04:24
 */
class XTN extends GemsXtn
{
    public function getEmailAddress()
    {
        if (('NET' == $this->_get(2)) && ('X.400' == $this->_get(3))) {
            return (string) $this->_get(1);
        }
    }
}
