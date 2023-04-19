<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient;

final class PrestashopClient
{
    public function __construct(
        private Api\CategoriesApiInterface $categoriesApi,
        private Api\CombinationsApiInterface $combinationsApi,
        private Api\ManufacturersApiInterface $manufacturersApi,
        private Api\ProductFeaturesApiInterface $productFeaturesApi,
        private Api\ProductFeatureValuesApiInterface $productFeatureValuesApi,
        private Api\ProductOptionsApiInterface $productOptionsApi,
        private Api\ProductOptionValuesApiInterface $productOptionValuesApi,
        private Api\ProductsApiInterface $productsApi,
        private Api\ShopsApiInterface $shopsApi,
        private Api\StockAvailablesApiInterface $stockAvailablesApi,
        private Api\SuppliersApiInterface $suppliersApi,
        private Api\TaxRuleGroupsApiInterface $taxRuleGroupsApi,
        private Api\TaxRulesApiInterface $taxRulesApi,
    ) {}

    public function getCategoriesApi(): Api\CategoriesApiInterface
    {
        return $this->categoriesApi;
    }
    public function getCombinationsApi(): Api\CombinationsApiInterface
    {
        return $this->combinationsApi;
    }
    public function getManufacturersApi(): Api\ManufacturersApiInterface
    {
        return $this->manufacturersApi;
    }
    public function getProduct_featuresApi(): Api\ProductFeaturesApiInterface
    {
        return $this->productFeaturesApi;
    }
    public function getProduct_feature_valuesApi(): Api\ProductFeatureValuesApiInterface
    {
        return $this->productFeatureValuesApi;
    }
    public function getProduct_optionsApi(): Api\ProductOptionsApiInterface
    {
        return $this->productOptionsApi;
    }
    public function getProduct_option_valuesApi(): Api\ProductOptionValuesApiInterface
    {
        return $this->productOptionValuesApi;
    }
    public function getProductsApi(): Api\ProductsApiInterface
    {
        return $this->productsApi;
    }
    public function getShopsApi(): Api\ShopsApiInterface
    {
        return $this->shopsApi;
    }
    public function getStock_availablesApi(): Api\StockAvailablesApiInterface
    {
        return $this->stockAvailablesApi;
    }
    public function getSuppliersApi(): Api\SuppliersApiInterface
    {
        return $this->suppliersApi;
    }
    public function getTax_rule_groupsApi(): Api\TaxRuleGroupsApiInterface
    {
        return $this->taxRuleGroupsApi;
    }
    public function getTax_rulesApi(): Api\TaxRulesApiInterface
    {
        return $this->taxRulesApi;
    }
}
