<?php
namespace App\Services\Contact;

interface IContactService 
{
    public function createContact($data);

    public function getAllContact();

    public function getAllContactCount();

    public function getContactById(int $id);

    public function deleteContactById(int|string $id);

    public function getNewContactCount();

    public function getNewContact();
}