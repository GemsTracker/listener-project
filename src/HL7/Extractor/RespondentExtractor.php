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

use Gems\HL7\Extractor\RespondentExtractor as GemsExtractor;

/**
 *
 * @package    UmcuListener
 * @subpackage HL7\Extractor
 * @copyright  Copyright (c) 2016, Erasmus MC and MagnaFacta B.V.
 * @license    No free license, do not copy
 * @since      Class available since version 1.8.1 Oct 22, 2016 3:39:49 PM
 */
class RespondentExtractor extends GemsExtractor
{
    /**
     *
     * @var string Default country and language code
     */
    public $defaultCountry = 'NL';

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
     * @var string Reception code for deceased patients
     */
    protected $receptionCodeDeceased = 'stop';

    /**
     * The authority id for the Social Security number, SSN is not returned when empty
     *
     * @var string
     */
    protected $ssnAuthority = 'NLVWS';

    /**
     *
     * @return string Or false when should not be used
     */
    protected function _extractCountry()
    {
        // Overrule other languages
        return $this->defaultCountry;
    }

    /**
     *
     * @return string Or false when should not be used
     */
    protected function _extractLanguage()
    {
        // Overrule other languages
        return $this->defaultCountry;
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
     * Return the second home phone
     * 
     * @return string Or false when should not be used
     */
    protected function _extractPhoneBusiness()
    {
        // Add phone numbers in preferred order
        $xtns[] = $this->pid->getPhoneHome('PRN', 'PH');
        $xtns[] = $this->pid->getPhoneHome('PRN', 'CP');
        $xtns[] = $this->pid->getPhoneHome('ORN', 'PH');
        $xtns[] = $this->pid->getPhoneHome('ORN', 'CP');

        /** @var $xtns XTN[] */
        // Get the phone numbers if possible
        $phones = [];
        foreach($xtns as $xtn) {
            if (!is_null($xtn)) {
                $phones[] = $xtn->getPhoneNumber();
            }
        }

        $phones = array_filter($phones);
        array_shift($phones);
        $phone  = reset($phones);

        return $phone;
    }
}
