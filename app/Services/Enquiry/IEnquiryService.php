<?php
namespace App\Services\Enquiry;

interface IEnquiryService 
{
    public function createEnquiry($data);

    public function getAllEnquiry();

    public function getAllEnquiryCount();

    public function getEnquiryById(int $id);

    public function deleteEnquiryById(int|string $id);

    public function getNewEnquiryCount();

    public function getNewEnquiry();
}