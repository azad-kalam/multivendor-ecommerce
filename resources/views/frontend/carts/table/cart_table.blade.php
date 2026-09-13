@forelse ($cart_items as $index => $cart_item)
    <tr class="cart-row product-row" data-cart-id="{{ $cart_item['id'] }}">

        <td class="cart-no serial-number">
            {{ $index + 1 }}
        </td>

        <td class="cart-product">
            <div class="product-info">
                <div class="d-flex align-items-center justify-content-center
                            btn btn-outline-success p-1
                            border border-1 border-info rounded"
                    style="width: 50px; height: 50px;">

                    @if (!empty($cart_item['image']))
                        <img src="{{ $cart_item['image'] }}" alt="{{ $cart_item['product_name'] ?? 'Product' }}"
                            class="h-100 w-100 rounded">
                    @else
                        <span class="text-danger">
                            No Image
                        </span>
                    @endif
                </div>
            </div>
        </td>

        <td class="cart-name">
            <span class="product-name">
                {{ $cart_item['product_name'] ?? 'Product Name' }}
            </span>
        </td>

        <td class="variant-name">
            <ul>
                <li>
                    {{ ucwords(strtolower($cart_item['color_name'] ?? 'Color')) }}
                </li>

                <li>
                    {{ $cart_item['size_name'] ?? 'Size' }}
                </li>
            </ul>
        </td>

        <td class="cart-quantity">
            <div class="quantity-box">
                <button type="button" class="qty-minus quantity_down">
                    <i class="bi bi-dash"></i>
                </button>

                <span class="quantity">
                    {{ $cart_item['product_quantity'] ?? 0 }}
                </span>

                <button type="button" class="qty-plus quantity_up">
                    <i class="bi bi-plus"></i>
                </button>
            </div>
        </td>

        <td class="cart-price">
            <span class="product-price">
                <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                {{ number_format($cart_item['price'] ?? 0, 2) }}
            </span>
        </td>

        <td class="cart-price-less">
            <span class="product-price-less">
                <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                {{ number_format(($cart_item['discount'] ?? 0) * ($cart_item['product_quantity'] ?? 1), 2) }}
            </span>
        </td>

        <td class="cart-total">
            <span class="product-total">
                <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                {{ number_format($cart_item['cart_quantity_price'] ?? 0, 2) }}
            </span>
        </td>

        <td class="cart-remove text-center">
            <button type="button" class="btn btn-outline-danger remove-btn" data-cart-id="{{ $cart_item['id'] }}"
                data-url="{{ route('frontend.carts.destroy', $cart_item['id']) }}" aria-label="Remove product">

                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
@empty

    <tr class="empty-cart-row">
        <td colspan="9" class="empty-cart">
            <p class="text-danger">
                Your cart is empty.
            </p>
        </td>
    </tr>
@endforelse
