<?php

namespace App\DTOs;

class CartItemDTO
{
    public function __construct(
        public int $productId,
        public string $productName,
        public float $price,
        public int $quantity,
        public ?string $image = null,
        public ?int $stock = null,
    ) {}

    public function getSubtotal(): float
    {
        return $this->price * $this->quantity;
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'product_name' => $this->productName,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'image' => $this->image,
            'stock' => $this->stock,
            'subtotal' => $this->getSubtotal(),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            productId: (int) $data['product_id'],
            productName: $data['product_name'] ?? '',
            price: (float) $data['price'],
            quantity: (int) $data['quantity'],
            image: $data['image'] ?? null,
            stock: $data['stock'] ?? null,
        );
    }
}
