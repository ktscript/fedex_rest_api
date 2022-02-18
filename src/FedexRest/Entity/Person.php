<?php


namespace FedexRest\Entity;


class Person
{
    public ?Address $address = null;
    public string $personName = '';
    public int $phoneNumber;

    /**
     * @param  mixed  $address
     * @return Person
     */
    public function withAddress(Address $address)
    {
        $this->address = $address;
        return $this;
    }


    /**
     * @param  mixed  $personName
     * @return Person
     */
    public function setPersonName(string $personName)
    {
        $this->personName = $personName;
        return $this;
    }

    /**
     * @param  mixed  $phoneNumber
     * @return Person
     */
    public function setPhoneNumber(int $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return array[]
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
