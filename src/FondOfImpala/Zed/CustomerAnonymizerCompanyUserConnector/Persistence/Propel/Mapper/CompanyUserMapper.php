<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUser;

class CompanyUserMapper implements CompanyUserMapperInterface
{
    /**
     * @param array<\Orm\Zed\CompanyUser\Persistence\SpyCompanyUser> $collection
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function mapCompanyUserCollection(array $collection): CompanyUserCollectionTransfer
    {
        $companyUserCollectionTransfer = new CompanyUserCollectionTransfer();

        foreach ($collection as $companyUserEntity) {
            $companyUserCollectionTransfer->addCompanyUser($this->mapEntityToCompanyUserTransfer($companyUserEntity));
        }

        return $companyUserCollectionTransfer;
    }

    /**
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUser $companyUserEntity
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapEntityToCompanyUserTransfer(
        SpyCompanyUser $companyUserEntity
    ): CompanyUserTransfer {
        $companyUserTransfer = (new CompanyUserTransfer())->fromArray($companyUserEntity->toArray(), true);

        $customerEntity = $companyUserEntity->getCustomer();
        if ($customerEntity !== null) {
            $customerTransfer = (new CustomerTransfer())->fromArray(
                $customerEntity->toArray(),
                true,
            );
            $companyUserTransfer->setCustomer($customerTransfer);
        }

        $companyEntity = $companyUserEntity->getCompany();
        if ($companyEntity !== null) {
            $companyTransfer = (new CompanyTransfer())->fromArray(
                $companyEntity->toArray(),
                true,
            );
            $companyUserTransfer->setCompany($companyTransfer);
        }

        return $companyUserTransfer;
    }
}
