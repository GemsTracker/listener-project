<?php

/**
 *
 * @package    UmcuListener
 * @subpackage HL7
 * @author     Matijs de Jong <mjong@magnafacta.nl>
 * @copyright  Copyright (c) 2016 FrieslandListener
 * @license    No free license, do not copy
 */

namespace UmcuListener\HL7\Segment;

use Gems\HL7\Segment\PIDSegment as GemsPID;
use UmcuListener\HL7\Type\XTN;

/**
 *
 *
 * @package    UmcuListener
 * @subpackage HL7
 * @copyright  Copyright (c) 2016 FrieslandListener
 * @license    Not licensed, do not copy
 * @since      Class available since version 1.8.1 Oct 18, 2016 7:32:55 PM
 */
class PIDSegment extends GemsPID
{
    /**
     *
     * @param type $idx
     * @return XTN[]
     */
    protected function _getXTN($idx)
    {
        $result = array();
        if($items = $this->get($idx)) {
            foreach ($items as $item) {
                $result[] = new XTN($item);
            }
        }

        return $result;
    }
}
