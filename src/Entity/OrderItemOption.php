<?php

declare(strict_types=1);

namespace Brille24\CustomerOptionsPlugin\Entity;

use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\CustomerOptionInterface;
use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\CustomerOptionValueInterface;
use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\CustomerOptionValuePriceInterface;
use Sylius\Component\Channel\Model\ChannelInterface;

class OrderItemOption implements OrderItemOptionInterface
{
    /** @var int|null */
    private $id;

    /** @var OrderItemInterface */
    private $orderItem;

    /** @var CustomerOptionInterface|null */
    private $customerOption;

    /** @var string */
    private $customerOptionCode;

    /** @var string */
    private $customerOptionName;

    /** @var CustomerOptionValueInterface|null */
    private $customerOptionValue;

    /** @var string */
    private $customerOptionValueCode;

    /** @var string */
    private $customerOptionValueName;

    /** @var string */
    private $optionValue;

    /** @var int */
    private $fixedPrice = 0;

    public function __construct(
        CustomerOptionInterface $customerOption,
        $customerOptionValue,
        ChannelInterface $channel
    ) {
        // Copying the customer Option
        $this->customerOption     = $customerOption;
        $this->customerOptionCode = $customerOption->getCode();
        $this->customerOptionName = $customerOption->getName();

        // Copying the customer option value
        if (is_scalar($customerOptionValue)) {
            $this->optionValue = $customerOptionValue;
        } elseif ($customerOptionValue instanceof CustomerOptionValueInterface) {
            $this->customerOptionValue     = $customerOptionValue;
            $this->customerOptionValueCode = $customerOptionValue->getCode();
            $this->customerOptionValueName = $customerOptionValue->getName();

            //Getting the right price based on channel
            $price = null;

            /** @var CustomerOptionValuePriceInterface $price */
            foreach ($customerOptionValue->getPrices() as $price){
                if($price->getChannel() === $channel){
                    break;
                }
            }

            $this->fixedPrice              = $price->getAmount() ?? 0;
        }
    }

    /** {@inheritdoc} */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return OrderItemInterface
     */
    public function getOrderItem(): OrderItemInterface
    {
        return $this->orderItem;
    }

    /**
     * @param OrderItemInterface $orderItem
     */
    public function setOrderItem(OrderItemInterface $orderItem): void
    {
        $this->orderItem = $orderItem;
    }

    /** {@inheritdoc} */
    public function getCustomerOption(): ?CustomerOptionInterface
    {
        return $this->customerOption;
    }

    /** {@inheritdoc} */
    public function setCustomerOption(?CustomerOptionInterface $customerOption): void
    {
        $this->customerOption = $customerOption;
    }

    /** {@inheritdoc} */
    public function getOptionValue(): string
    {
        return $this->optionValue;
    }

    /** {@inheritdoc} */
    public function setOptionValue(string $optionValue): void
    {
        $this->optionValue = $optionValue;
    }

    /** {@inheritdoc} */
    public function getCustomerOptionCode(): string
    {
        return $this->customerOptionCode;
    }

    /** {@inheritdoc} */
    public function setCustomerOptionCode(string $customerOptionCode): void
    {
        $this->customerOptionCode = $customerOptionCode;
    }

    /** {@inheritdoc} */
    public function getCustomerOptionValue(): ?CustomerOptionValueInterface
    {
        return $this->customerOptionValue;
    }

    /** {@inheritdoc} */
    public function setCustomerOptionValue(?CustomerOptionValueInterface $customerOptionValue): void
    {
        $this->customerOptionValue = $customerOptionValue;
    }

    /** {@inheritdoc} */
    public function getCustomerOptionValueCode(): string
    {
        return $this->customerOptionValueCode;
    }

    /** {@inheritdoc} */
    public function setCustomerOptionValueCode(string $customerOptionValueCode): void
    {
        $this->customerOptionValueCode = $customerOptionValueCode;
    }

    /** {@inheritdoc} */
    public function getCustomerOptionName(): string
    {
        return $this->customerOptionName;
    }

    /** {@inheritdoc} */
    public function getCustomerOptionValueName(): string
    {
        return $this->customerOptionValueName ?? $this->optionValue;
    }

    /** {@inheritdoc} */
    public function setFixedPrice(int $price): void
    {
        $this->fixedPrice = $price;
    }

    /** {@inheritdoc} */
    public function getFixedPrice(): int
    {
        return $this->fixedPrice;
    }

    /** {@inheritdoc} */
    public function setCustomerOptionName(string $customerOptionName): void
    {
        $this->customerOptionName = $customerOptionName;
    }

    /** {@inheritdoc} */
    public function setCustomerOptionValueName(string $customerOptionValueName): void
    {
        $this->customerOptionValueName = $customerOptionValueName;
    }

    /** {@inheritdoc} */
    public function getScalarValue()
    {
        if (is_null($this->optionValue)) {
            return $this->optionValue;
        } else {
            return $this->customerOptionValueCode;
        }
    }

}