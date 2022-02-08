<?php

/**
 *
 * @package    UmcuListener
 * @subpackage Clover\Queue\Action
 * @author     Matijs de Jong <mjong@magnafacta.nl>
 * @copyright  Copyright (c) 2019, Erasmus MC and MagnaFacta B.V.
 * @license    No free license, do not copy
 */

namespace UmcuListener\Clover\Queue\Action;

use Gems\Clover\Queue\Action\SaveAppointmentAction as GemsSaveAppointmentAction;
use Gems\HL7\Node\Message;
use Gems\HL7\Segment\PIDSegment;
use Gems\HL7\Segment\SCHSegment;


/**
 *
 * @package    UmcuListener
 * @subpackage Clover\Queue\Action
 * @copyright  Copyright (c) 2019, Erasmus MC and MagnaFacta B.V.
 * @license    No free license, do not copy
 * @since      Class available since version 1.8.6 11-Sep-2019 11:16:36
 */
class SaveAppointmentAction extends GemsSaveAppointmentAction
{
    /**
     * Return true if this action is triggered by this message
     *
     * @param int $messageId
     * @param Message $message
     * @return boolean
     * /
    public function isTriggered($messageId, Message $message)
    {
        if (! parent::isTriggered($messageId, $message)) {
            return false;
        }

        if ($message->getSchSegment() instanceof SCHSegment) {
            $row = $this->_extractor->extractRow($message);
            // print_r($row);

            if (isset($row['gap_activity'])) {
                // Only save as appointment has 'schisis' in the activity
                return false !== stripos($row['gap_activity'], 'schisis');
            }
        }

        return false;
    } // */
}
