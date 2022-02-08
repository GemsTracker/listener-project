<?php

/**
 *
 * @package    UmcuListener
 * @subpackage HL7\Extractor
 * @author     Matijs de Jong <mjong@magnafacta.nl>
 * @copyright  Copyright (c) 2016, Erasmus MC and MagnaFacta B.V.
 * @license    No free license, do not copy
 */

namespace UmcuListener\HL7\Extractor;

use Gems\HL7\Extractor\AppointmentExtractor as GemsExtractor;

/**
 *
 * @package    UmcuListener
 * @subpackage HL7\Extractor
 * @copyright  Copyright (c) 2016, Erasmus MC and MagnaFacta B.V.
 * @license    No free license, do not copy
 * @since      Class available since version 1.8.1 Oct 22, 2016 3:39:49 PM
 */
class AppointmentExtractor extends GemsExtractor
{
    /**
     * The organization id for the patient (cannot be extracted from PIDSegment,
     * maybe from MSGSegment.
     *
     * @var int
     */
    protected $organizationId = 72;

    /**
     * The authority id for the patient ID, usually LOCAL
     *
     * @var string
     */
    protected $patientIdAuthority = 'UMCU_I';
    /**
     *
     * @return string Or false when should not be used
     */
    protected function _extractActivity()
    {
        $id   = $this->sch->getAppointmentTypeId();
        $text = ((string) $this->sch->getAppointmentTypeText()) ? : '';

        if ($id) {
            return trim("[{$id}] $text");
        }

        if ($text) {
            return $text;
        }

        return false;
    }


    /**
     *
     * @return string Or false when should not be used
     */
    protected function _extractAttendedBy()
    {
        $cont = $this->sch->getFillerContact();
        if ($cont) {
            return (string) $cont->_get(2);
        }
        return false;
    }

    /**
     *
     * @return string Or false when should not be used
     */
    protected function _extractLocation()
    {
        return $this->sch->getScheduleName();
    }

    /**
     *
     * @return string Or false when should not be used
     */
    protected function _extractOrganizationId()
    {
        if (defined('HL7_ORGANIZATION')) {
            return HL7_ORGANIZATION;
        }
        if ($this->organizationId) {
            return $this->organizationId;
        }

        return parent::_extractOrganizationId();
    }

    /**
     *
     * @return string Or false when should not be used
     */
    protected function _extractProcedure()
    {
        $cont = $this->sch->getAppointmentReason();
        if ($cont) {
            return (string) $cont->_get(2);
        }
        return false;
    }

    /**
     *
     * @return string Or false when should not be used
     */
    protected function _extractReferredBy()
    {
        $cont = $this->sch->getContactPerson();
        if ($cont) {
            return (string) $cont->_get(2);
        }
        return false;
    }
}
