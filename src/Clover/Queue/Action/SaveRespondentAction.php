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

use Gems\Clover\Queue\Action\SaveRespondentAction as GemsSaveRespondentAction;
use Gems\HL7\Node\Message;
use Gems\HL7\Segment\PIDSegment;
use Gems\HL7\Segment\SCHSegment;

/**
 *
 * @package    UmcuListener
 * @subpackage Clover\Queue\Action
 * @copyright  Copyright (c) 2019, Erasmus MC and MagnaFacta B.V.
 * @license    No free license, do not copy
 * @since      Class available since version 1.8.6 27-Aug-2019 16:55:22
 */
class SaveRespondentAction extends GemsSaveRespondentAction
{
    /**
     *
     * @var \UmcuListener\HL7\Extractor\AppointmentExtractor
     */
    protected $_appExtractor;


    /**
     * @var \Zalt\Db\TableGateway\TableGateway The message table
     */
    protected $_patientIdTable;

    /**
     *
     * @var \Zalt\Db\DbBridge
     */
    protected $db;

    /**
     * @var string The name of the patientId table
     */
    protected $patientIdTableName = 'gems__respondent2org';

    /**
     * Called after the check that all required registry values
     * have been set correctly has run.
     *
     * @return void
     */
    public function afterRegistry()
    {
        parent::afterRegistry();

        $this->_appExtractor = $this->loader->create('HL7\\Extractor\\AppointmentExtractor');
    }

    /**
     * Return true if this action is triggered by this message
     *
     * @param int $messageId
     * @param Message $message
     * @return boolean
     */
    public function isTriggered($messageId, Message $message)
    {
        $pid = $message->getPidSegment();
        if ($pid instanceof PIDSegment) {
            $row = $this->_extractor->extractRow($message);
            // print_r($row);

//            // Check for minimal age (at least 44 months old
//            $minimalAgeMonths = 44;
//            $birthDay  = \DateTime::createFromFormat('Y-m-d', $row['grs_birthday']);
//            $diff1     = $birthDay->diff(new \DateTime());
//            $inMonths1 = ($diff1->y * 12) + $diff1->m;
//            if ($inMonths1 < $minimalAgeMonths) {
//                if ($this->logFile) {
//                    fwrite($this->logFile, sprintf(
//                            "Patient %s born at %s is less than %d months old.",
//                            $row['gr2o_patient_nr'],
//                            $row['grs_birthday'],
//                            $minimalAgeMonths
//                            ) . PHP_EOL);
//                }
//                // echo $row['grs_birthday'] . ' => ' . $diff1->y . ' ' . $inMonths1 . " Do not save.\n";
//                return false;
//            }
//
//            // Check for maximum age (more than  months old
//            $maximumStart     = new \DateTime('2020-10-10');
//            $maximumAgeMonths = 120;
//            $diff2     = $birthDay->diff($maximumStart);
//            $inMonths2 = ($diff2->y * 12) + $diff2->m;
//            if ($inMonths2 >= $maximumAgeMonths) {
//                if ($this->logFile) {
//                    fwrite($this->logFile, sprintf(
//                                            "Patient %s born at %s was more than %d months old at %s.",
//                                            $row['gr2o_patient_nr'],
//                                            $row['grs_birthday'],
//                                            $maximumAgeMonths,
//                                            $maximumStart->format('Y-m-d')
//                                         ) . PHP_EOL);
//                }
//                // echo $row['grs_birthday'] . ' => ' . $diff2->y . ' ' . $inMonths2 . " Do not save.\n";
//                return false;
//            }
//            // echo $row['grs_birthday'] . ' => ' . $diff2->y . ' ' . $diff2->m . ' ' . $inMonths2 . "\n"; 

            // Is the appointment as schisis appointment?  
            if ($message->getSchSegment() instanceof SCHSegment) {
                return true;
//                $appRow = $this->_appExtractor->extractRow($message);
//                if (isset($appRow['gap_activity'])) {
//                    // Only save as appointment has 'schisis' in the activity
//                    return false !== stripos($appRow['gap_activity'], 'schisis');
//                }
            }

            // Does the patient exists?
            foreach (['gr2o_patient_nr', 'gr2o_id_organization'] as $name) {
                $where[$name] = $row[$name];
            }
            if (! $this->_patientIdTable) {
                $this->_patientIdTable = $this->db->createTableGateway($this->patientIdTableName);
            }

            return (boolean) $this->_patientIdTable->fetchRow($where);
        }

        return false;
    }
}
