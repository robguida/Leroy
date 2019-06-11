<?php
/**
 * Created by PhpStorm.
 * User: Rob via Leroy's ModelMaker
 * Date: 04/18/2019 11:29 AM
 */

namespace LeroyTestResource;

use Leroy\LeDb\LeDbService;
use Leroy\LeMVCS\LeModelAbstract;
use DateTime;


/**
 * Class AddressModel
 * @package LeroyTestResource
 */
class AddressModel extends LeModelAbstract
{
    public $functions_used = [];

    //<editor-fold desc="Getters/Setters Functions">
    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->getData('address_1');
    }

    /**
     * @param string $input
     */
    public function setAddress1($input)
    {
        $this->setData('address_1', $input);
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->getData('city');
    }

    /**
     * @param string $input
     */
    public function setCity($input)
    {
        $this->setData('city', $input);
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->getData('state');
    }

    /**
     * @param string $input
     */
    public function setState($input)
    {
        $this->setData('state', $input);
    }

    /**
     * @return DateTime|string
     */
    public function getDateCreated()
    {
        return $this->getData('date_created');
    }

    /**
     * @param DateTime|string $input
     */
    public function setDateCreated($input)
    {
        $this->setData('date_created', $input);
    }

    /**
     * @return DateTime|string
     */
    public function getDateModified()
    {
        return $this->getData('date_modified');
    }

    /**
     * @param DateTime|string $input
     */
    public function setDateModified($input)
    {
        $this->setData('date_modified', $input);
    }

    /**
     * @return integer
     */
    public function getModifiedById()
    {
        return $this->getData('modified_by_id');
    }

    /**
     * @param integer $input
     */
    protected function setModifiedById($input)
    {
        $this->setData('modified_by_id', $input);
    }


    /**
     * @var LeDbService $db
     */
    public function setDb(LeDbService $db)
    {
        $this->db = $db;
    }
    //</editor-fold>

    /**
     * AddressModel constructor.
     * @param LeDbService|null $db
     */
    public function __construct(LeDbService $db = null)
    {
        if (is_null($db)) {
            $db = LeDbService::init('leroy', 'test_resources/dev1.robguida.com.json');
        }
        parent::__construct($db);
        $this->setModifiedById(rand(10000, 999999));
    }

    //<editor-fold desc="AddressModel Config Functions">
    protected function setPrimaryKey()
    {
        $this->primary_key = 'address_id';
    }

    /**
     * @return string
     */
    public function getAddress1Test()
    {
        $this->functions_used[] = __FUNCTION__;
        return $this->getData('address_1');
    }

    /**
     * @param string $input
     */
    public function setAddress1Test($input)
    {
        $this->functions_used[] = __FUNCTION__;
        $this->setData('address_1', $input);
    }

    /**
     * @return string
     */
    public function getCityTest()
    {
        $this->functions_used[] = __FUNCTION__;
        return $this->getData('city');
    }

    /**
     * @param string $input
     */
    public function setCityTest($input)
    {
        $this->functions_used[] = __FUNCTION__;
        $this->setData('city', $input);
    }

    /**
     * @return string
     */
    public function getStateTest()
    {
        $this->functions_used[] = __FUNCTION__;
        return $this->getData('state');
    }

    /**
     * @param string $input
     */
    public function setStateTest($input)
    {
        $this->functions_used[] = __FUNCTION__;
        $this->setData('state', $input);
    }

    protected function setSchema()
    {
        $this->schema = [
            'address_1' => [
                'type' => 'string',
                'length' => 45,
                'signed' => false,
                'default' => '',
                'extended' => '',
                'callback_get' => 'getAddress1Test',
                'callback_set' => 'setAddress1Test',
            ],
            'city' => [
                'type' => 'string',
                'length' => 45,
                'signed' => false,
                'default' => '',
                'extended' => '',
                'callback_get' => 'getCityTest',
                'callback_set' => 'setCityTest',
            ],
            'state' => [
                'type' => 'string',
                'length' => 45,
                'signed' => false,
                'default' => '',
                'extended' => '',
                'callback_get' => 'getStateTest',
                'callback_set' => 'setStateTest',
            ],
            'date_created' => [
                'type' => 'DateTime',
                'length' => 0,
                'signed' => false,
                'default' => 'CURRENT_TIMESTAMP',
                'extended' => '',
                'callback_get' => null,
                'callback_set' => null,
            ],
            'date_modified' => [
                'type' => 'DateTime',
                'length' => 0,
                'signed' => false,
                'default' => 'CURRENT_TIMESTAMP',
                'extended' => 'on update CURRENT_TIMESTAMP',
                'callback_get' => null,
                'callback_set' => null,
            ],
            'modified_by_id' => [
                'type' => 'integer',
                'length' => 10,
                'signed' => false,
                'default' => '',
                'extended' => '',
                'callback_get' => null,
                'callback_set' => null,
            ],

        ];
    }

    protected function setTableName()
    {
        $this->table_name = 'address';
    }
    //</editor-fold>
}
