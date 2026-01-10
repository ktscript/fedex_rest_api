<?php


namespace FedexRest\Entity;


/**
 * Person entity class for storing contact and address information
 * Used for shipper and recipient information in shipments
 */
class Person
{
    public ?Address $address = null;
    public string $personName = '';
    public int $phoneNumber;

    /**
     * Set the address for this person
     *
     * @param  Address  $address  Address object
     * @return Person
     */
    public function withAddress(Address $address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Set the person's name
     *
     * @param  string  $personName  Full name of the person
     * @return Person
     */
    public function setPersonName(string $personName)
    {
        $this->personName = $personName;
        return $this;
    }

    /**
     * Set the person's phone number
     *
     * @param  int  $phoneNumber  Phone number (digits only, no formatting)
     * @return Person
     */
    public function setPhoneNumber(int $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Prepare person data for API request
     *
     * @return array  Formatted person data array for FedEx API
     */
    public function prepare(): array
    {
        $data = [
            'contact' => (object)
                [
                    'personName' => $this->personName,
                    'phoneNumber' => $this->phoneNumber,
                ],
            'address' => empty($this->address) ? null : $this->address->prepare()
        ];
        return $data;
    }
}
